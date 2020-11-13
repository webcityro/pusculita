export default class Error {
	constructor() {
		this.clear();
	}

	set(errors) {
		this.errors = errors;
	}

	setBackendErrors(errors) {
		let err = {};

		for (const key in errors) {
			err = {
				...err,
				...this.recursiveSetter(key, errors[key])
			};
		}

		this.set(err);
	}

	recursiveSetter(path, msg, obj = this.errors) {
		const pathArr = path.split('.');
		const key = pathArr.shift();
		obj[key] =
			pathArr.length === 0
				? msg
				: this.recursiveSetter(pathArr.join('.'), msg, obj[key]);
		return obj;
	}

	all() {
		return this.errors;
	}

	clear() {
		this.errors = {};
	}

	has(field) {
		return this.errors.hasOwnProperty(field);
	}

	get(field) {
		if (!this.has(field)) {
			return '';
		}

		return this.errors[field][0];
	}
}
