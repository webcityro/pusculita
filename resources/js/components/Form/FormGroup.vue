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
import FormGroupBase from "../../mixins/FormGroupBase";

export default {
	mixins: [FormGroupBase]
}
</script>
