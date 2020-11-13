<template>
	<div class="card">
		<div class="card-header">Affiliate links</div>
		<div class="card-body">
			<div class="row justify-content-center">
				<div class="col-12 text-right">
					<a href="#" class="btn btn-primary" @click.prevent="showForm = true">
						<i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add affiliate link
					</a>
				</div>
			</div>
			<!-- Search -->
			<search-form
				:group="group"
				:url="fetchUrl"
				:params="{
					search: {
						name: '',
						originalURL: '',
						affiliateURL: ''
					}
				}"
				:inputs="{
					name: {
						label: 'Name',
						type: 'text'
					},
					originalURL: {
						label: 'Original URL',
						type: 'text'
					},
					affiliateURL: {
						label: 'Link',
						type: 'text'
					}
				}"
				:order-by="{
					id: 'ID',
					name: 'Name'
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
								<th>Link</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="link in records"
								:key="link.id"
							>
								<td>{{ link.id }}</td>
								<td>{{ link.name }}</td>
								<td><a :href="link.goToURL">{{ link.goToURL }}</a></td>
								<td>
									<a
										href="#"
										class="btn btn-primary"
										@click.prevent="edit(link)"
									>
										<i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit
									</a>
									<a
										href="#"
										class="btn btn-danger"
										@click.prevent="destroy(link)"
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

		<add-link-form
			:api-url="saveUrl"
			:group="group"
			:show="showForm"
			@close="showForm = false"
		></add-link-form>
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
			group: 'affiliateLinks'
		};
	}
}
</script>

<style>

</style>
