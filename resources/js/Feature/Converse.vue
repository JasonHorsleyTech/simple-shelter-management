<script setup lang="ts">
import { reactive, ref } from "vue";
import axios from "axios";

const userSays = ref<string>("");

const responses = ref<{ type: string; response: Object }[]>([]);

const waiting = reactive<{
    post: boolean;
    response: boolean;
}>({
    post: false,
    response: false,
});

const conversationId = ref<string | null>(null);

type PostResponse = {
    data: {
        type: "post";
        conversation_id: string;
    };
};

/* ---------------------------------------------------------- */

type PingResponse = {
    data: {
        type: "ping";
        prompts: number;
    };
};

/* ---------------------------------------------------------- */

type ActionSpeak = {
    action: "speak";
    payload: {
        text: string;
    };
};
type ActionNavigate = {
    action: "navigate";
    payload: {
        url: string;
        target: string;
    };
};
type ActionFunction = {
    action: "function";
    function_name: string;
    reprompt: boolean;
    payload: Object;
};

type ActionableResponse = {
    data: {
        type: "actionable";
        actions: Array<ActionSpeak | ActionNavigate | ActionFunction>;
        terminal: boolean;
    };
};

const post = async () => {
    waiting.post = true;

    const postResponse = (await axios.post("/api/converse", {
        said: userSays.value,
        confidence: 1,
    })) as PostResponse;

    responses.value.push({ type: "post", response: postResponse });

    conversationId.value = postResponse.data.conversation_id;

    waiting.post = false;

    ping();
};

const ping = () => {
    waiting.response = true;

    const pingInterval = setInterval(async () => {
        const mixedResponse = await axios.get(
            `/api/converse/${conversationId}/ping`
        );

        if (mixedResponse.data.type === "ping") {
            const pingResponse = mixedResponse as PingResponse;
            responses.value.push({ type: "ping", response: pingResponse });
        } else {
            clearInterval(pingInterval);
            responses.value.push({
                type: "actionable",
                response: mixedResponse,
            });
            handle(mixedResponse as ActionableResponse);
            waiting.response = false;
        }
    }, 500);
};

const handle = (actionableResponse: ActionableResponse) => {
    console.log(actionableResponse);
    // Handle it!
};
</script>

<template>
    <div class="grid grid-cols-2 gap-x-4">
        <form
            @submit="post"
            class="grid gap-y-2"
            :disabled="waiting.post || waiting.response"
        >
            <h1 class="text-3xl">User says</h1>

            <textarea
                v-model="userSays"
                class="p-2 text-black font-bold text-lg min-h-[16rem] min-w-[24rem]"
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
                v-for="(response, index) in responses"
                :key="index"
                class="whitespace-pre-wrap border-t first:border-t-0 my-1 py-1"
            >
                {{ response }}
            </pre>
        </div>
    </div>
</template>
