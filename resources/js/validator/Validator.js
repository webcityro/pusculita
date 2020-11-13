import Rule from './Rule';

export default class Validator {
	constructor(wrapper, resolve, reject) {
		this.wrapper = wrapper;
		this.errors = {};

		Promise.all(this.promises())
			.then(() => {
				resolve();
			})
			.catch(error => {
				wrapper.errors.set(this.errors);
				reject(error);
			});
	}

	promises() {
		const promises = [];

		for (let field in this.wrapper.validationBag) {
			promises.push(this.validate(field));
		}

		return promises;
	}

	validate(field) {
		return new Promise((resolve, reject) => {
			const rules = this.wrapper.validationBag[field];
			const value = this.getValue(field);

			for (const key in rules) {
				const [rule, params] = key.split(':');

				if (params) {
					params = params.includes(',') ? params.split(',') : params;
				}

				try {
					if (!Rule[rule](value, params)) {
						this.errors[field] = [
							...(this.errors[field] || []),
							rules[key]
						];
						reject({
							message: 'The data was invalid.'
						});
					}
				} catch (error) {
					reject({
						log:
							'Invalid form validation rule: ' +
							rule +
							' at field ' +
							field
					});
				}

				if (Object.keys(rules)[Object.keys(rules).length - 1] == key) {
					resolve();
				}
			}
		});
	}

	getValue(field) {
		return field
			.split('.')
			.reduce((form, f) => form[f], this.wrapper.formFields);
	}
}
