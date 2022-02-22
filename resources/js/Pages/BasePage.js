import {Console} from '../Components/ConsoleComponent';

class BasePage {
    pageName = '';

    constructor(pageName) {
        this.pageName = pageName;
    }

    setPageName(pageName) {
        this.pageName = pageName;
    }

    getPageName() {
        return this.pageName;
    }

    load() {
        // this.loadBeginMessage();
        //
        // this.loadEndMessage();
    }

    loadPageBeginMessage() {
        Console.log('Loading Page: ' + this.pageName);
    }

    loadPageEndMessage() {
        Console.log('Loaded Page: ' + this.pageName);
    }
}

export {BasePage};
