require('./bootstrap'); // First load the application's bootstrapping procedures / dependencies:


window.NickMorgan = {}; // Create namespace for the application:

// Fire the self-executing function which loads the application:
;(function(app, $, mousetrap, undefined) {

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
     * Whether or not to mirror the app.  1 for regular, -1 for mirrored.
     *
     * @type {number}
     */
    app.mirror = 1;

    /**
     * Number of degrees to rotate the app.  Will be a multiple of 90.
     *
     * @type {number}
     */
    app.rotation = 0;

    /**
     * Initialize App.
     *
     * @param config
     */
    app.init = function(config) {
        // Display friendly message:
        console.log(config.message || "Initializing '" + (config.name || "nicholas-morgan") + "' application...");

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

        // Attach the scroll event to document so we can keep the logo following the screen if needed:
        $(document).scroll(function() {
            if($(this).scrollTop() > 54) {
                $('#avatar').css({
                    position: 'fixed',
                    top: 10
                });
            }
            else {
                $('#avatar').css({
                    position: 'absolute',
                    top: 64
                });
            }
        });

        // Autoresize specified <textarea> elements to be expanded
        // vertically as a user types in them
        // $('.autosize').autosize();



        // Mousetrap events:
        // Login:
        mousetrap.bind('l o g i n', function() {
            window.location = app.url('login');
        });

        // Mirror:
        mousetrap.bind('m i r r o r', function() {
            app.mirror *= -1;
            $("html").css("-webkit-transform", "scaleX(" + app.mirror + ")");
            $("html").css("-moz-transform", "scaleX(" + app.mirror + ")");
            $("html").css("-o-transform", "scaleX(" + app.mirror + ")");
            $("html").css("-ms-transform", "scaleX(" + app.mirror + ")");
            $("html").css("transform", "scaleX(" + app.mirror + ")");
        });

        // Rotate:
        Mousetrap.bind("r o t a t e", function(e) {
            app.rotation += 90;
            if(app.rotation > 360) {
                app.rotation = 0;
            }
            $("html").css("-webkit-transform", "rotate(" + app.rotation + "deg)");
            $("html").css("-moz-transform", "rotate(" + app.rotation + "deg)");
            $("html").css("-o-transform", "rotate(" + app.rotation + "deg)");
            $("html").css("-ms-transform", "rotate(" + app.rotation + "deg)");
            $("html").css("transform", "rotate(" + app.rotation + "deg)");
        });

        // Play contra:
        mousetrap.bind([
            'up up down down left right left right b a',
            'up up down down left right left right b a b a',
            'c o n t r a',
        ], function() {
            window.location = app.url('contra');
        });
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

})(window.NickMorgan, window.jQuery, window.Mousetrap);

// Load all modules that could possibly be used in the application.
require('./components/SomeComponent');
require('./modules/Welcome');
