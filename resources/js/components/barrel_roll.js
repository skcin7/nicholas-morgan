;(function(app, $, mousetrap, undefined) {
    app.appComponents.push({
        componentName: 'barrel_roll',

        /**
         * The class name to be added to <body> which signifies a barrel roll is in process.
         *
         * @param {string}
         */
        className: 'brb_doing_a_barrel_roll_lol',

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            // Action to do a barrel roll:
            $('body').on('click', '[data-action=barrel_roll]', function(event) {
                event.preventDefault();
                component.doABarrelRoll();
            });

            // Bind the Mousetrap command to do a barrel roll as well:
            mousetrap.bind('b a r r e l r o l l', function(event) {
                event.preventDefault();
                component.doABarrelRoll();
            });

            // Detect the completion of a barrel roll, and remove the class when the animation is done:
            $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                $('body').removeClass(component.className);
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
         * Perform the barrel roll.
         *
         * @returns {*}
         */
        doABarrelRoll: function() {
            let component = this;

            if(! $('body').hasClass(component.className)) {
                $('body').addClass(component.className);
            }

            return component;
        },
    });
})(window.NicksFuckinAwesomeWebsite, window.jQuery, window.Mousetrap);
