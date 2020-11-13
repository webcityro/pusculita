<template>
	<div v-if="isVisible">
		<div
			:class="wrapperCssClass"
			role="alert"
			v-html="message"
		></div>
	</div>
</template>

<script>
import Helper from "../../core/Helper";

export default {
	props: {
		sessionDialog: { type: Object, default: () => { return {}; } }
	},

	data() {
		return {
			id: null,
			style: 'info',
			timeout: null,
			time: 7000,
			data: {},
			message: ''
		};
	},

	created() {
		this.init();
	},

	mounted() {
		if (!Helper.isEmpty(this.sessionDialog)) {
			setTimeout(() => {
				EventBus.emit('topAlert', {
					id: 'session-topAlert',
					message: this.sessionDialog.message,
					style: this.sessionDialog.style,
					time: this.sessionDialog.time || this.time
				});
			}, 500);
		}
	},

	methods: {
		init() {
			EventBus.on('clearTopDialog', this.clear);
			EventBus.on('topAlert', this.alert);
		},

		isType(type) {
			return this.type === type;
		},

		visibleCssClass(type) {
			return {
				active: this.isVisible && this.isType(type)
			};
		},

		clear(data = null) {
			this.clearCountDown();
			this.style = 'info';
			this.message = '';
			this.data = {};
			this.time = 7000;

			EventBus.emit(this.id + '-cleared', data || {});
		},

		clearCountDown() {
			if (this.timeout === null) {
				return;
			}

			clearTimeout(this.timeout);
			this.timeout = null;
		},

		alert(data) {
			this.clear();
			this.id = data.id;
			this.style = data.style || this.style;
			this.message = data.message;
			this.time = data.time || this.time;
			this.countDown();
		},

		countDown() {
			this.timeout = setTimeout(() => {
				this.clear();
			}, this.time);
		},
	},

	computed: {
		isVisible() {
			return !Helper.isEmpty(this.message);
		},

		wrapperCssClass() {
			return [
				'alert',
				'alert-'+this.style,
				'text-center'
			];
		}
	}
};
</script>

<style>
</style>
