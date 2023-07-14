<script setup lang="ts">
import Manual from "./Demo/Manual.vue";
import Larry from "./Larry/App.vue";

const props = defineProps<{
    assistant: {
        name: string;
        route: string;
        description: string;
    };
    inputMethod: string;
}>();
console.log(props.assistant);
</script>

<template>
    <Manual v-if="inputMethod === 'manual'" :assistant="assistant" />
    <Larry v-else :route="assistant.route" />
</template>
