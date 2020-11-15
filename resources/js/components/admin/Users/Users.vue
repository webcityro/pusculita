<template>
	<div class="card">
		<div class="card-header">Users</div>
		<div class="card-body">
			<div class="row justify-content-center">
				<div class="col-12 text-right">
					<a href="#" class="btn btn-primary" @click.prevent="showForm = true">
						<i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add user</a>
				</div>
			</div>
			<!-- Search -->
			<search-form
				:group="group"
				:url="fetchUrl"
				:params="{
					search: {
						id: '',
						name: '',
						email: '',
						rome: '',
					}
				}"
				:inputs="{
					id: {
						label: 'ID',
						type: 'text'
					},
					name: {
						label: 'Name',
						type: 'text'
					},
					email: {
						label: 'Email',
						type: 'text'
					},
					role: {
						label: 'Role',
						type: 'select',
						options:  {
							'': '',
							user: 'User',
							admin: 'Admin'
						}
					}
				}"
				:order-by="{
					id: 'ID',
					name: 'Name',
					email: 'Email',
					role: 'Role'
				}"
			></search-form>
			<!-- /Search -->

			<!-- Records -->
			<search-results
				:group="group"
				v-slot="{ total, records, edit, destroy }"
			>
				<div>
					<p>Total number of affiliate links: {{ total }}</p>

					<table v-if="records.length" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="user in records"
								:key="user.id"
							>
								<td>{{ user.id }}</td>
								<td>{{ user.name }}</td>
								<td>{{ user.email }}</td>
								<td>{{ user.role }}</td>
								<td>
									<a
										href="#"
										class="btn btn-primary"
										@click.prevent="edit(user)"
									>
										<i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit
									</a>
									<a
										v-if="user.id != $auth.id"
										href="#"
										class="btn btn-danger"
										@click.prevent="destroy(user)"
									>
										<i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</search-results>
			<!-- /Records -->

			<!-- Pagination -->
			<search-pagination
				:group="group"
				always-show
				show-first-and-last
				align="center"
			></search-pagination>
			<!-- /Pagination -->
		</div>

		<user-form
			:api-url="saveUrl"
			:group="group"
			:show="showForm"
			@close="showForm = false"
		></user-form>
	</div>
</template>

<script>
export default {
	props: {
		fetchUrl: { type: String, required: true },
		saveUrl: { type: String, required: true }
	},

	data() {
		return {
			showForm: false,
			group: 'users'
		};
	}
}
</script>

<style>

</style>
