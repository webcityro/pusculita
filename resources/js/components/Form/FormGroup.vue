<template>
	<div :class="computedWrapperCssClasses">
		<label :for="id" :class="computedLabelCssClasses">{{ label }}</label>
		<slot>
			<input
				:type="type"
				:id="id"
				:class="computedInputCssClasses"
				:value="value"
				@input="e => $emit('input', e.target.value)"
				v-bind="$attrs"
			>
		</slot>
		<div v-if="hasFeedback" :class="computedFeedbackCssClasses">{{ getFeedback }}</div>
	</div>
</template>

<script>
import Helper from "../../core/Helper";
import Error from "../../validator/Error";

export default {
	props: {
		group: { type: String, required: true },
		id: { type: String, required: true },
		name: { type: String, required: false },
		label: { type: String, required: true },
		value: { type: String, required: true },
		feedback: { type: String, required: false },
		type: { type: String, required: false, default: 'text' },
		whapperCssClass: { type: String, required: false, default: 'form-group' },
		whapperErrorCssClass: { type: String, required: false, default: '' },
		whapperValidCssClass: { type: String, required: false, default: '' },
		labelCssClass: { type: String, required: false, default: '' },
		labelErrorCssClass: { type: String, required: false, default: '' },
		labelValidCssClass: { type: String, required: false, default: '' },
		inputCssClass: { type: String, required: false, default: 'form-control' },
		inputErrorCssClass: { type: String, required: false, default: 'is-invalid' },
		inputValidCssClass: { type: String, required: false, default: 'is-valid' },
		feedbackCssClass: { type: String, required: false, default: 'form-text' },
		validFeedbackCssClass: { type: String, required: false, default: 'valid-feedback' },
		invalidFeedbackCssClass: { type: String, required: false, default: 'invalid-feedback' },
		rules: { type: Object, required: false },
		error: { type: Object, required: false, default: () => new Error },
	},

	mounted() {
		this.init();
	},

	methods: {
		init() {
			if (!Helper.isEmpty(this.rules)) {
				EventBus.emit('formValidationRules_'+this.group, {
					field: this.id,
					rules: this.rules
				});
			}
		}
	},

	computed: {
		computedName() {
			return this.name || this.id;
		},

		computedCssClasses() {
			return (defaultClass, errorClass, validClass) => [
				defaultClass,
				{
					[errorClass]: this.hasError,
					[validClass]: this.formValidated && !this.hasError
				}
			];
		},

		computedWrapperCssClasses() {
			return this.computedCssClasses(
				this.whapperCssClass,
				this.whapperErrorCssClass,
				this.whapperValidCssClass
			);
		},

		computedLabelCssClasses() {
			return this.computedCssClasses(
				this.labelCssClass,
				this.labelErrorCssClass,
				this.labelValidCssClass
			);
		},

		computedInputCssClasses() {
			return this.computedCssClasses(
				this.inputCssClass,
				this.inputErrorCssClass,
				this.inputValidCssClass
			);
		},

		computedFeedbackCssClasses() {
			return this.computedCssClasses(
				this.hasFeedback && !this.hasError ? this.feedbackCssClass  : '',
				this.invalidFeedbackCssClass,
				this.validFeedbackCssClass
			);
		},

		hasError() {
			return this.error.has(this.id);
		},

		getError() {
			return this.error.get(this.id);
		},

		hasFeedback() {
			return this.feedback || this.hasError;
		},

		getFeedback() {
			return this.hasError ? this.getError : this.feedback;
		},

		formValidated() {
			return false;
		}
	}
}
</script>

<style>

</style>
