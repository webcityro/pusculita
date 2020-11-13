export default class ErrorHandler {
	static showError(
		{ response, message, log },
		errors,
		beforeCallback = null
	) {
		if (typeof beforeCallback === 'function') {
			beforeCallback();
		}

		if (response && response.data && response.data.errors) {
			errors.setBackendErrors(response.data.errors);
			return;
		}

		if (response && response.data && response.data.message) {
			ErrorHandler.errorDialog(response.data.message);
			return;
		}

		if (message) {
			ErrorHandler.errorDialog(message);
			return;
		}

		if (log) {
			console.error('Dev error message', log);
			return;
		}

		console.log({ errorHandler: error });
	}

	static errorDialog(message, id = 'request-failure') {
		EventBus.emit('topAlert', {
			id,
			message,
			style: 'danger'
		});
	}
}
