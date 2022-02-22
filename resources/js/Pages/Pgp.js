import {BasePage} from './BasePage';
import {Console} from '../Components/ConsoleComponent';

class Pgp extends BasePage {
    /**
     * Create a new Alphabetizer page.
     */
    constructor() {
        super('Pgp');
    }

    /**
     * Load the Alphabetizer.
     */
    load() {
        super.loadPageBeginMessage();

        $('body').on('click', '[data-action=COPY_PGP_KEY]', function(event) {
            event.preventDefault();

            let pgpPublicKey = $('#pgpkey_publickey').text();
            pgpPublicKey = pgpPublicKey.trim();

            let $tempTextareaElem = $("<textarea>");
            $("body").append($tempTextareaElem);
            $tempTextareaElem.val(pgpPublicKey).select();
            document.execCommand("copy");
            $tempTextareaElem.remove();

            // Add the copy to clipboard feedback, but only if the feedback element is not already there.
            if(! $('#pgpkey_publickey').prev().hasClass('copied_to_clipboard_feedback')) {
                let $feedbackElem = $('<span class="text-success font-weight-bold font-italic copied_to_clipboard_feedback">Copied to Clipboard!</span>');
                $feedbackElem.insertBefore($('#pgpkey_publickey'));

                // Remove it after 5 seconds.
                setTimeout(function() {
                    $feedbackElem.fadeOut('fast', function() {
                        $(this).remove();
                    });
                }, 10000);
            }
        });

        super.loadPageEndMessage();
    }
}

export {Pgp};
