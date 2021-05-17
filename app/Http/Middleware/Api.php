<?php

namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        if (request()->header('Authorization'))
        {
            if (User::where('api_token', request()->header('Authorization'))->first())return $next($request);
        }
        $data = [
            'status' => false,
            'message' => __('api.Authorization'),
            'date' => null
        ];
        return response()->json($data);
    }
}
