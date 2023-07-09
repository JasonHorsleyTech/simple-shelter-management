<script lang="ts" setup>
import axios from "axios";

import { ref } from "vue";
import { onMounted } from "vue";
import { watch } from "vue";
import { computed } from "vue";

import Speaker from "@/Classes/Speaker";
import LarryIcon from "@/Larry/images/icon-larry.png";
import SpinnerIcon from "@/Larry/images/icon-spinner.png";
import SpeakerIcon from "@/Larry/images/icon-speaker.png";
import WaveformVisualizer from "@/Larry/Components/WaveformVisualizer.vue";

type LarryOptions = {
    path?: string;
    wrapperClasses?: string;
    buttonClasses?: string;
};
export type { LarryOptions };
const props = withDefaults(defineProps<LarryOptions>(), {
    path: "/api/larry",
    wrapperClasses:
        "group cursor-pointer grid place-content-center touch-none user-select-none h-32 w-32 mx-auto ",
    buttonClasses: `
        relative cursor-pointer border border-green-500 bg-green-200/25 rounded-full text-green-500 transition-all

        group-data-[mode=holding]:bg-red-500/25 group-data-[mode=holding]:text-green-800 group-data-[mode=holding]:scale-95 group-data-[mode=holding]:p-2

        group-data-[mode=recognizing]:bg-yellow-500/50

        group-data-[mode=thinking]:bg-blue-500/25
    `,
});

const browserCompatible = ref<boolean | null>(null);
const buttonRef = ref<HTMLDivElement | null>(null);
onMounted(() => {
    // @ts-ignore
    browserCompatible.value = !!window.webkitSpeechRecognition;
    if (!browserCompatible.value) {
        return;
    }

    // Stop context menu on mobile
    buttonRef.value?.addEventListener("contextmenu", (event: MouseEvent) => {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        return false;
    });
});

// Is the user holding the "talk" button?
const holdingTheFloor = ref<boolean>(false);

// Are we waiting for something the user said to come back to us as text?
const recognizing = ref<boolean>(false);

// Waiting on API
const thinking = ref<boolean>(false);

// Are we playing a gpt through a voice synth to the user?
const speaking = ref<boolean>(false);

// And we're going to do it in that order every time.
// TODO: Interrupts.
// Interrupting speaker should speaking.value = false;
// Interrupting thinking should... Cancel the request? But should it also add the previous recognized back.
// Same for recognizing I think.
const mode = computed(() => {
    return holdingTheFloor.value
        ? "holding"
        : recognizing.value
        ? "recognizing"
        : thinking.value
        ? "thinking"
        : speaking.value
        ? "speaking"
        : "idle";
});

// What we heard the user say.
const transcripts = ref<{ said: string; confidence: number }[]>([]);

/* -------------------------------------------------------------------------- */

const recognition = new window.webkitSpeechRecognition();
recognition.continuous = true;
recognition.interimResults = false;
recognition.onaudiostart = () => {
    recognizing.value = true;
};
recognition.onresult = (event: SpeechRecognitionEvent) => {
    const result = event.results[event.results.length - 1][0];

    transcripts.value.push({
        said: result.transcript,
        confidence: result.confidence,
    });

    recognizing.value = false;

    // They let up on the button a few seconds ago. This is the "final" result to resolve.
    if (!holdingTheFloor.value) {
        recognition.stop();
        process();
    }
};

// Speech recognition times out after X seconds of silence.
// If they're still holding the "talk" button, restart it.
recognition.onend = () => {
    if (holdingTheFloor.value) recognition.start();
};

const speaker = new Speaker();

const process = async () => {
    thinking.value = true;
    const response = (await axios.post(props.path, {
        transcripts: transcripts.value,
    })) as { data: { exchange_id: string } };

    const { data } = await longPoll(response.data.exchange_id);

    speaking.value = true;
    await speaker.utter(data.speak);
    speaking.value = false;
    transcripts.value = [];
};

type SpeechResponse = { data: { type: string; speak: string } };
const longPoll = (exchangeId: string) => {
    return new Promise<SpeechResponse>((resolve) => {
        const longPollInterval = setInterval(async () => {
            const mixedResponse = await axios.get(
                `${props.path}/exchanges/${exchangeId}`
            );

            if (mixedResponse.data.type !== "processing") {
                clearInterval(longPollInterval);
                return resolve(mixedResponse as SpeechResponse);
            }
        }, 500);
    });
};

watch(holdingTheFloor, (holding) => {
    // They started holding the floor but we were already listening? Do nothing.
    // They STOPPED holding the floor but we haven't finished "hearing" it? Do nothing.
    if (recognizing.value) return;

    if (holding) {
        recognition.start();
    } else {
        recognition.stop();
        process();
    }
});
</script>

<template>
    <p v-if="!browserCompatible">
        Your browser doesn't support speech recognition. Please use Chrome,
        Edge, or Safari.
    </p>

    <div
        v-else
        :class="wrapperClasses"
        :data-mode="mode"
        ref="buttonRef"
        @mousedown="holdingTheFloor = true"
        @mouseup="holdingTheFloor = false"
        @mouseout="holdingTheFloor = false"
        @touchstart="holdingTheFloor = true"
        @touchend="holdingTheFloor = false"
        @touchcancel="holdingTheFloor = false"
    >
        <div
            class="pointer-events-none select-none decoration-transparent"
            :class="buttonClasses"
        >
            <slot name="holding" v-if="holdingTheFloor">
                <img class="opacity-25" :src="LarryIcon" />
                <div class="absolute inset-0 grid place-content-center">
                    <WaveformVisualizer v-if="holdingTheFloor" />
                </div>
            </slot>
            <slot name="recognizing" v-else-if="recognizing">
                <img :src="LarryIcon" />
            </slot>
            <slot name="thinking" v-else-if="thinking">
                <div class="p-8">
                    <img :src="SpinnerIcon" class="animate-spin" />
                </div>
            </slot>
            <slot name="speaking" v-else-if="speaking">
                <img :src="SpeakerIcon" class="animate-pulse" />
            </slot>
            <slot name="idle" v-else>
                <img :src="LarryIcon" />
            </slot>
        </div>
    </div>
</template>
