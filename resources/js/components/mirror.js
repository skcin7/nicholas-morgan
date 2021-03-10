;(function(app, $, mousetrap, undefined) {
    app.appComponents.push({
        componentName: 'mirror',

        /**
         * Whether or not the application is currently mirrored.
         *
         * @type {boolean}
         */
        mirrored: false,

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            // Action to mirror the page:
            $('body').on('click', '[data-action=mirror]', function(event) {
                event.preventDefault();
                component.togglePageMirror();
            });

            // Bind the Mousetrap command to mirror the page as well.
            mousetrap.bind('m i r r o r', function(event) {
                event.preventDefault();
                component.togglePageMirror();
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

        /**
         * Mirror (or un-mirror) the page.
         *
         * @returns {{mirrored}|*}
         */
        togglePageMirror: function() {
            let component = this;

            if(! component.mirrored) {
                $('body').addClass('mirrored');
                component.mirrored = true;
            }
            else {
                $('body').removeClass('mirrored');
                component.mirrored = false;
            }

            return component;
        },
    });
})(window.NicksFuckinAwesomeWebApp, window.jQuery, window.Mousetrap);
