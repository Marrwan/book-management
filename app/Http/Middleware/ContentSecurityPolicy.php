<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        $response = $next($request);

        $response->headers->set('Content-Security-Policy', "script-src 'self' 'nonce-{$nonce}' 'wasm-unsafe-eval' 'inline-speculation-rules';");

        view()->share('nonce', $nonce);

        return $response;
    }
}
