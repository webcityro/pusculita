<template>
	<form>
		<slot
			:group="group"
			:fields="formFields"
			:showForm="displayForm"
			:error="errors"
			:validate="validate"
			:submit="submit"
			:cancel="cancel"
			:reset="reset"
			:processing="processing"
			:editing="editRecord"
		></slot>
	</form>
</template>

<script>
import Helper from "../../core/Helper";
import Validator from "../../validator/Validator";
import Error from "../../validator/Error";
import ApiCaller from "../../core/ApiCaller";
import ErrorHandler from "../../core/ErrorHandler";
import { mapActions } from "vuex";

export default {
	props: {
		url: { type: String, required: true },
		group: { type: String, required: true },
		idColumn: { type: String, required: false, default: 'id' },
		record: { type: Object, required: false, default: null },
		fields: { type: Object, required: true },
		show: { type: Boolean, required: false, default: false },
	},

	data() {
		return {
			formFields: {},
			validationBag: {},
			editRecord: null,
			errors: new Error,
			displayForm: false,
			processing: false
		};
	},

	created() {
		this.reset();
		this.init();
		this.formFields = this.populateFields();
	},

	methods: {
		...mapActions('search', ['goToFirstPageSortByIdDesc', 'replaceRecord']),

		init() {
			EventBus.on('formValidationRules_'+this.group, ({field, rules}) => {
				this.validationBag[field] = rules;
			});

			EventBus.on('editForm_'+this.group, record => {
				this.editRecord = record;
				this.handleEdit(record);
			});
		},

		populateFields(fields = { ...this.fields }, record = this.editRecord) {
			if (!record) {
				return fields;
			}

			for (const field in fields) {
				if (record.hasOwnProperty(field)) {
					fields[field] = Helper.isObject(fields[field]) ? this.populateFields(fields[field], record[field]) : record[field];
				}
			}
			return fields;
		},

		submit() {
			this.validate().then(this.save).catch(error => {
				console.log({validationErrorFromSubmit: error});
			});
		},

		save(processing = true) {
			this.startProcessingAjaxCallEvent(processing);
			ApiCaller.request(this.requestURL, this.requestMethod, this.formFields)
				.then(this.requestSuccess)
				.catch(this.requestFailed);
		},

		requestSuccess({ status, data }) {
			if (this.editRecord) {
				this.replaceRecord({
					group: this.group,
					idColumn: this.idColumn,
					record: data.record
				});
			} else if (status == 201) {
				this.goToFirstPageSortByIdDesc(this.group);
			}

			if (data.message) {
				EventBus.emit('topAlert', {
					id: 'request-success',
					message: data.message,
					style: 'success'
				});
			}
			this.cancel();
		},

		requestFailed(response) {
			if (response && response.data && !response.data.errors) {
				this.cancel();
			}
			ErrorHandler.showError(response, this.errors, this.stopProcessingAjaxCall);
		},

		validate() {
			return new Promise((resolve, reject) => {
				if (!this.requiresValidation()) {
					resolve();
					return;
				}

				this.errors = new Error;
				new Validator(this, resolve, reject);
			});
		},

		requiresValidation() {
			return !Helper.isEmpty(this.validationBag);
		},

		handleEdit(record) {
			this.editRecord = record;
			this.formFields = this.populateFields();

			if (record) {
				return this.showForm();
			}
			this.reset();
		},

		reset() {
			this.formFields = this.populateFields();
			this.errors = new Error;
			this.editRecord = null;
			EventBus.emit('formReset_', this.group);
		},

		cancel() {
			this.reset();
			this.hideForm();
			this.$emit('close');
		},

		showForm() {
			this.displayForm = true;
		},

		hideForm() {
			this.displayForm = false;
		},

		startProcessingAjaxCallEvent(processing = true) {
			this.processing = processing;
		},

		stopProcessingAjaxCallEvent() {
			this.processing = false;
		}
	},

	computed: {
		requestURL() {
			return this.editRecord && this.editRecord.updateURL
				? this.editRecord.updateURL
				: this.url+(this.editRecord ? '/'+this.editRecord[this.idColumn] : '');
		},

		requestMethod() {
			return this.editRecord ? 'PUT' : 'POST';
		}
	},

	watch: {
		show: {
			handler(show) {
				if (show) {
					return this.showForm();
				}
				this.hideForm();
			},
			immediate: true
		},

		record: {
			handler(record) {
				this.handleEdit(record);
			},
			immediate: true
		}
	}
}
</script>
