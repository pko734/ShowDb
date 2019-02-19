window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.bootbox = require('../../../node_modules/bootbox.js/bootbox.js');
require('trumbowyg');
require('../../../node_modules/trumbowyg/plugins/base64/trumbowyg.base64.js');
require('../../../node_modules/jquery-on-screen/index.js');
require('../../../node_modules/typeahead.js/dist/typeahead.jquery.js');
require('../../../node_modules/blueimp-gallery/js/jquery.blueimp-gallery.min.js');
require('../../../node_modules/bootstrap-validator/dist/validator.js');
require('../../../node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js');

window.Bloodhound = require('../../../node_modules/typeahead.js/dist/bloodhound.js');
window.Clipboard = require('clipboard');
window.getVideoId = require('../../../node_modules/get-video-id/index.js');


var req = require.context("./app", true, /^(.*\.(js$))[^.]*$/im);
req.keys().forEach(function(key){
    req(key);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
