<script lang="ts" setup>
type LarryOptions = {
    api?: string;
};
export type { LarryOptions };

const props = defineProps<{
    options: LarryOptions;
}>();

const api = props.options?.api ?? "/api/larry";
</script>

<template>
    <div>
        <h1>Larry</h1>
        <p>Coming soon...</p>
    </div>
</template>
