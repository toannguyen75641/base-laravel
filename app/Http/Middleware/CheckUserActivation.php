<?php

namespace App\Http\Middleware;

use App\Constants\AdminUserConstant;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserActivation
{
    /**
     * Check user activation.
     *
     * @param $request
     * @param Closure $next
     *
     * @return Response|mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = Auth::user();
        if (!(is_null($auth->deleted_at)
                && $auth->status === AdminUserConstant::STATUS_ACTIVE
                && $auth->locked === AdminUserConstant::UNLOCK)) {
            return response()->view('error.404');
        }

        return $next($request);
    }
}
