<script lang="ts" setup>
import { onMounted } from 'vue';
import { ref } from 'vue';

const barHeights = ref<number[]>(new Array(24).fill(1));
onMounted(async () => {
    const stream: MediaStream = await navigator.mediaDevices.getUserMedia({ audio: true });

    let audioVisualsInterval = -1;
    let updateAudioVisuals: () => void = () => { };
    const context = new AudioContext();
    const source = context.createMediaStreamSource(stream);
    const analyser = context.createAnalyser();
    source.connect(analyser);
    analyser.fftSize = 32;

    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);

    updateAudioVisuals = () => {
        analyser.getByteFrequencyData(dataArray);

        const voiceRange = Array.from(dataArray)
            .splice(4, 16)
            .map((value) => {
                if (value === 0) return 1;
                if (value < 64) return value / 1.5;
                if (value < 256) return value / 3;
                return value / 8;
            });

        barHeights.value = voiceRange.slice().reverse().concat(voiceRange);
    };

    audioVisualsInterval = window.setInterval(() => {
        updateAudioVisuals();
    }, 1);
});
</script>

<template>
    <div class="relative mx-auto overflow-hidden flex flex-row items-center h-[64px] px-2 gap-x-[1px]">
        <div v-for="(height, index) in barHeights" :key="index" class="w-[2px] bg-green-500"
            :style="`height: ${height}px;`" />
    </div>
</template>
