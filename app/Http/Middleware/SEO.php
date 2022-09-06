<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SEO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Str::endsWith($request->getRequestUri(),'?')){
            $url = Str::replaceLast('?','',$request->requestUri);
            // dd($request);
            return redirect($request->url());
        }
        return $next($request);
    }
}
