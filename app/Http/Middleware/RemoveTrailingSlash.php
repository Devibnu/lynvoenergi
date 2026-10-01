<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RemoveTrailingSlash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Only process GET and HEAD requests
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $requestUri = $request->server('REQUEST_URI') ?? $request->getRequestUri();
        $path = explode('?', $requestUri)[0]; // get path without query string

        // 2. Check if path has trailing slash and is not the root '/'
        if ($path !== '/' && Str::endsWith($path, '/')) {
            $nonTrailingPath = rtrim($path, '/');
            
            // 3. Exclude static/file resources (e.g. sitemap.xml, robots.txt, .css, .js)
            if (preg_match('/\.[a-zA-Z0-9]+$/', $nonTrailingPath)) {
                return $next($request);
            }

            // Also exclude paths starting with /storage/ or specific endpoints if needed
            if (Str::startsWith($nonTrailingPath, '/storage/')) {
                return $next($request);
            }

            // 4. Verify if the non-trailing route actually exists
            try {
                $targetRequest = Request::create($nonTrailingPath, $request->method());
                app('router')->getRoutes()->match($targetRequest);
            } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
                // If the target route doesn't exist, don't redirect (let it 404 naturally)
                return $next($request);
            } catch (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e) {
                return $next($request);
            }

            // 5. Generate the non-trailing slash URL
            $url = $request->getSchemeAndHttpHost() . $nonTrailingPath;
            
            // 6. Preserve query string
            if ($request->getQueryString()) {
                $url .= '?' . $request->getQueryString();
            }

            // 7. Perform 301 Permanent Redirect
            return redirect($url, 301);
        }

        return $next($request);
    }
}
