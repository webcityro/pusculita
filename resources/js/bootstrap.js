window.$ = require('jquery');

try {
	require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import EventBus from './core/EventBus';
import ErrorHandler from './core/ErrorHandler';

window.EventBus = new EventBus();
window.ErrorHandler = ErrorHandler;
