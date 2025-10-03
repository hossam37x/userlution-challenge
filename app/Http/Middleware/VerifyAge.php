<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $product = $request->route('product');
        $user = $request->user();
        if(!$product->isAvailableForAge($user?->age)) {
            return redirect()->route('products.index')
                ->with('error', 'You are not allowed to view this product due to age restrictions.');
        }
        return $next($request);
    }
}
