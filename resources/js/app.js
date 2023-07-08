import "./bootstrap";
import { createApp } from "vue";
import AssistantDemo from ".//AssistantDemo.vue";

createApp({}).component("assistant-demo", AssistantDemo).mount("#app");
