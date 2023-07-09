import { ref, onMounted } from 'vue';

class Speaker {
    private synth: SpeechSynthesis;
    private utterance: SpeechSynthesisUtterance | null;

    constructor() {
        this.synth = window.speechSynthesis;
        this.utterance = null;
    }

    utter = async (text: string) => {
        return new Promise<void>((resolve) => {
            this.utterance = new SpeechSynthesisUtterance(text);
            this.utterance.onend = () => {
                this.utterance = null;
                resolve();
            };
            this.synth.speak(this.utterance);
        });
    }

    interrupt = () => {
        if (this.utterance) {
            this.synth.cancel();
            this.utterance = null;
        }
    }
}

export default Speaker;

// export default function useSpeechSynthesis() {
//     const synth = window.speechSynthesis;
//     const voices = ref<SpeechSynthesisVoice[]>([]);
//     const selectedVoice = ref<string>('Google US English');

//     onMounted(() => {
//         synth.addEventListener('voiceschanged', () => {
//             voices.value = synth.getVoices();
//         });
//     });

//     function speak(text: string, voiceName?: string) {
//         const utterance = new SpeechSynthesisUtterance(text);
//         if (voices.value.length > 0) {
//             const voiceToUse = voiceName ? voices.value.find((v) => v.name === voiceName) : undefined;
//             utterance.voice = voiceToUse || voices.value[0];
//         }
//         synth.speak(utterance);
//     }

//     return {
//         speak,
//     };
// }
