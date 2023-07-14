class Speaker {
    private synth: SpeechSynthesis;
    private utterance: SpeechSynthesisUtterance | null;
    private utterFinishedCallback: (() => void) | null;

    constructor() {
        this.synth = window.speechSynthesis;
        this.utterance = null;
        this.utterFinishedCallback = null;
    }

    utter = async (text: string) => {
        return new Promise<void>((resolve) => {
            this.utterFinishedCallback = resolve; // Storing the resolve function in the instance variable
            this.utterance = new SpeechSynthesisUtterance(text);
            this.utterance.onend = () => {
                this.utterFinished();
            };
            this.utterance.onerror = () => {
                console.log('Speaker error');
                this.utterFinished();
            };
            this.synth.speak(this.utterance);
        });
    }

    interrupt = () => {
        if (this.synth.speaking) {
            this.synth.cancel();
            this.utterFinished();
        }
    }

    private utterFinished = () => {
        if (this.utterFinishedCallback) {
            this.utterFinishedCallback();
            this.utterFinishedCallback = null;
        }
    }
}

export default Speaker;
