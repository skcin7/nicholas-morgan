import {BasePage} from './BasePage';

class WritingPage extends BasePage {
    tab_size = 4;

    /**
     * Create a new Writing page.
     */
    constructor() {
        super('WritingPage');
    }

    load() {
        let writingPage = this;

        $('.textarea_code').on('keydown', function(event) {
            // Tab is pressed so we must add 4 spaces.
            if(event.key == "Tab") {
                event.preventDefault();
                console.log('Tab was pressed.');

                let textareaElem = this;
                let $textareaElem = $(this);
                let textarea_current_value = $textareaElem.val();

                let selection_start_position = $textareaElem[0].selectionStart;
                let selection_end_position = $textareaElem[0].selectionEnd;
                // console.log('Start Position: ' + selection_start_position);
                // console.log('End Position: ' + selection_end_position);

                // let selection_starting_line_number = writingPage.getSelectionStartingLineNumber(textarea_current_value, selection_start_position, selection_end_position);
                // let selection_ending_line_number = writingPage.getSelectionEndingLineNumber(textarea_current_value, selection_start_position, selection_end_position);
                // console.log('Selection Starting Line Number: ' + selection_starting_line_number);
                // console.log('Selection Ending Line Number: ' + selection_ending_line_number);

                // If the start and end position are different (some text is highlighted), then
                // add tab spaces for all the code on any of the lines that are part of the selection.
                if(selection_start_position !== selection_end_position) {
                    if(window.NickMorgabWebApp.getComponent('KeyboardComponent').isKeyPressed('Shift')) {
                        writingPage.unindentSelection($textareaElem);
                    }
                    else {
                        writingPage.indentSelection($textareaElem);
                    }
                }
                else {
                    // Selection start/end are the same, so no text is selected.

                    // If shift is held, then we must move the current line back by a tab.
                    if(window.NickMorgabWebApp.getComponent('KeyboardComponent').isKeyPressed('Shift')) {
                        writingPage.unindentSelection($textareaElem);
                    }
                    else {
                        // let selection_start_position = writingPage.getSelectionStartPosition($textareaElem);
                        // let selection_end_position = writingPage.getSelectionEndPosition($textareaElem);

                        let before_selection = textarea_current_value.substring(0, selection_start_position);
                        let tabs_adding = ' '.repeat(writingPage.tab_size);
                        let after_selection = textarea_current_value.substring(selection_end_position);

                        $textareaElem.val(before_selection + tabs_adding + after_selection);
                        $textareaElem[0].selectionStart = $textareaElem[0].selectionEnd = (selection_start_position + writingPage.tab_size);
                    }
                }

                return;
            }





            // if(event.key === "Tab") {
            //     event.preventDefault();
            //     console.log('Tab was pressed.');
            //     return;
            // }

            // console.log('Code keydown: ' +  event.key);
        });

        // let dropdowns = document.querySelectorAll('.dropdown-submenu');
        // dropdowns.forEach((dd)=>{
        //     dd.addEventListener('mouseover', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'none':'block'
        //     })
        //     dd.addEventListener('mouseout', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'block':'none'
        //     })
        // });

        // let dropdowns = document.querySelectorAll('.dropdown-toggle');
        // dropdowns.forEach((dd)=>{
        //     dd.addEventListener('click', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'none':'block'
        //     })
        // });
    }


    /**
     * Indent the current selection of text in the textarea.
     *
     * @param $textareaElem
     */
    indentSelection($textareaElem) {
        let writingPage = this;

        let selection_start_position = writingPage.getSelectionStartPosition($textareaElem);
        let selection_end_position = writingPage.getSelectionEndPosition($textareaElem);
        console.log('Selection Start Position: ' + selection_start_position);
        console.log('Selection End Position: ' + selection_end_position);
        let selection_start_line_number = writingPage.getSelectionRangeLineNumber($textareaElem, 'START');
        let selection_end_line_number = writingPage.getSelectionRangeLineNumber($textareaElem, 'END');
        console.log('Selection Start Line Number: ' + selection_start_line_number);
        console.log('Selection End Line Number: ' + selection_end_line_number);

        let new_text = '';
        let lines = $textareaElem.val().split("\n");
        for(let current_line = 0; current_line < lines.length; current_line++) {
            let this_line_text = '';

            if(current_line >= selection_start_line_number && current_line <= selection_end_line_number) {
                // this_line_text = (this_line_text + ' ' . repeat(writingPage.tab_size));
                this_line_text = (' ' . repeat(writingPage.tab_size) + this_line_text);
            }

            this_line_text = (this_line_text + lines[current_line]);

            new_text = (new_text + this_line_text + "\n");
        }

        new_text = new_text.trim();
        $textareaElem.val(new_text);

        let number_of_lines_indented = (selection_end_line_number - selection_start_line_number + 1);
        $textareaElem[0].selectionStart = selection_start_position + writingPage.tab_size;
        $textareaElem[0].selectionEnd = selection_end_position + (writingPage.tab_size * number_of_lines_indented);
    }

