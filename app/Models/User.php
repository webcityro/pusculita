<?php

namespace App\Models;

use App\Models\AffiliateLink;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	use HasFactory, Notifiable;

	protected $fillable = [
		'name',
		'email',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function affiliateLinks() {
		return $this->hasMany(AffiliateLink::class, 'userID');
	}

	public function isUser() {
		return $this->role == 'user';
	}

	public function isAdmin() {
		return $this->role == 'admin';
	}
}
