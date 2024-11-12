<?php

namespace Botble\JobBoard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JobBoardHelper;

class EnabledCreditsSystem
{
    public function handle(Request $request, Closure $next)
    {
        if (! JobBoardHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        return $next($request);
    }
}
