<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider {

	public function register() {
		//
	}

	public function boot() {
		Fortify::createUsersUsing(CreateNewUser::class);
		Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
		Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
		Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

		Fortify::authenticateUsing(function (Request $request) {
			$user = User::where('email', $request->email)->first();

			if (
				$user &&
				Hash::check($request->password, $user->password) &&
				$user->active
			) {
				return $user;
			}
		});

		Fortify::loginView(function () {
			return view('auth.login');
		});

		Fortify::registerView(function () {
			return view('auth.register');
		});

		Fortify::requestPasswordResetLinkView(function () {
			return view('auth.passwords.email');
		});

		Fortify::resetPasswordView(function ($request) {
			return view('auth.passwords.reset', ['request' => $request]);
		});
	}
}
