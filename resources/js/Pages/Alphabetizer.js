import {BasePage} from './BasePage';
import {Console} from '../Components/ConsoleComponent';

class Alphabetizer extends BasePage {
    /**
     * The text that is currently in the alphabetizer input.
     *
     * @type {string}
     */
    alphabetizerInput = '';

    /**
     * The alphabetized text that is in the output.
     *
     * @type {string}
     */
    alphabetizerOutput = '';

    /**
     * The options to be used for alphabetization.
     *
     * @type {{REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES: boolean, UPPERCASE_FIRST_LETTER_OF_EACH_WORD: boolean, IGNORE_CASE: boolean, REVERSE_ALPHABETIZATION: boolean, UPPERCASE_FIRST_LETTER: boolean}}
     */
    alphabetizingOptions = {
        'IGNORE_CASE': true,
        'REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES': true,
        'UPPERCASE_FIRST_LETTER': false,
        'UPPERCASE_FIRST_LETTER_OF_EACH_WORD': false,
        'STRIP_WHITESPACE': false,
        'REVERSE_ALPHABETIZATION': false,
    };

    // defaultAlphabetizationOptions = {
    //     'IGNORE_CASE': true,
    //     'REVERSE_ALPHABETIZATION': false,
    //     'REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES': true,
    //     'UPPERCASE_FIRST_LETTER': false,
    //     'UPPERCASE_FIRST_LETTER_OF_EACH_WORD': false,
    // }

    /**
     * Create a new Alphabetizer page.
     */
    constructor() {
        super('Alphabetizer');
    }

