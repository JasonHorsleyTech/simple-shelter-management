<script setup lang="ts">
import Manual from "./Demo/Manual.vue";
import Larry from "./Larry/App.vue";

const props = defineProps<{
    assistant: string;
    inputMethod: string;
}>();
</script>

<template>
    <Manual v-if="inputMethod === 'manual'" :assistant="assistant" />
    <Larry v-else />
</template>
