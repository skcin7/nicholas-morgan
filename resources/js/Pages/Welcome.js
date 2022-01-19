import {BasePage} from './BasePage';

class Welcome extends BasePage {
    /**
     * Create the Page.
     */
    constructor() {
        super('Welcome');
    }

    /**
     * Get the HTML to be used for the Page.
     *
     * @returns {string}
     */
    html() {
        return '<div class="container-fluid">' +
            '<h2 class="text-center">Welcome</h2>' +
            '<p>I am a <strong>computer programmer</strong>, <strong>video game collector</strong>, and <strong>business owner</strong> that currently lives in California, USA, and I\'m originally from New Jersey, USA. Thanks for visiting!</p>' +
        '</div>';
    }

    /**
     * Load the Page.
     */
    load() {
        super.loadPageBeginMessage('Loading ' + super.pageName + ' page...');

        //

        super.loadPageEndMessage('Loaded ' + super.pageName + ' page.');
    }

}

export {Welcome};
