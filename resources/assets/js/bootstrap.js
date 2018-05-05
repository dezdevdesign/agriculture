window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    window.Tether = require('tether');
    require('bootstrap');
} catch (e) {}

// These are the template dependencies for the app.
// Leaflet
require('leaflet');
window.leafletDraw = require('leaflet-draw');
window.Waves = require('node-waves');
require('jquery.scrollbar');
require('jquery-scroll-lock');
window.easyPieChart = require('easy-pie-chart');
require('salvattore');
window.moment = require('moment');
window.fullCalendar = require('fullcalendar');
window.dt = require('datatables.net');
window.flot = require('flot');
require('flot-orderbars/js/jquery.flot.orderBars');
require('flot/jquery.flot.pie');
require('flot.curvedlines');
window.JSZip = require('jszip/dist/jszip.min');
window.buttons = require('datatables.net-buttons');
require('datatables.net-buttons/js/buttons.print.min');
require('datatables.net-buttons/js/buttons.html5.min');
require('datatables.net-responsive');
require('autosize');
require('jquery-mask-plugin');
window.select2 = require('select2');
require('dropzone');
require('nouislider');
require('bootstrap-colorpicker');
require('trumbowyg');
window.swal = require('sweetalert2');
require('lightgallery');
window.notify = require('bootstrap-notify');
require('flatpickr');
require('bootstrap-datepicker');
require('leaflet-compass/src/leaflet-compass');
window.LGeo = require('leaflet-geodesy')
require('parsleyjs');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
