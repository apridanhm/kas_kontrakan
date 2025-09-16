<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminBasicAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->getUser();
        $pass = $request->getPassword();

        $cfgUser = config('app.admin_user', env('ADMIN_USER'));
        $cfgPass = config('app.admin_password', env('ADMIN_PASSWORD'));

        if ($user !== $cfgUser || $pass !== $cfgPass) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin"',
            ]);
        }

        return $next($request);
    }
}
