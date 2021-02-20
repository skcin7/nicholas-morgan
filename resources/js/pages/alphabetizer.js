;(function(app, $, undefined) {
    app.appPages.push({
        pageName: 'alphabetizer',

        // Defining jQuery references to the input and output elements
        $alphabetizerInputElem: $('#alphabetizer_input'),
        $alphabetizerOutputElem: $('#alphabetizer_output'),

        defaultOptions: {
            "ignore_case": true,
            "remove_magic_quotes": true,
            "uppercase_first_letter": false,
            "uppercase_all_words": false,
        },

        currentOptions: {},

        /**
         * Set the page's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let page = this;

            // Action to do a barrel roll:
            $('body').on('click', '[data-action=process_alphabetization]', function(event) {
                event.preventDefault();
                console.log('Processing Alphabetization...');

                // let alphabetized = page.$alphabetizerInputElem.val().split("\n").sort().join("\n");
                // console.log(alphabetized);
                // page.$alphabetizerOutputElem.val(alphabetized);

                // let
                // page.$alphabetizerOutputElem.val();
                let unalphabetized_text_input = page.$alphabetizerInputElem.val();
                let alphabetized_array = page.getAlphabetizedArray(unalphabetized_text_input);
                page.$alphabetizerOutputElem.val(alphabetized_array.join("\n"));

                // Update the text to be used by default in the input when the page loads
                localStorage.setItem('alphabetizer_input', unalphabetized_text_input);
            });

            $('body').on('change', '#ignore_case_option_checkbox', function(event) {
                // event.pre
                // let $all_checkboxes_on_page = $('input[name=catalog_item_checkboxes\\[\\]]');
                // let action = $(this).is(":checked") ? 'SELECT_ALL' : 'DESELECT_ALL';
                // $all_checkboxes_on_page.each(function(index, currentCheckbox) {
                //     let current_checkbox_id = $(currentCheckbox).val();
                //
                //     if(action === "SELECT_ALL") {
                //         page.addToCurrentlySelectedIds(current_checkbox_id);
                //         $('#catalog_item_' + current_checkbox_id).prop('checked', true);
                //     }
                //
                //     if(action === "DESELECT_ALL") {
                //         page.removeFromCurrentlySelectedIds(current_checkbox_id);
                //         $('#catalog_item_' + current_checkbox_id).prop('checked', false);
                //     }
                // });
            });

            // If a single checkbox is checked, then add or remove it from the list of currently selected
            $('body').on('change', '[name^=options_checkboxes]', function(event) {
                // event.preventDefault();
                let $changedCheckbox = $(this);
                // console.log('clicked');
                // console.log($changedCheckbox.attr('name'));

                let inputName = $changedCheckbox.attr('name'); // The name of the input (including the array value)
                let theOptionKey = inputName.substring(inputName.indexOf("[") + 1, inputName.indexOf("]"));
                console.log(theOptionKey);

                page.updateOption(theOptionKey, $changedCheckbox.is(":checked"));

                // if($changedCheckbox.is(":checked")) {
                //     let new_value = true;
                // }
                // else {
                //     let new_value = false;
                // }
            });

            return page;
        },

        /**
         * Initialize the page.
         *
         * @param config
         */
        init: function(config) {
            let page = this;

            // if the local storage options isn't already set, then set it now
            if(localStorage.getItem('alphabetizer_options') === null) {
                localStorage.setItem('alphabetizer_options', JSON.stringify(page.defaultOptions));
            }

            // if the default input value isn't already set, then set it here as an empty string
            if(localStorage.getItem('alphabetizer_input') === null) {
                localStorage.setItem('alphabetizer_input', '');
            }

            // Upon the initial page load, get the current options for the alphabetizer, which is stored in local storage
            page.currentOptions = JSON.parse(localStorage.getItem('alphabetizer_options'));

            // Upon the initial page load, put the text into the default input
            let alphabetizer_input = localStorage.getItem('alphabetizer_input');
            console.log(alphabetizer_input);
            page.$alphabetizerInputElem.val(alphabetizer_input);

            console.log('loaded current options');
            console.log(page.currentOptions);

            // Set the default checkbox values (on or off) for the options checkboxes upon loading the page:
            $('#ignore_case_option_checkbox').prop('checked', page.currentOptions.ignore_case);
            $('#remove_magic_quotes_option_checkbox').prop('checked', page.currentOptions.remove_magic_quotes);
            $('#uppercase_first_letter_option_checkbox').prop('checked', page.currentOptions.uppercase_first_letter);
            $('#uppercase_all_words_option_checkbox').prop('checked', page.currentOptions.uppercase_all_words);

            return page;
        },

        /**
         * Update a single option. Also persist the changes to local storage.
         *
         * @param theOptionKey
         * @param newOptionValue
         */
        updateOption: function(theOptionKey, newOptionValue) {
            let page = this;

            console.log(theOptionKey);
            console.log(newOptionValue);

            // // Ensure the key exists. Don't let it be updated if it's not a valid option key.
            // if(! page.currentOptions[theOptionKey]) {
            //     return;
            // }

            page.currentOptions[theOptionKey] = newOptionValue;

            localStorage.setItem('alphabetizer_options', JSON.stringify(page.currentOptions));

            console.log('Updated Options');
            console.log(page.currentOptions);
        },

        /**
         * Get a list in alphabetized form.
         *
         * @param unalphabetized
         * @returns {*}
         */
        getAlphabetizedArray: function(unalphabetized) {
            let page = this;

            // If it's not currently in array format, then it's a raw list.
            // In this case, split by each newline and put it into an array
            if(! Array.isArray(unalphabetized)) {
                unalphabetized = unalphabetized.split("\n");
            }

            if(page.currentOptions.ignore_case) {
                unalphabetized.sort(function(a, b) {
                    return a.toLowerCase().localeCompare(b.toLowerCase());
                });
            }
            else {
                unalphabetized.sort();
            }

            // If the option is set to remove magic quotes
            if(page.currentOptions.remove_magic_quotes) {
                let new_list = [];
                unalphabetized.forEach(function(thisElement, thisIndex) {
                    let stripped = thisElement;
                    stripped = stripped.replaceAll("’", "'");
                    stripped = stripped.replaceAll('“', '"');
                    new_list.push(stripped);
                });
                unalphabetized = new_list;
            }

            // If the option is set to uppercase the first letter of each element
            if(page.currentOptions.uppercase_first_letter) {
                let new_list = [];
                unalphabetized.forEach(function(thisElement, thisIndex) {
                    new_list.push(thisElement.charAt(0).toUpperCase() + thisElement.slice(1));
                });
                unalphabetized = new_list;
            }

            // If the option is set to uppercase the first letter of all the words in each element
            if(page.currentOptions.uppercase_all_words) {
                let new_list = [];

                unalphabetized.forEach(function(thisElement, thisIndex) {

                    let words = thisElement.split(' ');
                    let element_with_all_words_first_letter_uppercase = '';
                    for(let i = 0; i < words.length; i++) {
                        let word_with_first_letter_uppercase = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                        element_with_all_words_first_letter_uppercase += word_with_first_letter_uppercase + " ";
                    }

                    new_list.push(element_with_all_words_first_letter_uppercase.trim());
                });
                unalphabetized = new_list;
            }

            return unalphabetized;

            // let alphabetized = unalphabetized.sort().join("\n");
            // return alphabetized;
        },

    });
})(window.NicksFuckinAwesomeWebsite, window.jQuery);
