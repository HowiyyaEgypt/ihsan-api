<?php

namespace App\Http\Middleware;

use Closure;

class ApiLangSuffix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = strtolower($request->get('lang', ''));

        if($lang != 'ar' && $lang != 'en' ){
            $lang = 'ar';
        }

        $api_suffix_lang = '_' . $lang;
        
        \App::singleton('api_suffix_lang', function() use($api_suffix_lang){
            return $api_suffix_lang;
        });

        return $next($request);
    }
}
