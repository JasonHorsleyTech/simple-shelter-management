<script setup lang="ts">
import { ref } from "vue";

const links = [
    {
        url: "feature/converse",
        type: "converse",
        shortDescription: "Opened ended conversation",
        longDescription:
            "Speech to chat responds as it usually does, maybe with some additional custom 'styling' or 'context'.",
    },
    {
        url: "feature/autoform",
        type: "autoform",
        shortDescription: "Form dictation",
        longDescription:
            "Speech to text to JSON to prefilled form. If partial, can optionally engage in followup questions to complete.",
    },
    {
        url: "feature/navigation",
        type: "navigation",
        shortDescription: "Site navigation",
        longDescription:
            "Speech to you're where you need to be (with proper state)",
    },
    {
        url: "feature/inquiry",
        type: "inquiry",
        shortDescription: "Analytics on the fly",
        longDescription: "Speech to a raw SQL query to an answer",
    },
    {
        url: "feature/audit",
        type: "audits",
        shortDescription: "Nightly audits",
        longDescription:
            "Cron jobs that run multiple slow sort queries and greet you the next morning with results.",
    },
    {
        url: "feature/action",
        type: "actions",
        shortDescription: "Reversible actions",
        longDescription:
            "Voice initiated actions that execute on timer/next interaction, assuming no objection.",
    },
];
</script>

<template>
    <div class="grid gap-y-2">
        <h1 class="text-3xl font-bold underline">
            Static links with real GPT calls.
        </h1>

        <ul class="list-disc">
            <a
                v-for="{
                    url,
                    type,
                    shortDescription,
                    longDescription,
                } in links"
                :key="url"
                class="block py-2 border-b hover:border-blue-500 cursor-pointer border-transparent underline-none"
                :href="url"
            >
                <p class="flex items-baseline text-blue-300 gap-x-1">
                    <p class="uppercase text-xl">{{ type }}: </p>
                    <p>{{ shortDescription }}</p>
                </p>
                <span class="text-xs">{{ longDescription }}</span>
            </a>
        </ul>
    </div>
</template>
