// Bootstrap the application's JavaScript dependencies:
require('./bootstrap');

// Create the namespace for the application:
window.NickMorgabWebApp = {};

// Fire the self-executing function to load the application:
;(function(app, $, mousetrap, undefined) {

    /**
     * Components loaded into the application.
     *
     * @type {Array}
     */
    app.appComponents = [];

    /**
     * List of all the app components to be loaded!
     *
     * @type {*[]}
     */
    app.appComponentsToLoad = [
        'album_modal',
        'barrel_roll',
        'mirror',
        'play_nes',
        'rotate',
        'textarea_code',
        //'somecomponent',
    ];

    /**
     * Pages loaded into the application.
     *
     * @type {Array}
     */
    app.appPages = [];

    /**
     * List of all the app pages to be loaded!
     *
     * @type {*[]}
     */
    app.appPagesToLoad = [
        'admin_quotes',
        'alphabetizer',
        'bookmarklets',
        //'nes',
        'welcome',
    ];

    // /**
    //  * Info about the user that is currently authenticated.
    //  *
    //  * @type {null|{}}
    //  */
    // app.authenticatedUser = null;

    /**
     * Base URL used for the application is stored here.
     *
     * @type {String}
     */
    app.base_url = '';

    /**
     * The current page that is being viewed in the viewport.
     *
     * @type {String}
     */
    app.current_page = '';

    /**
     * Set the environment configuration/data.
     *
     * @param config
     * @returns {{}|*}
     */
    app.setConfig = function(config) {
        console.log("Configuring the application ...");

        // Set the app's base URL:
        app.base_url = config.base_url || '';

        // Load the app's JS components:
        if(app.appComponentsToLoad) {
            app.appComponentsToLoad.forEach(function(component, index) {
                let componentName, componentConfig;
                if(typeof component === "string") {
                    componentName = component;
                    componentConfig = {};
                }
                else {
                    componentName = component.name;
                    componentConfig = component.config;
                }

                require('./components_old/' + componentName);

                app.getComponent(componentName).setConfig(componentConfig).init();
                console.log('Component: \'' + componentName + '\' has been loaded... and initialized!');
            });
        }

        // Load the app's JS pages:
        if(app.appPagesToLoad) {
            app.appPagesToLoad.forEach(function(page, index) {
                let pageName, pageConfig;
                if(typeof page === "string") {
                    pageName = page;
                    pageConfig = {};
                }
                else {
                    pageName = page.name;
                    pageConfig = page.config;
                }

                require('./pages_old/' + pageName);

                let pageMessage = 'Page: \'' + pageName + '\' has been loaded.';
                // Only load page if the page is current page loaded in the application.
                if($('main#page_content[name=' + pageName + ']').length === 1) {
                    app.getPage(pageName).setConfig(pageConfig).init();
                    pageMessage += '.. and initialized!';
                }
                console.log(pageMessage);
            });
        }

        // // Initialize all pages:
        // app.appPages.forEach(function(thisAppPage, index) {
        //     thisAppPage.setConfig().init();
        //     console.log('Page: \'' + thisAppPage.pageName + '\' initialized.')
        // });



        // // Load the app's JS pages:
        // if(app.appPagesToLoad) {
        //     app.appPagesToLoad.forEach(function(page, index) {
        //         let pageName, pageConfig;
        //         if(typeof page === "string") {
        //             pageName = page;
        //             pageConfig = {};
        //         }
        //         else {
        //             pageName = page.name;
        //             pageConfig = page.config;
        //         }
        //
        //         require('./pages/' + pageName);
        //
        //         let pageMessage = 'Page: \'' + pageName + '\' has been loaded.';
        //         // Only load page if the page is current page loaded in the application.
        //         if($('main#page_content[name=' + pageName + ']').length === 1) {
        //             app.getPage(pageName).setConfig(pageConfig).init();
        //             pageMessage += '..and initialized!';
        //         }
        //         console.log(pageMessage);
        //     });
        // }

        // // Load the app's JS components:
        // if(app.appComponentsToLoad) {
        //     app.appComponentsToLoad.forEach(function(component, index) {
        //         let componentName, componentConfig;
        //         if(typeof component === "string") {
        //             componentName = component;
        //             componentConfig = {};
        //         }
        //         else {
        //             componentName = component.name;
        //             componentConfig = component.config;
        //         }
        //
        //         require('./components/' + componentName);
        //
        //         app.getComponent(componentName).setConfig(componentConfig).init();
        //         console.log('Component: \'' + componentName + '\' has been loaded...and initialized!');
        //     });
        // }

        // NotifyJS Default Configurations:
        $.notify.defaults({
            "autoHide": true,
            "autoHideDelay": 5000,
            "position": 'left bottom',
            "elementPosition": 'right bottom',
            "globalPosition": 'right bottom',
            "showDuration": 200,
            "style": 'bootstrap',
            "className": 'success',
            "clickToHide": true
        });

        return app;
    };

    /**
     * Initialize App.
     *
     * @param config
     */
    app.init = function(config) {

        //$('body').rainbowify();

        // Initialize all Bootstrap tooltip elements.
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]',
        });

        // Alter the scrolling behavior for the avatar to keep it at the top of the page, but underneath the header at all times.
        $(document).scroll(function() {
            if($(this).scrollTop() > 54) {
                $('#avatar').css({
                    position: 'fixed',
                    top: '1rem'
                });
            }
            else {
                $('#avatar').css({
                    position: 'absolute',
                    top: '1rem'
                });
            }
        });

        // Mousetrap event to go to the login page:
        mousetrap.bind('l o g i n', function() {
            window.location = app.url('login');
        });

        // Vertically expand all <textarea> elements as additional text is added into them.
        $('.autosize').autosize();
    };

    /**
     * Get a page by its name.
     *
     * @param pageName
     * @returns {*}
     */
    app.getPage = function(pageName) {
        for(let i = 0; i < app.appPages.length; i++) {
            if(pageName == app.appPages[i].pageName) {
                return app.appPages[i];
            }
        }
        return null;
    };

    /**
     * Get a component by its name.
     *
     * @param componentName
     * @returns {*}
     */
    app.getComponent = function(componentName) {
        for(let i = 0; i < app.appComponents.length; i++) {
            if(componentName == app.appComponents[i].componentName) {
                return app.appComponents[i];
            }
        }
        return null;
    };

    /**
     * Form a URL for this application by concatenating the base URL with a URI.
     *
     * @param uri
     * @returns {string}
     */
    app.url = function(uri = '') {
        let url = app.base_url + '/' + uri;
        return url.replace(/\/$/, ""); // Remove trailing slash, if there is one.
    };

    /**
     * Execute a function but only if user is logged in (or display a graceful unauthenticated message).
     *
     * @param fnToExecute
     * @param action
     */
    app.isAuthenticated = function(fnToExecute, action = 'do that') {
        if(! app.authenticatedUser) {

            // Not logged in, so notify user
            $.notify("You must be logged in to " + action + "!", {
                autoHideDelay: 8000,
                className: "danger"
            });
            return;
        }

        // User is logged in, so execute the function
        fnToExecute.call(this);
    };

})(window.NickMorgabWebApp, window.jQuery, window.Mousetrap);
