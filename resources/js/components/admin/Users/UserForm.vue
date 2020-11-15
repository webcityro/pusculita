<template>
	<form-wrapper
		:url="apiUrl"
		:fields="{ name: '', email: '', password: '', role: '', active: '' }"
		:show="show"
		:group="group"
		@close="$emit('close')"
	>
		<template slot-scope="{ group, showForm, fields, error, submit, cancel, processing, editing }">
			<modal
				:title="editing ? 'Your editing the user ('+editing.name+')' : 'Add a new user'"
				okButtonLabel="Save"
				:show="showForm"
				:processing="processing"
				@save="submit"
				@cancel="cancel"
			>
				<form-group
					id="name"
					label="Full name:"
					:group="group"
					:error="error"
					v-model="fields.name"
					:rules="{
						required: 'The Full name is required.',
						'lengthRange:3,50': 'The Full name must contain between 3 and 50 characters.',
						alpha: 'The :attribute may only contain letters.'
					}"
				/>

				<form-group
					id="email"
					label="Email Address:"
					type="email"
					:group="group"
					:error="error"
					v-model="fields.email"
					:rules="{
						required: 'The Email address is required.',
						email: 'The Email address must be a valid email.',
					}"
				/>

				<form-group-password
					v-if="editing == null"
					id="password"
					label="Password:"
					type="password"
					:group="group"
					:error="error"
					v-model="fields.password"
				/>

				<form-group
					id="role"
					label="User role:"
					:group="group"
					:error="error"
					:rules="{
						required: 'The User role is required.'
					}"
				>
					<select v-model="fields.role" id="role" class="form-control">
						<option value="user">User</option>
						<option value="admin">Admin</option>
					</select>
				</form-group>

				<form-group
					id="active"
					label="Status:"
					:group="group"
					:error="error"
					:rules="{
						required: 'The Status is required.'
					}"
				>
					<select v-model="fields.active" id="active" class="form-control">
						<option :value="true">Active</option>
						<option :value="false">Inactive</option>
					</select>
				</form-group>
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
