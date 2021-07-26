;(function(app, undefined) {
    app.appComponents.push({
        componentName: 'textarea_code',

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            // If tab is pressed inside a textarea code input, then indent instead of changing to the next input.
            $('.textarea_code').on('keydown', function(event) {
                if(event.key == "Tab") {
                    event.preventDefault();
                    let start_position = this.selectionStart;
                    let end_position = this.selectionEnd;

                    // Set textarea value to: text before caret + tab + text after caret
                    this.value = this.value.substring(0, start_position) +
                        "    " + this.value.substring(end_position);

                    // put caret at right position again
                    this.selectionStart =
                        this.selectionEnd = start_position + 4;
                }
            });

            return component;
        },

        /**
         * Initialize the component.
         *
         * @param config
         */
        init: function() {
            let component = this;

            //

            return component;
        },
    });
})(window.NickMorgabWebApp);
