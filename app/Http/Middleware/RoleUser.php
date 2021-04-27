<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class RoleUser
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
        if ($account->role === 'user') {
            return $next($request);
        }
        return redirect()->route('coderequest.index');
    }
}
