<?php

namespace App\Http\Middleware;

use App\Article;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class OperatorMiddleware
{
    protected $auth;

    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->getUser()->user_type !== 4) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
}
