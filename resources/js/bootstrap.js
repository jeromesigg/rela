import _ from 'lodash';

window._ = _;
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import jquery  from 'jquery';
window.jQuery = jquery ;
window.$ = jquery ;
// import 'jquery-ui/dist/jquery-ui.min.js'
//
// import 'bootstrap/js/dist/modal';



import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// import $ from 'jquery';
// window.$ = $;



// import DataTable from 'datatables.net';
// window.DataTable = DataTable;
