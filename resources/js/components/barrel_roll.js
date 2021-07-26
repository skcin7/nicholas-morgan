;(function(app, $, mousetrap, undefined) {
    app.appComponents.push({
        componentName: 'barrel_roll',

        /**
         * The class name to be added to <body> which signifies a barrel roll is in process.
         *
         * @param {string}
         */
        barrelRollClassName: 'brb_doing_a_barrel_roll_lol',

        /**
         * The class name to be added to <body> for when a reverse barrel roll is being maneuvered.
         *
         * @param {string}
         */
        reverseBarrelRollClassName: 'watch_out_everyone_im_doing_a_barrel_roll_in_reverse_now',

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

            // Action to do a barrel roll in reverse:
            $('body').on('click', '[data-action=barrel_roll_reverse]', function(event) {
                event.preventDefault();
                component.doABarrelRoll("REVERSE");
            });

            // Bind the Mousetrap command to do a barrel roll as well:
            mousetrap.bind('b a r r e l r o l l', function(event) {
                event.preventDefault();
                component.doABarrelRoll();
            });

            // Detect the completion of a barrel roll, and remove the class when the animation is done:
            // $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
            //     console.log('animation ended. removing classes...')
            //     $('body').removeClass(component.barrelRollClassName + ' ' + component.reverseBarrelRollClassName);
            // });

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
         * @param direction
         * @returns {*}
         */
        doABarrelRoll: function(direction = "FORWARD") {
            let component = this;

            if(direction === "FORWARD") {
                if(! $('body').hasClass(component.barrelRollClassName)) {
                    $('body').addClass(component.barrelRollClassName);

                    $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                        console.log('animation ended. removing classes...');
                        $('body').removeClass(component.barrelRollClassName);
                    });
                }
            }

            if(direction === "REVERSE") {
                if(! $('body').hasClass(component.reverseBarrelRollClassName)) {
                    $('body').addClass(component.reverseBarrelRollClassName);

                    $('body').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
                        console.log('animation ended. removing classes...');
                        $('body').removeClass(component.reverseBarrelRollClassName);
                    });
                }
            }

            return component;
        },
    });
})(window.NickMorgabWebApp, window.jQuery, window.Mousetrap);