    /**
     * Load the Alphabetizer.
     */
    load() {
        super.loadPageBeginMessage('Loading ' + super.pageName + ' page....');

        // Auto-resize the alphabetizer input with more rows vertically.
        $('#alphabetizer_input').autosize();

        let component = this;

        // Alphabetizing options are stored in localStorage, so they are persisted when the page reloads.
        // If the alphabetizing options are not currently stored in localStorage, then store them using the default values.
        if(localStorage.getItem('alphabetizingOptions') === null) {
            localStorage.setItem('alphabetizingOptions', JSON.stringify(component.alphabetizingOptions));
        }
        // After we have ensured the alphabetizing options are in localStorage, set them based on what is in the localStorage.
        this.alphabetizingOptions = JSON.parse(localStorage.getItem('alphabetizingOptions'));
        // Now manually set the alphabetizing options checkboxes to match what was in the localStorage.
        if(this.alphabetizingOptions.IGNORE_CASE) {
            $('[name=alphabetization_options\\[\\]][value=IGNORE_CASE]').prop('checked', true);
        }
        if(this.alphabetizingOptions.REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES) {
            $('[name=alphabetization_options\\[\\]][value=REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES]').prop('checked', true);
        }
        if(this.alphabetizingOptions.UPPERCASE_FIRST_LETTER) {
            $('[name=alphabetization_options\\[\\]][value=UPPERCASE_FIRST_LETTER]').prop('checked', true);
        }
        if(this.alphabetizingOptions.UPPERCASE_FIRST_LETTER_OF_EACH_WORD) {
            $('[name=alphabetization_options\\[\\]][value=UPPERCASE_FIRST_LETTER_OF_EACH_WORD]').prop('checked', true);
        }
        if(this.alphabetizingOptions.STRIP_WHITESPACE) {
            $('[name=alphabetization_options\\[\\]][value=STRIP_WHITESPACE]').prop('checked', true);
        }
        if(this.alphabetizingOptions.REVERSE_ALPHABETIZATION) {
            $('[name=alphabetization_options\\[\\]][value=REVERSE_ALPHABETIZATION]').prop('checked', true);
        }


        $('body').on('change', '[name=alphabetization_options\\[\\]]', function(event) {
            // event.preventDefault();
            let checkboxValue = $(this).val();
            if($(this).is(":checked")) {
                // this.alphabetizingOptions[checkboxValue] = false;
                component.setAlphabetizingOption(checkboxValue, true);
            }
            else {
                // this.alphabetizingOptions[checkboxValue] = true;
                component.setAlphabetizingOption(checkboxValue, false);
            }
        });



        // Alphabetizer input and output is stored in localStorage, so it is persisted even after the page closes.
        // If there is not currently a value in localStorage for input or output, then initialize it as an empty string.
        // NOTE: CURRENTLY DISABLING INPUT! Only output is auto-set from localStorage.
        // Comment these lines back in to re-enable auto-setting the input from localStorage.
        // if(localStorage.getItem('alphabetizerInput') === null) {
        //     localStorage.setItem('alphabetizerInput', '');
        // }
        if(localStorage.getItem('alphabetizerOutput') === null) {
            localStorage.setItem('alphabetizerOutput', '');
        }
        // After we have ensured there is an input and output value in localStorage, set it.
        // let alphabetizerInput = localStorage.getItem('alphabetizerInput');
        // component.setAlphabetizerInput(alphabetizerInput);
        let alphabetizerOutput = localStorage.getItem('alphabetizerOutput');
        component.setAlphabetizerOutput(alphabetizerOutput);


        // When the alphabetizer input has blurred, then update the input text.
        $('body').on('blur', '#alphabetizer_input', function(event) {
            //event.preventDefault();
            component.setAlphabetizerInput($(this).val());
        });



        // Create the event listener to process the alphabetization.
        $('body').on('click', '[data-action=PROCESS_ALPHABETIZATION]', function(event) {
            event.preventDefault();
            let alphabetizer_input = $('#alphabetizer_input').val();
            if(alphabetizer_input.length == 0) {
                $.notify('No Input To Alphabetize.', {
                    "autoHide": true,
                    "autoHideDelay": 5000,
                    "className": "danger",
                    "position": 'right bottom',
                    "elementPosition": 'right bottom',
                    "globalPosition": 'right bottom',
                });
                return;
            }
            component.processAlphabetization(alphabetizer_input);
            $.notify('Input Was Alphabetized.', {
                "autoHide": true,
                "autoHideDelay": 5000,
                "className": "success",
                "position": 'right bottom',
                "elementPosition": 'right bottom',
                "globalPosition": 'right bottom',
            });
        });

        $('body').on('click', '[data-action=COPY_ALPHABETIZATION_INPUT]', function(event) {
            event.preventDefault();

            let alphabetizationInput = $('#alphabetizer_input').val();
            // alphabetizationInput = alphabetizationInput.trim();

            // Don't let the copy happen if there are no characters to be copied.
            if(alphabetizationInput.length === 0) {
                $.notify('No Input To Copy.', {
                    "autoHide": true,
                    "autoHideDelay": 5000,
                    "className": "danger",
                    "position": 'right bottom',
                    "elementPosition": 'right bottom',
                    "globalPosition": 'right bottom',
                });
                return;
            }

            let $tempTextareaElem = $("<textarea>");
            $("body").append($tempTextareaElem);
            $tempTextareaElem.val(alphabetizationInput).select();
            document.execCommand("copy");
            $tempTextareaElem.remove();

            $.notify('Input Copied To Clipboard.', {
                "autoHide": true,
                "autoHideDelay": 5000,
                "className": "success",
                "position": 'right bottom',
                "elementPosition": 'right bottom',
                "globalPosition": 'right bottom',
            });

            // // Add the copy to clipboard feedback, but only if the feedback element is not already there.
            // if(! $('#alphabetizer_input').closest('.input-group').prev().hasClass('copied_to_clipboard_feedback')) {
            //     let $feedbackElem = $('<span class="text-success font-weight-bold font-italic copied_to_clipboard_feedback">Copied to Clipboard!</span>');
            //     $feedbackElem.insertBefore($('#alphabetizer_input').closest('.input-group'));
            //
            //     // Remove it after 5 seconds.
            //     setTimeout(function() {
            //         $feedbackElem.fadeOut('fast', function() {
            //             $(this).remove();
            //         });
            //     }, 5000);
            // }
        });

        $('body').on('click', '[data-action=CLEAR_ALPHABETIZATION_INPUT]', function(event) {
            event.preventDefault();
            component.setAlphabetizerInput('');
            $('#alphabetizer_input').focus();
        });

        $('body').on('click', '[data-action=COPY_ALPHABETIZATION_OUTPUT]', function(event) {
            event.preventDefault();

            // Get the output. Replace all HTML line breaks with the newline character.
            let alphabetizationOutput = $('#alphabetizer_output').html();
            alphabetizationOutput = alphabetizationOutput.replaceAll('<br />', '\n');
            alphabetizationOutput = alphabetizationOutput.replaceAll('<br/>', '\n');
            alphabetizationOutput = alphabetizationOutput.replaceAll('<br>', '\n');
            // alphabetizationOutput = alphabetizationOutput.trim();

            // Don't let the copy happen if there are no characters to be copied.
            if(alphabetizationOutput.length === 0) {
                $.notify('No Output To Copy.', {
                    "autoHide": true,
                    "autoHideDelay": 5000,
                    "className": "danger",
                    "position": 'right bottom',
                    "elementPosition": 'right bottom',
                    "globalPosition": 'right bottom',
                });
                return;
            }

            let $tempTextareaElem = $("<textarea>");
            $("body").append($tempTextareaElem);
            $tempTextareaElem.val(alphabetizationOutput).select();
            document.execCommand("copy");
            $tempTextareaElem.remove();

            $.notify('Output Copied To Clipboard.', {
                "autoHide": true,
                "autoHideDelay": 5000,
                "className": "success",
                "position": 'right bottom',
                "elementPosition": 'right bottom',
                "globalPosition": 'right bottom',
            });

            // // Add the copy to clipboard feedback, but only if the feedback element is not already there.
            // if(! $('#alphabetizer_output').prev().hasClass('copied_to_clipboard_feedback')) {
            //     let $feedbackElem = $('<span class="text-success font-weight-bold font-italic copied_to_clipboard_feedback">Copied to Clipboard!</span>');
            //     $feedbackElem.insertBefore($('#alphabetizer_output'));
            //
            //     // Remove it after 5 seconds.
            //     setTimeout(function() {
            //         $feedbackElem.fadeOut('fast', function() {
            //             $(this).remove();
            //         });
            //     }, 5000);
            // }
        });

        $('body').on('click', '[data-action=CLEAR_ALPHABETIZATION_OUTPUT]', function(event) {
            event.preventDefault();
            component.setAlphabetizerOutput('');
        });

        // Create the event listener to toggle the alphabetizer options.
        $('body').on('click', '[data-action=TOGGLE_ALPHABETIZER_OPTIONS]', function(event) {
            event.preventDefault();

            component.toggleAlphabetizerOptions();
        });

        // Create the event listener to completely reset the alphabetizer.
        $('body').on('click', '[data-action=RESET_ALPHABETIZER]', function(event) {
            event.preventDefault();

            component.completelyResetAlphabetizer();
        });



        super.loadPageEndMessage('Loaded ' + super.pageName + ' page.');
    }

