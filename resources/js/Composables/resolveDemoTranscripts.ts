import { ref } from "vue";

/**
 * A good demo
 *
 * @param assistant
 * @returns ref<string[]>
 */
const resolveDemoTranscripts = (assistantName: string) => {
    const content = {
        "greeter": [
            "Hello",
            "My name is Jason",
            "How are you doing today?",
        ],
        "weather": [
            "What's the weather today?",
        ]
    }[assistantName] ?? ['Type something'];

    return ref<string[]>(content);
};

export default resolveDemoTranscripts;
