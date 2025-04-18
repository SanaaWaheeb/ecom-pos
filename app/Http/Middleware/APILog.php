<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class APILog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($request->theme_id) && empty($request->theme_id)) {
            $return["status"] = 0;
            $return["message"] = "fail";
            $return["data"]["message"] = "Theme id not found.";
            return response()->json($return);
        }
        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::channel('API_log')->info(' *********************************** API START *********************************** ');
        Log::channel('API_log')->info('API URL');
        Log::channel('API_log')->info($request->url());
        Log::channel('API_log')->info('request');
        Log::channel('API_log')->info($request);
        Log::channel('API_log')->info(PHP_EOL);
        Log::channel('API_log')->info('response');
        Log::channel('API_log')->info($response);
        Log::channel('API_log')->info(' *********************************** API END *********************************** ');
    }
}
