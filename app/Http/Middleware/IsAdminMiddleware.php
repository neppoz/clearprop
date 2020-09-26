<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->is_admin) {
            try {
                return redirect('pilot');
            } catch (Throwable $e) {
                report($e);
                abort(403);
            }
        }

        return $next($request);
    }
}
