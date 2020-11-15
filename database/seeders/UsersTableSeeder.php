<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	public function run() {
		User::create([
			'name' => 'Andy',
			'email' => 'andreivalcu@gmail.com',
			'password' => bcrypt('alexandra'),
			'role' => 'admin',
			'active' => true,
		]);

		User::create([
			'name' => 'Luci',
			'email' => 'lucianradu@yahoo.com',
			'password' => bcrypt('phpmaster'),
			'role' => 'user',
			'active' => false,
		]);
	}
}
