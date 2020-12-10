;(function(app, $, mousetrap, undefined) {
    app.appComponents.push({
        componentName: 'rotate',

        /**
         * The current rotation angle of the page.
         * Component rotates in 90 degree angles only, so this will be either 0, 90, 180, or 270.
         *
         * @type {string}
         */
        rotationAngle: '0',

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            // Action to rotate the page:
            $('body').on('click', '[data-action=rotate]', function(event) {
                event.preventDefault();
                component.rotatePage();
            });

            // Bind the Mousetrap command to rotate the page as well.
            mousetrap.bind('r o t a t e', function(event) {
                event.preventDefault();
                component.rotatePage();
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
         * Rotate the page.
         *
         * @returns {{mirrored}|*}
         */
        rotatePage: function() {
            let component = this;

            if(component.rotationAngle === '0') {
                component.rotationAngle = '90';
            }
            else if(component.rotationAngle === '90') {
                component.rotationAngle = '180';
            }
            else if(component.rotationAngle === '180') {
                component.rotationAngle = '270';
            }
            else {
                component.rotationAngle = '0';
            }

            $('body').removeClass('rotation_0 rotation_90 rotation_180 rotation_270');
            $('body').addClass('rotation_' + component.rotationAngle);

            return component;
        },
    });
})(window.NicksFuckinAwesomeWebsite, window.jQuery, window.Mousetrap);
