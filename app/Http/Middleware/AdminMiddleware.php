<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {

	public function handle(Request $request, Closure $next) {
		abort_if(!Auth::check() || !Auth::user()->isAdmin(), 403, 'Access denied');
		return $next($request);
	}
}
