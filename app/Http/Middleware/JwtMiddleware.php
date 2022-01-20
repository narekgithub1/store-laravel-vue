<?php

namespace App\Http\Middleware;

use App\Models\User;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Exception;
use Closure;


class JwtMiddleware
{

    /**
     * Handle on incoming request.
     *
     * @param $request
     * @param Closure $next
     * @param JsonResponse|mixed
     */

    public function handle($request, Closure $next)
    {
        try {
            $token = $request->header('authorization');

            if (!$token) {
                return response()->json([
                    'error' => 'Token not provided.'
                ], 401);
            }
            $credentials = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 401);
        }

        $user = User::find($credentials->sub);
        $request->auth = $user;

        return $next($request);
    }

}
