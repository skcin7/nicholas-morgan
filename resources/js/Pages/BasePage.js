import {Console} from '../Components/Console';

class BasePage {
    pageName = '';

    constructor(pageName) {
        this.pageName = pageName;
    }

    load() {
        // this.loadBeginMessage();
        //
        // this.loadEndMessage();
    }

    loadPageBeginMessage() {
        Console.log('Loading ' + this.pageName + ' page......');
    }

    loadPageEndMessage() {
        Console.log('Loaded ' + this.pageName + ' page.');
    }
}

export {BasePage};
