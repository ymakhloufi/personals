<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveEmptyFieldsFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        foreach ($input as $key => $value) {
            if ($value === "") {
                unset($input[$key]);
            }
        }
        $request->replace($input);

        return $next($request);
    }
}
