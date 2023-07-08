<script lang="ts" setup>
import LarryIcon from "@/Larry/images/larry-icon.png";

import axios from "axios";

import { ref } from "vue";
import { onMounted } from "vue";
import { watch } from "vue";
import { computed } from "vue";

const browserCompatible = ref<boolean | null>(null);

const emit = defineEmits(["initiate-mode"]);

// Is the user holding the "talk" button?
const holdingTheFloor = ref<boolean>(false);

// Are we waiting for something the user said to come back to us as text?
const recognizing = ref<boolean>(false);

// Are we playing a gpt through a voice synth to the user?
const talking = ref<boolean>(false);

// What we heard the user say.
const transcripts = ref<{ said: string; confidence: number }[]>([]);

// Stop context menu on mobile
const buttonRef = ref<HTMLDivElement | null>(null);

// TODO: Figure this out
/**
 * Thinking...
 *
 * Would probably be better to expose slots where possible. We could have a slot for "pressed, thinking, talking, listening, etc".
 *
 * The only real props would be
 *
 * api path
 * "hey larry" (always listening mode?)
 * idunno man
 */
type LarryOptions = {
    minimal?: boolean;
    mode?: boolean;
};
const props = defineProps<{ options: LarryOptions }>();
export type { LarryOptions };

onMounted(() => {
    // @ts-ignore
    browserCompatible.value = !!window.webkitSpeechRecognition;
    if (!browserCompatible.value) {
        return;
    }

    buttonRef.value?.addEventListener("contextmenu", (event: MouseEvent) => {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        return false;
    });
});

const recognition = ref<SpeechRecognition>(
    new window.webkitSpeechRecognition()
);
recognition.value.continuous = true;
recognition.value.interimResults = false;

recognition.value.onaudiostart = () => {
    recognizing.value = true;
};

recognition.value.onresult = (event: SpeechRecognitionEvent) => {
    const result = event.results[event.results.length - 1][0];

    transcripts.value.push({
        said: result.transcript,
        confidence: result.confidence,
    });

    recognizing.value = false;

    if (!holdingTheFloor.value) process();
};

// Speech recognition times out after X seconds of silence.
// If they're still holding the "talk" button, restart it.
recognition.value.onend = () => {
    if (holdingTheFloor.value) recognition.value.start();
};

// Start listening when they press the button.
watch(holdingTheFloor, (holding) => {
    if (holding && !recognizing.value) {
        recognition.value.start();
        return;
    } else {
        recognition.value.stop();
    }

    if (recognizing.value === true) {
        // process will happen inside recognition.value.onresult
        return;
    }

    process();
});

// Colors and sizes to communicate the complicated "state" of the listening talking device.
const classList = computed(() => {
    if (holdingTheFloor.value) {
        return "bg-red-500/50 text-green-800 w-[45px] h-[45px]";
    }
    if (recognizing.value) {
        return "bg-red-500/50 text-yellow-200 w-[45px] h-[45px]";
    }

    return "group-hover:bg-green-500/25 group-hover:text-white group-hover:w-[55px] group-hover:h-[55px]";
});

type Action = {
    function: string;
};
type Exchange = {
    user_transcript: string;
    assistant_verbal_response?: string;
    assistant_action?: Action;
};
const process = async () => {
    const response = (await axios.post("/", {
        exchange: {
            user_transcripts: transcripts.value,
        },
    })) as { data: Exchange };

    // const actionable: {
    //     content: null | string;
    //     functionCall: null | object;
    //     role: "assistant";
    // } = response.data;

    // TODO: Speech synth for response, or initiate mode if we get that fnc call back, and
    // const synth = window.speechSynthesis;
    // const utterThis = new SpeechSynthesisUtterance(actionable.content);
    // utterThis.onend = () => {
    //     talking.value = false;
    // };
    // synth.speak(utterThis);

    transcripts.value = [];
};
</script>

<template>
    <p v-if="!browserCompatible">
        Your browser doesn't support speech recognition. Please use Chrome,
        Edge, or Safari.
    </p>

    <div
        v-else
        class="grid place-content-center touch-none user-select-none group h-[85px] w-[85px] mx-auto"
        ref="buttonRef"
        @mousedown="holdingTheFloor = true"
        @mouseup="holdingTheFloor = false"
        @touchstart="holdingTheFloor = true"
        @touchend="holdingTheFloor = false"
    >
        <div
            class="cursor-pointer border border-green-500 bg-green-200/25 rounded-full w-[50px] h-[50px] text-green-500 transition-all"
            :class="[classList]"
        >
            <img :src="LarryIcon" />
        </div>
    </div>
</template>
