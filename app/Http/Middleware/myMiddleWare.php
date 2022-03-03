<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class myMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        if(!$token){
            return response([
                "message" => "UnAuthorized"
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::where('id', $token->tokenable_id)->first();
        $request->merge([
            "user" => $user
        ]);
        if($user) return $next($request);
    }
}
