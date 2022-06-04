import {Console} from './Components/ConsoleComponent';

import {BarrelRollComponent as BarrelRoll} from './Components/BarrelRollComponent';
import {KeyboardComponent} from './Components/KeyboardComponent';
import {Layout} from './Components/Layout';
import {Mirror} from './Components/Mirror';
import {Rotate} from './Components/Rotate';
import {Url} from './Components/Url';

// import {Alphabetizer, Welcome} from './Pages/*';
import {Alphabetizer} from './Pages/Alphabetizer';
import {ExamplePage} from './Pages/ExamplePage';
import {Pgp} from './Pages/Pgp';
import {Welcome} from './Pages/Welcome';
import {WritingPage} from './Pages/WritingPage';

class Application {
    static appName = 'Nick Morgan';
    static appVersion = '0.0.1-alpha';

    /**
     * The level of urgency to show logs for.
     * @type {string}
     */
    logLevel = 'debug';

    /**
     * Whether or not the application is a SPA (single-page app).
     * @type {boolean}
     */
    isSinglePageApp = false;

    /**
     * Components that are added into the application.
     * @type {[]}
     */
    components = [];

    /**
     * Pages that are added into the application.
     * @type {[]}
     */
    pages = [];

    // currentPage = '';

    // showAvatarIcon = true;

    // showBanner = true;

    /**
     * Create the new application instance.
     * @param appOptions
     */
    constructor(appOptions) {
        Console.custom(Application.appName + ' (v' + Application.appVersion + ')');

        // Ensure that required properties are present, or revert to the default values for them if not present.
        appOptions.logLevel = (typeof appOptions.logLevel !== 'undefined') ? appOptions.logLevel : 'debug';
        appOptions.isSinglePageApp = (typeof appOptions.isSinglePageApp !== 'undefined') ? appOptions.isSinglePageApp : false;

        // Set the application's properties.
        this.logLevel = appOptions.logLevel;
        this.isSinglePageApp = appOptions.isSinglePageApp;
    }

    /**
     * Initialize the Console.
     */
    init() {
        // // Initialize all Bootstrap tooltip elements.
        // $('body').tooltip({
        //     selector: '[data-bs-toggle="tooltip"]',
        // });

        // $('body').tooltip({
        //     selector: '[data-bs-toggle="tooltip"]',
        // });


        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=tooltip]'))
        let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });


        let alphabetizerPage = new Alphabetizer();
        alphabetizerPage.load();
        this.addPage(alphabetizerPage);

        let examplePage = new ExamplePage();
        examplePage.load();
        this.addPage(examplePage);

        let pgpPage = new Pgp();
        pgpPage.load();
        this.addPage(pgpPage);

        let welcomePage = new Welcome();
        welcomePage.load();
        this.addPage(welcomePage);

        let writingPage = new WritingPage();
        writingPage.load();
        this.addPage(writingPage);

        // let url = location.href;
        // document.body.addEventListener('click', ()=>{
        //     requestAnimationFrame(()=>{
        //         url!==location.href&&console.log('url changed');
        //         url = location.href;
        //     });
        // }, true);


        // // Create the event listener to mirror the page.
        // $('body').on('click', '[data-action=MIRROR]', function(event) {
        //     if($('body').hasClass('mirror')) {
        //         $('body').removeClass('mirror');
        //     }
        //     else {
        //         $('body').addClass('mirror');
        //     }
        // });

        let barrelRollComponent = new BarrelRoll();
        barrelRollComponent.load();
        this.addComponent(barrelRollComponent);

        let keyboardComponent = new KeyboardComponent();
        keyboardComponent.load();
        this.addComponent(keyboardComponent);

        let layoutComponent = new Layout();
        layoutComponent.load();
        this.addComponent(layoutComponent);

        let mirrorComponent = new Mirror();
        mirrorComponent.load();
        this.addComponent(mirrorComponent);

        let rotateComponent = new Rotate();
        rotateComponent.load();
        this.addComponent(rotateComponent);

        let urlComponent = new Url();
        urlComponent.load();
        this.addComponent(urlComponent);
    }

    addComponent(component) {
        this.components.push(component);
    }

    getComponent(componentName) {
        for(let i = 0; i < this.components.length; i++) {
            if(this.components[i].getComponentName() == componentName) {
                return this.components[i];
            }
        }
        return null;
    }

    addPage(page) {
        this.pages.push(page);
    }

    getPage(pageName) {
        for(let i = 0; i < this.pages.length; i++) {
            if(this.pages[i].getPageName() == pageName) {
                return this.pages[i];
            }
        }
        return null;
    }

    // loadComponent(componentName) {
    //     // ;(function(app, $, undefined) {
    //     //     app.components.push({});
    //     // });
    //     // require('./Components/BaseComponent');
    //     // require('./Components/Console');
    //     // require('./Components/Mirror');
    //
    //     // this.appComponents.push(new Mirror());
    //
    //     let myclass = window[componentName];
    //     // now you have a reference to the object, the new keyword will work:
    //     let inst = new myclass();
    // }
}

export {Application};
