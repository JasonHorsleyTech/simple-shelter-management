<script setup lang="ts">
/* -------------------------------------------------------------------------- */
/*       For demo purposes only. Shows how you might roll your own input      */
/* -------------------------------------------------------------------------- */

import { ref } from "vue";
import axios from "axios";
import resolveDemoTranscripts from "../Composables/resolveDemoTranscripts";

// Each conversation has it's own "entrance" route. EG, web.php has /weatherman which points to that specific assistant prompt and function
const props = defineProps<{
    assistant: {
        name: string;
        route: string;
        description: string;
    };
}>();

type Payload = {
    transcripts: { said: string; confidence: number }[];
};
type ResponseData = {
    status: "gpt-initiated" | "gpt-processing" | "gpt-finished";
    url: string;
    speak?: string;
};

const waiting = ref<boolean>(false);

const conversationRoute = ref<string | null>(props.assistant.route);
const userSays = resolveDemoTranscripts(props.assistant.name);

type Exchange = {
    who: "user" | "assistant";
    what: string;
};
const previousExchanges = ref<Exchange[]>([]);

const responses = ref<{ type: string; data: ResponseData }[]>([]);
const log = (type: string, response: { data: ResponseData }) => {
    responses.value.unshift({ type, data: response.data });
};

/**
 * Conversation flow
 *
 * 1. Send in array of transcripts
 * 2. Poll response URL until it's finished
 * 3. Speak response, set new URL
 *
 * Keeping the front as "dumb" as possible. Every response sends the URL required to "continue" the conversation.
 * The backend (GPT) can pick where the conversation should go, or decide if the conversation is finished. But regardless
 * The front and just "Post here, poll here, re-post here".
 */
const post = async () => {
    waiting.value = true;

    const payload = {
        transcripts: userSays.value.map((said) => ({
            said,
            confidence: 0.99,
        })),
    } as Payload;

    const postResponse = (await axios.post(
        conversationRoute.value,
        payload
    )) as { data: ResponseData };

    log("post", postResponse);
    previousExchanges.value.push({
        who: "user",
        what: userSays.value.join(" "),
    });
    userSays.value = [""];
    conversationRoute.value = postResponse.data.url;

    const longPollInterval = setInterval(async () => {
        const pollResponse = await axios.get(conversationRoute.value);

        if (pollResponse.data.status !== "gpt-finished") {
            return log("poll", pollResponse);
        }

        clearInterval(longPollInterval);
        log("speak", pollResponse);
        previousExchanges.value.push({
            who: "assistant",
            what: pollResponse.data.speak ?? "No response",
        });
        conversationRoute.value = pollResponse.data.url;

        waiting.value = false;
    }, 500);
};
</script>

<template>
    <div class="grid md:grid-cols-2 gap-4 p-4">
        <p class="md:col-span-2 h-16">
            Conversation dictated by logic in "assistants/greeter". For this one
            in particular, it's just a duplicate to regular old ChatGPT
        </p>

        <form
            @submit.prevent="post"
            class="flex flex-col gap-y-2"
            :disabled="waiting"
        >
            <h1 class="md:text-3xl">Conversation</h1>

            <p
                v-for="({ who, what }, index) in previousExchanges"
                :key="index"
                v-text="`${who}: ${what}`"
            />

            <input
                v-for="(said, index) in userSays"
                v-model="userSays[index]"
                type="text"
                class="p-2 text-black font-bold md:text-lg"
            />

            <div class="flex justify-end">
                <input
                    type="submit"
                    :disabled="waiting"
                    class="bg-green-500 rounded-lg p-4 hover:bg-green-400 cursor-pointer"
                />
            </div>
        </form>

        <div class="relative">
            <h1 class="text-lg md:text-3xl">Log (recent at top)</h1>

            <pre
                v-for="({ data }, index) in responses"
                :key="index"
                class="whitespace-pre-wrap border-b last:border-b-0 my-1 py-1"
                v-text="data"
            />

            <!-- <div
                class="absolute bottom-0 w-full h-32 bg-gradient-to-b from-transparent to-gray-800 pointer-events-none"
            /> -->
        </div>
    </div>
</template>