    toggleAlphabetizerOptions() {
        // $('#alphabetization_options_fieldset').slideToggle();

        // This toggles the alphabetizer options instantly. The 'd-none' must be added to the #alphabetization_options_fieldset for it to work.
        if($('#alphabetization_options_fieldset').hasClass('d-none')) {
            $('#alphabetization_options_fieldset').removeClass('d-none');
        }
        else {
            $('#alphabetization_options_fieldset').addClass('d-none');
        }
    }

    setAlphabetizerInput(alphabetizerInput) {
        this.alphabetizerInput = alphabetizerInput;

        $('#alphabetizer_input').val(alphabetizerInput);

        localStorage.setItem('alphabetizerInput', alphabetizerInput);
    }

    getAlphabetizerInput() {
        return this.alphabetizerInput;
    }

    clearAlphabetizerInput() {
        this.alphabetizerInput = '';

        $('#alphabetizer_input').val('');

        localStorage.setItem('alphabetizerInput', '');
    }

    copyAlphabetizerInput() {
        //
    }

    setAlphabetizerOutput(alphabetizerOutput) {
        this.alphabetizerOutput = alphabetizerOutput;

        $('#alphabetizer_output').empty();
        $('#alphabetizer_output').html(alphabetizerOutput.replaceAll('\n', '<br/>'));

        localStorage.setItem('alphabetizerOutput', alphabetizerOutput);
    }