    /**
     * Unindent the current selection of text in the textarea.
     *
     * @param $textareaElem
     */
    unindentSelection($textareaElem) {
        let writingPage = this;

        let selection_start_position = writingPage.getSelectionStartPosition($textareaElem);
        let selection_end_position = writingPage.getSelectionEndPosition($textareaElem);
        console.log('Selection Start Position: ' + selection_start_position);
        console.log('Selection End Position: ' + selection_end_position);
        let selection_start_line_number = writingPage.getSelectionRangeLineNumber($textareaElem, 'START');
        let selection_end_line_number = writingPage.getSelectionRangeLineNumber($textareaElem, 'END');
        console.log('Selection Start Line Number: ' + selection_start_line_number);
        console.log('Selection End Line Number: ' + selection_end_line_number);

        let new_text = '';
        let selection_start_line_characters_removed_count = 0;
        let entire_selection_characters_removed_count = 0;
        let lines = $textareaElem.val().split("\n");
        for(let current_line = 0; current_line < lines.length; current_line++) {
            let this_line_text = lines[current_line];

            if(current_line >= selection_start_line_number && current_line <= selection_end_line_number) {
                // Loop through and remove as many spaces at the beginning of the line, up to the tab size amount
                for(let current_character = 0; current_character < writingPage.tab_size; current_character++) {
                    // If the current first character of the line is a space, remove it
                    if(this_line_text.charAt(0) === ' ') {
                        this_line_text = this_line_text.substring(1);

                        // Keep track of how many characters are removed from the first selection line.
                        if(current_line === selection_start_line_number) {
                            selection_start_line_characters_removed_count++;
                        }

                        // Keep track of how many characters are removed from all the selection lines.
                        entire_selection_characters_removed_count++;
                    }
                }
            }

            new_text = (new_text + this_line_text + "\n");
        }

        new_text = new_text.trim();
        $textareaElem.val(new_text);

        $textareaElem[0].selectionStart = selection_start_position - selection_start_line_characters_removed_count;
        $textareaElem[0].selectionEnd = selection_end_position - entire_selection_characters_removed_count;
    }

    /**
     * Get the starting position of the selected text in a textarea.
     *
     * @param $textareaElem
     * @returns {*|number}
     */
    getSelectionStartPosition ($textareaElem) {
        return $textareaElem[0].selectionStart;
    }

    /**
     * Get the ending position of the selected text in a textarea.
     *
     * @param $textareaElem
     * @returns {*|number}
     */
    getSelectionEndPosition ($textareaElem) {
        return $textareaElem[0].selectionEnd;
    }

    /**
     * Get the range (starting or ending) line number of the selected text in a textarea.
     *
     * @param $textareaElem
     * @param rangeStartOrEnd
     * @returns {number}
     */
    getSelectionRangeLineNumber($textareaElem, rangeStartOrEnd = 'START') {
        let component = this;

        let selection_start_position = component.getSelectionStartPosition($textareaElem);
        let selection_end_position = component.getSelectionEndPosition($textareaElem);

        let lines = $textareaElem.val().split("\n");
        let characters_count = 0;
        for(let current_line_number = 0; current_line_number < lines.length; current_line_number++) {

            // If the selection start is in the range of characters on the current line, then we have found the selection starting line number.
            if(selection_start_position >= characters_count && selection_start_position <= characters_count + lines[current_line_number].length) {

                // We have found the STARTING line number of the selected text. If that's the range value we want, return it.
                if(rangeStartOrEnd === 'START') {
                    return current_line_number;
                }
            }

            // If the selection end is in the range of characters on the current line, then we have found the selection ending line number.
            if(selection_end_position > characters_count && selection_end_position <= characters_count + lines[current_line_number].length) {

                // We have found the STARTING line number of the selected text. If that's the range value we want, return it.
                if(rangeStartOrEnd === 'END') {
                    return current_line_number;
                }
            }

            // The new characters count is the previous count, plus the number of characters on this line, plus 1 for the \n character
            characters_count = (characters_count + lines[current_line_number].length + 1);
        }
    }

}

export {WritingPage};
