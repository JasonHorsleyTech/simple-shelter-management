import { ref } from "vue";

/**
 * A good demo
 *
 * @param assistant
 * @returns ref<string[]>
 */
const resolveDemoTranscripts = (assistant: string) => {
    const content = {
        "greeter": [
            "Hello",
            "My name is Jason",
            "How are you doing today?",
        ]
    }[assistant] ?? ['Type something'];

    return ref<string[]>(content);
};

export default resolveDemoTranscripts;
