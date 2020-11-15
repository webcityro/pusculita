<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
	/**
	 * Validate and update the given user's profile information.
	 *
	 * @param  mixed  $user
	 * @param  array  $input
	 * @return void
	 */
	public function update($user, array $input)
	{
		Validator::make($input, array_merge([
			'name' => ['required', 'string', 'max:255'],

			'email' => [
				'required',
				'string',
				'email',
				'max:255',
				Rule::unique('users')->ignore($user->id),
			],
		], Auth::user()->role == 'admin' ? [
			'role' => [
				'sometimes',
				Rule::in(['user', 'admin'])
			],
			'active' => ['sometimes', 'boolean']
		] : []))->validateWithBag('updateProfileInformation');

		if ($input['email'] !== $user->email &&
			$user instanceof MustVerifyEmail) {
			$this->updateVerifiedUser($user, $input);
		} else {
			$user->forceFill($this->updateFields($input))->save();
		}
	}

	protected function updateFields($input) {
		return array_merge([
			'name' => $input['name'],
			'email' => $input['email'],
		], Auth::user()->role == 'admin' ? [
			'role' => $input['role'] ?? Auth::user()->role,
			'active' => $input['active'] ?? Auth::user()->active,
		] : []);
	}

	protected function updateVerifiedUser($user, array $input) {
		$user->forceFill(array_merge($this->updateFields($input), [
			'email_verified_at' => null,
		]))->save();

		$user->sendEmailVerificationNotification();
	}
}
