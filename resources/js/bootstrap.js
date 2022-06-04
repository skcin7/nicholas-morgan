/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    // window.Mousetrap = require('./lib/mousetrap');
    //window.Jsnes = require('./lib/jsnes');
    // window.axios = require('axios');
    //
    // let token = document.head.querySelector('meta[name=csrf-token]');
    // window.axios.defaults.headers.common = {
    //     'X-CSRF-TOKEN': token.content,
    //     'X-Requested-With': 'XMLHttpRequest'
    // };

    // require('bootstrap');
    // window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js');
    window.bootstrap = require('bootstrap');
    // require('./lib/jquery.appear');
    require('./lib/jquery.autosize');
    // require('./lib/jquery.colorbox');
    require('./lib/jquery.notify');
    // require('./lib/jquery.scrollup');

    // // Require all the Components
    // require('./Components/BaseComponent');
    // require('./Components/Console');
    // require('./Components/Mirror');
    //
    // // Require all the Errors
    // require('./Errors/BaseError');
    // require('./Errors/InvalidValueError');
    //
    // // Require all the Pages
    // require('./Pages/BasePage');
    // require('./Pages/Welcome');
    // require('./Pages/Alphabetizer');
}
catch(ex) {
    //
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
