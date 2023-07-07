<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";

import useSpeechSynthesis from "@/Composables/useSpeechSynthesis";

const { speak } = useSpeechSynthesis();
const userSays = ref<string[]>([
    "Hello",
    "My name is Jason",
    "How are you doing today?",
]);

const responses = ref<{ type: string; data: Object }[]>([]);
const log = (type: string, data: Object) => {
    responses.value.push({ type, data });
};

const waiting = reactive<{
    post: boolean;
    response: boolean;
}>({
    post: false,
    response: false,
});

const exchangeId = ref<string | null>(null);

// GPT started thinking
type PostResponse = {
    data: {
        type: "post";
        exchange_id: string;
    };
};

/* ---------------------------------------------------------- */

// GPT still thinking
type ProcessingResponse = {
    data: {
        type: "processing";
    };
};

/* ---------------------------------------------------------- */

// type ActionNavigate = {
//     action: "navigate";
//     url: string;
//     target: string;
// };
// type ActionFunction = {
//     action: "function";
//     execute: string;
//     with: Object;
//     reprompt: boolean;
// };

// GPT is ready to respond
type ActionSpeak = {
    data: {
        action: "speak";
        speak: string;
    };
};

const post = async () => {
    waiting.post = true;

    const postResponse = (await axios.post("/api/vanilla-gpt", {
        transcripts: userSays.value.map((said) => ({ said, confidence: 0.99 })),
    })) as PostResponse;

    log("post", postResponse.data);

    exchangeId.value = postResponse.data.exchange_id;

    waiting.post = false;

    longPoll();
};

const longPoll = () => {
    waiting.response = true;

    const longPollInterval = setInterval(async () => {
        const mixedResponse = await axios.get(
            `/api/larry/exchanges/${exchangeId.value}`
        );

        if (mixedResponse.data.type === "processing") {
            const processingResponse = mixedResponse as ProcessingResponse;
            log("processing", processingResponse.data);
            clearInterval(longPollInterval);
        } else {
            clearInterval(longPollInterval);
            log("actionable", mixedResponse.data);
            handle(mixedResponse as ActionSpeak);
            waiting.response = false;
        }
    }, 500);
};

const handle = (actionSpeak: ActionSpeak) => {
    speak(actionSpeak.data.speak);
};
</script>

<template>
    <div class="grid md:grid-cols-2 gap-4 p-4">
        <p class="md:col-span-2">
            Conversation dictated by logic in "VanillaGPTController". For this
            one in particular, it's just a duplicate to regular old ChatGPT
        </p>

        <form
            @submit.prevent="post"
            class="grid gap-y-2"
            :disabled="waiting.post || waiting.response"
        >
            <h1 class="text-3xl">User says</h1>

            <input
                v-for="(said, index) in userSays"
                v-model="userSays[index]"
                type="text"
                class="p-2 text-black font-bold text-lg"
            />

            <div class="flex justify-end">
                <input
                    type="submit"
                    class="bg-green-500 rounded-lg p-4 hover:bg-green-400 cursor-pointer"
                />
            </div>
        </form>

        <div class="grid gap-y-2">
            <h1 class="text-3xl">Log</h1>

            <pre
                v-for="({ type, data }, index) in responses"
                :key="index"
                class="whitespace-pre-wrap border-t first:border-t-0 my-1 py-1"
                v-text="data"
            />
        </div>
    </div>
</template>
