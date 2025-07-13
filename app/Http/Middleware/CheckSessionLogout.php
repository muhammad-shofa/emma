<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\userModel;

class CheckSessionLogout
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() && session()->has('user_id')) {
            $userId = session()->get('user_id');
            $user = userModel::find($userId);

            if ($user && $user->is_login == 1) {
                $user->update(['is_login' => 0]);
            }

            session()->forget('user_id');
        }

        return $next($request);
    }
}