    getAlphabetizerOutput() {
        return this.alphabetizerOutput;
    }

    clearAlphabetizerOutput() {
        this.alphabetizerOutput = '';

        $('#alphabetizer_output').empty();

        localStorage.setItem('alphabetizerOutput', '');
    }

    copyAlphabetizerOutput() {
        //
    }

    setAlphabetizingOption(optionKey, optionValue) {
        this.alphabetizingOptions[optionKey] = optionValue;

        localStorage.setItem('alphabetizingOptions', JSON.stringify(this.alphabetizingOptions));

        Console.log('Updated alphabetizing options: ' + JSON.stringify(this.alphabetizingOptions))
    }

    // /**
    //  * Set the alphabetizing options to the default values.
    //  */
    // resetAlphabetizingOptionsToDefault() {
    //     this.alphabetizingOptions.IGNORE_CASE = true;
    //     this.alphabetizingOptions.REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES = true;
    //     this.alphabetizingOptions.UPPERCASE_FIRST_LETTER = false;
    //     this.alphabetizingOptions.UPPERCASE_FIRST_LETTER_OF_EACH_WORD = false;
    //     this.alphabetizingOptions.STRIP_WHITESPACE = false;
    //     this.alphabetizingOptions.REVERSE_ALPHABETIZATION = false;
    //
    //     // Persist the option values in localStorage.
    //     localStorage.setItem('alphabetizingOptions', JSON.stringify(this.alphabetizingOptions));
    // }

    processAlphabetization(alphabetizationInput) {
        // // Get the alphabetization input.
        // // Set a copy of it to ensure the latest version is in localStorage.
        // let alphabetizationInput = this.getAlphabetizerInput();
        // let alphabetizationInput = $('#alphabetizer_input').val(); // Using the current value in the text box.
        this.setAlphabetizerInput(alphabetizationInput);

        // Split each line of the input into an array.
        // The array is what will be sorted.
        let alphabetizationInputLinesArr = alphabetizationInput.split("\n");

        // Perform the options that transform the list before the actual alphabetization takes place.
        for(let i = 0; i < alphabetizationInputLinesArr.length; i++) {
            if(this.alphabetizingOptions.REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES) {
                alphabetizationInputLinesArr[i] = alphabetizationInputLinesArr[i].replaceAll("’", "'");
                alphabetizationInputLinesArr[i] = alphabetizationInputLinesArr[i].replaceAll('“', '"');
            }
            if(this.alphabetizingOptions.UPPERCASE_FIRST_LETTER) {
                alphabetizationInputLinesArr[i] = alphabetizationInputLinesArr[i].charAt(0).toUpperCase() + alphabetizationInputLinesArr[i].slice(1);
            }
            if(this.alphabetizingOptions.UPPERCASE_FIRST_LETTER_OF_EACH_WORD) {

                // Make a copy of the current line's text.
                let alphabetizationCurrentLineText = alphabetizationInputLinesArr[i];

                // Always check the first character. If it is a letter, then uppercase it.
                if(alphabetizationCurrentLineText.charAt(0).match(/[A-Za-z]/i)) {
                    alphabetizationCurrentLineText = alphabetizationCurrentLineText.charAt(0).toUpperCase() + alphabetizationCurrentLineText.slice(1);
                }

                // Now, loop through the remaining letters.
                // When a space is found, then uppercase the next character after the space if it is a letter.
                for(let j = 0; j < alphabetizationCurrentLineText.length; j++) {
                    // Special case to not check it if it's the last character
                    if(j === alphabetizationCurrentLineText.length) {
                        break;
                    }

                    if(alphabetizationCurrentLineText.charAt(j) === ' ' && alphabetizationCurrentLineText.charAt(j + 1).match(/[A-Za-z]/i)) {
                        alphabetizationCurrentLineText = alphabetizationCurrentLineText.charAt(j + 1).toUpperCase() + alphabetizationCurrentLineText.slice(j + 2);
                    }
                }

                // Finally, update the current line in the array.
                alphabetizationInputLinesArr[i] = alphabetizationCurrentLineText;
            }
            if(this.alphabetizingOptions.STRIP_WHITESPACE) {
                alphabetizationInputLinesArr[i] = alphabetizationInputLinesArr[i].trim();
            }
        }


        // Standard sort:
        alphabetizationInputLinesArr.sort();

        // Ignore case sort:
        if(this.alphabetizingOptions.IGNORE_CASE) {
            alphabetizationInputLinesArr.sort(function(a, b) {
                return a.toLowerCase().localeCompare(b.toLowerCase());
            });
        }

        if(this.alphabetizingOptions.REVERSE_ALPHABETIZATION) {
            alphabetizationInputLinesArr = alphabetizationInputLinesArr.reverse();
        }

        console.log(alphabetizationInputLinesArr);

        let alphabetizationOutput = alphabetizationInputLinesArr.join("\n");
        this.setAlphabetizerOutput(alphabetizationOutput);
    }

