<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateLink extends Model {

	use HasFactory;

	protected $guarded = [];

	protected $casts = [
		'purchased' => 'datetime',
		'payed' => 'datetime',
	];

	public function user() {
		return $this->belongsTo(User::class, 'userID');
	}
}
