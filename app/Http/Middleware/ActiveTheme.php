<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Qirolab\Theme\Theme;
use App\Models\{Store, Utility};
use Illuminate\Support\Facades\Cache;

class ActiveTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $store = Cache::remember('store_' . request()->segment(1), 3600, function () {
            return Store::where('slug', request()->segment(1))->where('is_active', 1)->first();
        });

        //if (empty($store)){
           // return abort('403', 'The store is not active.');
       // }
        if($store && $store->theme_id) {
            $themeName = $store->theme_id;
        } else {
            $themeName = $this->getThemeNameFromUrl($request);
        }
        if (!empty($themeName)) {
            Theme::set($themeName);
        }        
        return $next($request);
    }

    private function getThemeNameFromUrl($request)
    {
        // Get the segments of the URL
        $segments = $request->segments();

        // Find the index of 'themes' in the URL
        $themesIndex = array_search('themes', $segments);

        // Check if 'themes' exists in the URL and get the theme name
        return $themesIndex !== false && isset($segments[$themesIndex + 1])
            ? $segments[$themesIndex + 1]
            : null;
            
    }
}
