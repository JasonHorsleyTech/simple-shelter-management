<script setup lang="ts">
import { ref } from "vue";

const clicked = ref<number>(0);
</script>

<template>
    <div @click="clicked++">
        <h1 class="text-3xl font-bold underline">Hello world {{ clicked }}.</h1>
    </div>
</template>
