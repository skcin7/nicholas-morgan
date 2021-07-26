;(function(app, $, mousetrap, undefined) {
    app.appComponents.push({
        componentName: 'play_nes',

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            // Action to load the page to play NES:
            $('body').on('click', '[data-action=play_nes]', function(event) {
                event.preventDefault();
                component.loadNesPage();
            });

            // Bind the Mousetrap commands to be able to load the NES page as well:
            mousetrap.bind([
                'up up down down left right left right b a enter',
                'up up down down left right left right b a b a enter',
                'c o n t r a',
            ], function(event) {
                event.preventDefault();
                component.loadNesPage();
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
         * Load the page to play NES!
         *
         * @return {void}
         */
        loadNesPage: function() {
            window.location = app.url('nes');
        },
    });
})(window.NickMorgabWebApp, window.jQuery, window.Mousetrap);
