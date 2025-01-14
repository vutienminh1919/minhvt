<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SiteRedirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Redirect_301
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
        $uri = $request->getRequestUri();

        /*redirect db*/
        $all = SiteRedirect::all()->toArray();
        $arrOriginalUrl = array_column($all, 'original_url');
        $arrRedirectlUrl = array_column($all, 'redirect_url');
        $data = array_combine($arrOriginalUrl, $arrRedirectlUrl);
        if (isset($data[$uri])) {
            $url_redirect = url($data[$uri]);
            if (substr($data[$uri], -1) == '/') $url_redirect .= '/';
            return Redirect::to($url_redirect, 301);
        }

        if (preg_match('/\/\/+/', $uri)) {
            $uri_redirect = preg_replace('/\/\/+/', '/', $uri);
            return Redirect::to(url($uri_redirect), 301);
        }

        return $next($request);
    }
}
