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

        $('body').on('click', '[data-event-action=copy_pgp_key_to_clipboard]', function(event) {
            event.preventDefault();

            let pgpPublicKey = $('#pgpkey_publickey').text();
            pgpPublicKey = pgpPublicKey.trim();

            let $tempTextareaElem = $("<textarea>");
            $("body").append($tempTextareaElem);
            $tempTextareaElem.val(pgpPublicKey).select();
            document.execCommand("copy");
            $tempTextareaElem.remove();

            $.notify('Copied To Clipboard.', {
                "autoHide": true,
                "autoHideDelay": 5000,
                "className": "success",
                "position": 'right bottom',
                "elementPosition": 'right bottom',
                "globalPosition": 'right bottom',
            });

            // Add the copy to clipboard feedback, but only if the feedback element is not already there.
            // if(! $('#pgpkey_publickey').prev().hasClass('copied_to_clipboard_feedback')) {
            //     let $feedbackElem = $('<span class="text-success font-weight-bold font-italic copied_to_clipboard_feedback">Copied to Clipboard!</span>');
            //     $feedbackElem.insertBefore($('#pgpkey_publickey'));
            //
            //     // Remove it after 5 seconds.
            //     setTimeout(function() {
            //         $feedbackElem.fadeOut('fast', function() {
            //             $(this).remove();
            //         });
            //     }, 10000);
            // }
        });

        super.loadPageEndMessage();
    }
}

export {Pgp};
