require('./bootstrap'); // First load the application's bootstrapping procedures / dependencies:

window.Contra = {}; // Create namespace for the application:

// Fire the self-executing function which loads the application:
;(function(app, $, undefined) {

    /**
     * Modules loaded into the application.
     *
     * @type {Array}
     */
    app.modules = [];

    /**
     * Components loaded into the application.
     *
     * @type {Array}
     */
    app.components = [];

    /**
     * Store all data needed for the app here.
     *
     * @type {{}}
     */
    app.appData = {};

    /**
     * Initialize App.
     *
     * @param config
     */
    app.init = function(config) {
        // Display friendly message:
        console.log("Initializing Contra application...");

        // Set any application environment variables which may be passed
        // into the application as it is being created...
        app.appData = config.appData || {};

        // Loop through all loaded modules, and initialize them, but only
        // if the user is on the page that the module is intended for.
        // If modules other than for the current page are needed for
        // some reason, they may be initialized manually.
        if(config.modules) {
            config.modules.forEach(function(module) {
                let moduleMessage = 'Module: \'' + module.name + '\' has been loaded.';
                // Only load module if the module is current page loaded in the application.
                if($('main#page-content[name=' + module.name + ']').length === 1) {
                    app.getModule(module.name).initModule(module.config);
                    moduleMessage += '.. and initialized!';
                }
                console.log(moduleMessage);
            });
        }

        // Loop through all loaded components, and initialize the one that
        // the config of this app has defined to be used.
        if(config.components) {
            config.components.forEach(function(component) {
                app.getComponent(component.name).initComponent(component.config);
                console.log('Component: \'' + component.name + '\' has been loaded... and initialized!');
            });
        }

        $('[data-action=show_controls]').click(function(event) {
            event.preventDefault();
            $('#controls_modal').modal('show');
        });

        console.log('hi');


    };

    /**
     * Get a module loaded into the application.
     *
     * @param moduleName
     * @returns {*}
     */
    app.getModule = function(moduleName) {
        for(let i = 0; i < app.modules.length; i++) {
            if(moduleName === app.modules[i].moduleName) {
                return app.modules[i];
            }
        }
        return null;
    };

    /**
     * Get a component loaded into the application.
     *
     * @param componentName
     * @returns {*}
     */
    app.getComponent = function(componentName) {
        for(let i = 0; i < app.components.length; i++) {
            if(componentName === app.components[i].componentName) {
                return app.components[i];
            }
        }
        return null;
    };

    /**
     * Make a URL.
     * @param path
     * @returns {string}
     */
    app.url = function(path = '') {
        let url = app.appData.appUrl + '/' + path;
        return url.replace(/\/$/, ""); // Remove trailing slash, if there is one.
    };

})(window.Contra, window.jQuery);

// Load all modules that could possibly be used in the application.
// require('./components/SomeComponent');
// require('./modules/Welcome');
