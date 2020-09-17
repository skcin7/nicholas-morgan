require('./bootstrap'); // First load the application's bootstrapping procedures / dependencies:

window.NickMorgan = {}; // Create namespace for the application:

// Fire the self-executing function which loads the application:
;(function(app, $, mousetrap, undefined) {

    /**
     * Pages loaded into the application.
     *
     * @type {Array}
     */
    app.appPages = [];

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

    // <main class="py-4" id="page_content" name="@yield('pageName')">

        // Loop through all loaded pages, and initialize them, but only
        // if the user is on the page that the page is intended for.
        // If pages other than for the current page are needed for
        // some reason, they may be initialized manually.
        if(config.pages) {
            config.pages.forEach(function(page) {
                let pageMessage = 'Page: \'' + page.name + '\' has been loaded.';
                // Only load page if the page is current page loaded in the application.
                if($('main#page_content[name=' + page.name + ']').length === 1) {
                    app.getPage(page.name).init(page.config);
                    pageMessage += '.. and initialized!';
                }
                console.log(pageMessage);
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
            app.mirrorPage();
        });

        // Rotate:
        Mousetrap.bind("r o t a t e", function(e) {
            app.rotatePage();
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
     * Get a page loaded into the application.
     *
     * @param pageName
     * @returns {*}
     */
    app.getPage = function(pageName) {
        for(let i = 0; i < app.appPages.length; i++) {
            if(pageName === app.appPages[i].pageName) {
                return app.appPages[i];
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

    app.mirrorPage = function() {
        app.mirror *= -1;
        $("html").css("-webkit-transform", "scaleX(" + app.mirror + ")");
        $("html").css("-moz-transform", "scaleX(" + app.mirror + ")");
        $("html").css("-o-transform", "scaleX(" + app.mirror + ")");
        $("html").css("-ms-transform", "scaleX(" + app.mirror + ")");
        $("html").css("transform", "scaleX(" + app.mirror + ")");
    };

    app.rotatePage = function() {
        app.rotation += 90;
        if(app.rotation > 360) {
            app.rotation = 0;
        }
        $("html").css("-webkit-transform", "rotate(" + app.rotation + "deg)");
        $("html").css("-moz-transform", "rotate(" + app.rotation + "deg)");
        $("html").css("-o-transform", "rotate(" + app.rotation + "deg)");
        $("html").css("-ms-transform", "rotate(" + app.rotation + "deg)");
        $("html").css("transform", "rotate(" + app.rotation + "deg)");
    };

})(window.NickMorgan, window.jQuery, window.Mousetrap);

// Load all pages that could possibly be used in the application.
require('./components/SomeComponent');
require('./pages/welcome');
