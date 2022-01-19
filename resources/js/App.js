// Bootstrap the application's JavaScript dependencies:
require('./bootstrap');

import {Console} from './Components/Console';
import {BarrelRoll} from './Components/BarrelRoll';
import {Layout} from './Components/Layout';
import {Mirror} from './Components/Mirror';
import {Rotate} from './Components/Rotate';
import {Url} from './Components/Url';

// import {Alphabetizer, Welcome} from './Pages/*';
import {Alphabetizer} from './Pages/Alphabetizer';
import {Pgp} from './Pages/Pgp';
import {Welcome} from './Pages/Welcome';

class App {
    appName = '';

    appComponents = [];

    appPages = [];

    currentPage = '';

    showAvatarIcon = true;

    showBanner = true;

    constructor(appName) {
        this.appName = appName;
    }

    /**
     * Initialize the Console.
     */
    init() {
        Console.log('Initializing ' + this.appName + ' app...\n');



        // Initialize all Bootstrap tooltip elements.
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]',
        });



        let alphabetizerPage = new Alphabetizer();
        alphabetizerPage.load();
        this.appPages.push(alphabetizerPage);

        let pgpPage = new Pgp();
        pgpPage.load();
        this.appPages.push(pgpPage);

        let welcomePage = new Welcome();
        welcomePage.load();
        this.appPages.push(welcomePage);

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
        this.appComponents.push(barrelRollComponent);

        let layoutComponent = new Layout();
        layoutComponent.load();
        this.appComponents.push(layoutComponent);

        let mirrorComponent = new Mirror();
        mirrorComponent.load();
        this.appComponents.push(mirrorComponent);

        let rotateComponent = new Rotate();
        rotateComponent.load();
        this.appComponents.push(rotateComponent);

        let urlComponent = new Url();
        urlComponent.load();
        this.appComponents.push(urlComponent);

        Console.log('\n...' + this.appName + ' app initialized!');
    }

    // loadComponent(componentName) {
    //     // ;(function(app, $, undefined) {
    //     //     app.appComponents.push({});
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

// let NickMorganApp = new App('Nick Morgan Web App');

// NickMorganApp.appComponents.forEach(function(componentName, index) {
//
//     require('./Components/' + componentName);
//
//     app.getComponent(componentName).setConfig(componentConfig).init();
//     console.log('Component: \'' + componentName + '\' has been loaded... and initialized!');
// });

// NickMorganApp.init();









// Create the namespace for the application:
window.NickMorgabWebApp = new App('Nick Morgan Website');

// Fire the self-executing function to load the application:
;(function(app, $, undefined) {

    app.init();



    // let consoleComponent = new Console();
    // consoleComponent.load();
    // app.appComponents.push(consoleComponent);

    // app.loadComponent('Mirror');

    // // Create the event listener to mirror the page.
    // $('body').on('click', '[data-action=MIRROR]', function(event) {
    //     event.preventDefault();
    //
    //     if($('body').hasClass('mirrored')) {
    //         $('body').removeClass('mirrored');
    //     }
    //     else {
    //         $('body').addClass('mirrored');
    //     }
    // });

})(window.NickMorgabWebApp, window.jQuery);
