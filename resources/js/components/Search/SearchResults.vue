<template>
	<div>
		<div v-if="isLoading" class="text-center">
			<img src="/images/loader.svg" alt="Loading...">
		</div>
		<h3 v-else-if="currentTotal == 0" class="text-center">
			No {{ groupLabel || 'record' }}s found.
		</h3>
		<slot
			v-else
			:params="currentParams"
			:total="currentTotal"
			:records="currentRecords"
			:edit="edit"
			:destroy="destroy"
		></slot>

		<modal
			title="Warning!"
			:show="deleteRecord != null"
			:url="deleteRecord ? deleteRecord.destroyURL : ''"
			method="DELETE"
			@save="deleteRecord = null, fetch(group)"
			@cancel="deleteRecord = null"
			okButtonLabel="Delete"
			okButtonClass="btn btn-danger"
			okButtonIcon="fas fa-trash-alt"
			cancelButtonLabel="Cancel"
			cancelButtonClass="btn btn-primary"
			cancelButtonIcon="fas fa-times"
		>
			<p>{{ deleteMsg }}</p>
		</modal>
	</div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";

export default {
	props: {
		group: { type: String, required: true },
		groupLabel: { type: String, required: false }
	},

	data() {
		return {
			deleteRecord: null
		};
	},

	methods: {
		...mapActions('search', ['fetch']),

		edit(record) {
			EventBus.emit('editForm_'+this.group, record);
		},

		destroy(record) {
			this.deleteRecord = record;
		}
	},

	computed: {
		...mapState('search', ['params', 'records']),
		...mapGetters('search', ['total', 'loading']),

		currentParams() {
			return this.params[this.group];
		},

		currentRecords() {
			return this.records[this.group] || [];
		},

		currentTotal() {
			return this.total(this.group);
		},

		isLoading() {
			return this.loading(this.group);
		},

		deleteMsg() {
			return this.deleteRecord ? 'Are you sure theat you wanna delete the '+(this.groupLabel || 'item')+' "'+this.deleteRecord.name+'"?' : '';
		}
	}
}
</script>
