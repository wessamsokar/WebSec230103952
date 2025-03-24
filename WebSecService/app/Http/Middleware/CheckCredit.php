<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCredit
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->credit < $request->amount) {
            return redirect()->route('insufficient.credit');
        }

        return $next($request);
    }
}
