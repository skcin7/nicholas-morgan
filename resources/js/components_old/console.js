;(function(app, $, undefined) {
    app.appComponents.push({
        componentName: 'console',

        /**
         * Specify the level of verbosity here.
         *
         * @type {string}
         */
        loggingLevel: 'DEBUG',

        /**
         * A list of all the valid verbosity levels.
         *
         * @type {string[]}
         */
        validVerbosityLevels: ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'],

        /**
         * An optional flag that will disable all console output.
         *
         * @type {boolean}
         */
        disableAllOutput: false,

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            component.setLoggingLevel('DEBUG');

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
         * Set the verbosity level.
         *
         * @param loggingLevel
         */
        setLoggingLevel: function(loggingLevel) {
            let component = this;

            if(! component.validVerbosityLevels.includes(loggingLevel)) {
                console.error('The specified verbosity level ' + loggingLevel + ' is not valid.');
                return;
            }

            component.loggingLevel = loggingLevel;
        },


    });
})(window.NickMorgabWebApp, window.jQuery);
