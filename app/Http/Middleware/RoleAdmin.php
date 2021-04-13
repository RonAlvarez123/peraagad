<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class RoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $account = Account::select('role')->where('user_id', auth()->user()->user_id)->first();
        if ($account->role === 'admin') {
            return $next($request);
        }
        return redirect()->route('profile.index');
    }
}
