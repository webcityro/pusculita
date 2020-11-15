require('./bootstrap');

window.Vue = require('vue');
window.Vue.prototype.$auth = window.Auth;
window.Vue.prototype.$larasearch = window.Larasearch;

import store from './store/index';

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key =>
	Vue.component(
		key
			.split('/')
			.pop()
			.split('.')[0],
		files(key).default
	)
);

const app = new Vue({
	store,
	el: '#app'
});
