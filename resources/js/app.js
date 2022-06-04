// import {Console} from './Components/Console';
// import {BarrelRoll} from './Components/BarrelRoll';
// import {KeyboardComponent} from './Components/KeyboardComponent';
// import {Layout} from './Components/Layout';
// import {Mirror} from './Components/Mirror';
// import {Rotate} from './Components/Rotate';
// import {Url} from './Components/Url';
//
// // import {Alphabetizer, Welcome} from './Pages/*';
// import {Alphabetizer} from './Pages/Alphabetizer';
// import {ExamplePage} from './Pages/ExamplePage';
// import {Pgp} from './Pages/Pgp';
// import {Welcome} from './Pages/Welcome';
// import {WritingPage} from './Pages/WritingPage';
//
// class App {
//     appName = '';
//
//     appComponents = [];
//
//     appPages = [];
//
//     currentPage = '';
//
//     showAvatarIcon = true;
//
//     showBanner = true;
//
//     constructor(appName) {
//         this.appName = appName;
//     }
//
//     /**
//      * Initialize the Console.
//      */
//     init() {
//         Console.custom('Initializing ' + this.appName + ' app...');
//
//
//
//         // // Initialize all Bootstrap tooltip elements.
//         // $('body').tooltip({
//         //     selector: '[data-bs-toggle="tooltip"]',0
//         // });
//
//
//         let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=tooltip]'))
//         let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//             return new bootstrap.Tooltip(tooltipTriggerEl)
//         });
//
//
//         let alphabetizerPage = new Alphabetizer();
//         alphabetizerPage.load();
//         this.appPages.push(alphabetizerPage);
//
//         let examplePage = new ExamplePage();
//         examplePage.load();
//         this.appPages.push(examplePage);
//
//         let pgpPage = new Pgp();
//         pgpPage.load();
//         this.appPages.push(pgpPage);
//
//         let welcomePage = new Welcome();
//         welcomePage.load();
//         this.appPages.push(welcomePage);
//
//         let writingPage = new WritingPage();
//         writingPage.load();
//         this.appPages.push(writingPage);
//
//         // let url = location.href;
//         // document.body.addEventListener('click', ()=>{
//         //     requestAnimationFrame(()=>{
//         //         url!==location.href&&console.log('url changed');
//         //         url = location.href;
//         //     });
//         // }, true);
//
//
//         // // Create the event listener to mirror the page.
//         // $('body').on('click', '[data-action=MIRROR]', function(event) {
//         //     if($('body').hasClass('mirror')) {
//         //         $('body').removeClass('mirror');
//         //     }
//         //     else {
//         //         $('body').addClass('mirror');
//         //     }
//         // });
//
//         let barrelRollComponent = new BarrelRoll();
//         barrelRollComponent.load();
//         this.appComponents.push(barrelRollComponent);
//
//         let keyboardComponent = new KeyboardComponent();
//         keyboardComponent.load();
//         this.appComponents.push(keyboardComponent);
//
//         let layoutComponent = new Layout();
//         layoutComponent.load();
//         this.appComponents.push(layoutComponent);
//
//         let mirrorComponent = new Mirror();
//         mirrorComponent.load();
//         this.appComponents.push(mirrorComponent);
//
//         let rotateComponent = new Rotate();
//         rotateComponent.load();
//         this.appComponents.push(rotateComponent);
//
//         let urlComponent = new Url();
//         urlComponent.load();
//         this.appComponents.push(urlComponent);
//
//         Console.log('\n...' + this.appName + ' app initialized!');
//     }
//
//     // loadComponent(componentName) {
//     //     // ;(function(app, $, undefined) {
//     //     //     app.appComponents.push({});
//     //     // });
//     //     // require('./Components/BaseComponent');
//     //     // require('./Components/Console');
//     //     // require('./Components/Mirror');
//     //
//     //     // this.appComponents.push(new Mirror());
//     //
//     //     let myclass = window[componentName];
//     //     // now you have a reference to the object, the new keyword will work:
//     //     let inst = new myclass();
//     // }
// }
//
// export {App};

// let NickMorganApp = new App('Nick Morgan Web App');

// NickMorganApp.appComponents.forEach(function(componentName, index) {
//
//     require('./Components/' + componentName);
//
//     app.getComponent(componentName).setConfig(componentConfig).init();
//     console.log('Component: \'' + componentName + '\' has been loaded... and initialized!');
// });

// NickMorganApp.init();


// Bootstrap the application's JavaScript dependencies:
require('./bootstrap');


// Import Components
import {Application} from './Application';



// Create the namespace for the application:
let application = new Application({
    'isSinglePageApp': false,
    'logLevel': 'debug',
});
application.init();


window.NickMorgabWebApp = application;

// // Fire the self-executing function to load the application:
// ;(function(app, $, undefined) {
//
//     app.init();
//
// })(window.NickMorgabWebApp, window.jQuery);
