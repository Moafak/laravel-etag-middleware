<?php

namespace moafak\WeakETagMiddleware;

use Illuminate\Http\Request;
use Closure;

/**
 * Weak ETag middleware.
 */
class WeakETag
{
    /**
     * Implement weak ETag support.
     * inspired by https://github.com/matthewbdaly/laravel-etag-middleware
     *
     * @param \Illuminate\Http\Request $request The HTTP request.
     * @param \Closure                 $next    Closure for the response.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get response
        $response = $next($request);

        // If this was a GET request...
        if ($request->isMethod('get')) {
            // Generate ETag
            $etag = sha1($response->getContent());
            $requestEtag = str_replace('W/"', '', $request->getETags());    //beginning of string
            $requestEtag = str_replace('"', '', $requestEtag);              //end of string

            // Check to see if ETag has changed
            if ($requestEtag && $requestEtag[0] == $etag) {
                $response->setNotModified();
            }

            // Set weak ETag
            $response->setEtag($etag, true);
        }

        // Send response
        return $response;
    }
}
