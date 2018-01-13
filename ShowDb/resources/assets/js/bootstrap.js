window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('../../../node_modules/jquery/dist/jquery.js');
    require('bootstrap-sass');
} catch (e) {}

window.bootbox = require('imports?define=>false!../../../node_modules/bootbox.js/bootbox.js');
require('imports?define=>false!trumbowyg');
require('imports?define=>false!../../../node_modules/trumbowyg/plugins/base64/trumbowyg.base64.js');
require('imports?define=>false!../../../node_modules/jquery-on-screen/index.js');
require('imports?define=>false!../../../node_modules/typeahead.js/dist/typeahead.jquery.js');
require('imports?define=>false!../../../node_modules/blueimp-gallery/js/jquery.blueimp-gallery.min.js');
window.Bloodhound = require('imports?define=>false!../../../node_modules/typeahead.js/dist/bloodhound.js');
window.GoogleCharts = require('google-charts').GoogleCharts;
window.Clipboard = require('imports?define=>false!clipboard');
window.getVideoId = require('imports?define=>false!../../../node_modules/get-video-id/index.js');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

var req = require.context("./app", true, /^(.*\.(js$))[^.]*$/igm);
req.keys().forEach(function(key){
    req(key);
});

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });
