<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use Illuminate\Http\JsonResponse;
use Closure;


class SellerMiddleware
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
        $role_id = (auth()->user()->role_id);
        $role = Roles::find($role_id);
        try {
            if ($role->name !== 'seller') {
                return response()->json([
                    'error' => 'dont do this .'
                ], 204);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()], 401);
        }
        return $next($request);
    }

}
