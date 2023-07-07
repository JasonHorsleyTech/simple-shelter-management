import { ref, onMounted } from 'vue';

export default function useSpeechSynthesis() {
    const synth = window.speechSynthesis;
    const voices = ref<SpeechSynthesisVoice[]>([]);
    const selectedVoice = ref<string>('Google US English');

    onMounted(() => {
        synth.addEventListener('voiceschanged', () => {
            voices.value = synth.getVoices();
        });
    });

    function speak(text: string, voiceName?: string) {
        const utterance = new SpeechSynthesisUtterance(text);
        if (voices.value.length > 0) {
            const voiceToUse = voiceName ? voices.value.find((v) => v.name === voiceName) : undefined;
            utterance.voice = voiceToUse || voices.value[0];
        }
        synth.speak(utterance);
    }

    return {
        speak,
    };
}
