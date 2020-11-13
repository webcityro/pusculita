<template>
	<form-wrapper
		:url="apiUrl"
		:fields="{ name: '', originalURL: '' }"
		:show="show"
		:group="group"
		@close="$emit('close')"
	>
		<template slot-scope="{ group, showForm, fields, error, submit, cancel, processing, editing }">
			<modal
				:title="editing ? 'Your editing the affiliate link ('+editing.name+')' : 'Add affiliate link'"
				okButtonLabel="Save"
				:show="showForm"
				:processing="processing"
				@save="submit"
				@cancel="cancel"
			>
				<form-group
					id="name"
					label="Name:"
					:group="group"
					:error="error"
					v-model="fields.name"
					:rules="{
						required: 'The Name field is required.',
						'lengthRange:3,50': 'The Name field must contain between 3 and 50 characters.'
					}"
				/>

				<form-group
					id="originalURL"
					label="Product URL:"
					:group="group"
					:error="error"
					v-model="fields.originalURL"
					:rules="{
						required: 'The Product originalURL field is required.',
					}"
					:disabled="editing"
				/>
			</modal>
		</template>
	</form-wrapper>
</template>

<script>
	export default {
		props: {
			group: { type: String, required: true },
			apiUrl: { type: String, required: true },
			show: { type: Boolean, required: false, default: false }
		}
	}
</script>