    /**
     * Completely reset the alphabetizer.
     */
    completelyResetAlphabetizer() {
        let page = this;

        page.setAlphabetizingOption('IGNORE_CASE', true);
        page.setAlphabetizingOption('REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES', true);
        page.setAlphabetizingOption('UPPERCASE_FIRST_LETTER', false);
        page.setAlphabetizingOption('UPPERCASE_FIRST_LETTER_OF_EACH_WORD', false);
        page.setAlphabetizingOption('STRIP_WHITESPACE', false);
        page.setAlphabetizingOption('REVERSE_ALPHABETIZATION', false);

        // // Set the default option values
        // page.alphabetizingOptions.IGNORE_CASE = true;
        // page.alphabetizingOptions.REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES = true;
        // page.alphabetizingOptions.UPPERCASE_FIRST_LETTER = false;
        // page.alphabetizingOptions.UPPERCASE_FIRST_LETTER_OF_EACH_WORD = false;
        // page.alphabetizingOptions.STRIP_WHITESPACE = false;
        // page.alphabetizingOptions.REVERSE_ALPHABETIZATION = false;
        // // Persist the default option values in localStorage.
        // localStorage.setItem('alphabetizingOptions', JSON.stringify(page.alphabetizingOptions));

        // Update the alphabetizing options input values.
        $('[name=alphabetization_options\\[\\]][value=IGNORE_CASE]').prop('checked', this.alphabetizingOptions.IGNORE_CASE);
        $('[name=alphabetization_options\\[\\]][value=REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES]').prop('checked', this.alphabetizingOptions.REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES);
        $('[name=alphabetization_options\\[\\]][value=UPPERCASE_FIRST_LETTER]').prop('checked', this.alphabetizingOptions.UPPERCASE_FIRST_LETTER);
        $('[name=alphabetization_options\\[\\]][value=UPPERCASE_FIRST_LETTER_OF_EACH_WORD]').prop('checked', this.alphabetizingOptions.UPPERCASE_FIRST_LETTER_OF_EACH_WORD);
        $('[name=alphabetization_options\\[\\]][value=STRIP_WHITESPACE]').prop('checked', this.alphabetizingOptions.STRIP_WHITESPACE);
        $('[name=alphabetization_options\\[\\]][value=REVERSE_ALPHABETIZATION]').prop('checked', this.alphabetizingOptions.REVERSE_ALPHABETIZATION);

        // If the options are shown, then toggle it so that it is hidden (which is the default state).
        if($('#alphabetization_options_fieldset').is(':visible')) {
            page.toggleAlphabetizerOptions();
        }


        page.setAlphabetizerInput('');
        page.setAlphabetizerOutput('');
        $('#alphabetizer_input').focus();

        // $('html, body').scrollTop(0);
        // $('html, body').animate({ scrollTop: 0 }, 'fast');
        $('#page_content').animate({ scrollTop: 0 }, 'fast');

        // Destroy it and create the autosize again, so that it shrinks back to default size.
        $('#alphabetizer_input').trigger('autosize.destroy');
        $('#alphabetizer_input').autosize();
    }
}

export {Alphabetizer};
