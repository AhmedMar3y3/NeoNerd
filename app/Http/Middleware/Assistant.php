<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Assistant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
       public function handle(Request $request, Closure $next): Response
    {
        $assistant = Auth::guard('assistant')->user();

        if (!$assistant) {
            return redirect()->route('loginPage')->with('error', 'غير مصرح: يمكن فقط للمساعدين الوصول إلى هذا المسار');
        }

        return $next($request);
    }
}
