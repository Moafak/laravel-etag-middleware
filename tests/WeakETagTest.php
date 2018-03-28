<?php

namespace Tests;

use Illuminate\Http\Request;
use moafak\WeakETagMiddleware\WeakETag;
use Mockery as m;

/**
 * Weak ETag test.
 */
class WeakEtagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test new request not cached.
     *
     * @return void
     */
    public function testModified()
    {
        // Create mock response
        $response = m::mock('Illuminate\Http\Response')->shouldReceive('getContent')->once()->andReturn('blah')->getMock();
        $response->shouldReceive('setEtag')->with(sha1('blah'), true);

        // Create request
        $request = Request::create('http://example.com/admin', 'GET');

        // Pass it to the middleware
        $middleware = new WeakETag();
        $middlewareResponse = $middleware->handle($request, function () use ($response) {
            return $response;
        });
    }

    /**
     * Test repeated request not modified.
     *
     * @return void
     */
    public function testNotModified()
    {
        // Create mock response
        $response = m::mock('Illuminate\Http\Response')->shouldReceive('getContent')->once()->andReturn('blah')->getMock();
        $response->shouldReceive('setEtag')->with(sha1('blah'), true);
        $response->shouldReceive('setNotModified');

        // Create request
        $request = m::mock('Illuminate\Http\Request');
        $request->shouldReceive('isMethod')->with('get')->andReturn(true);
        $request->shouldReceive('getETags')->andReturn([
            sha1('blah'),
        ]);

        // Pass it to the middleware
        $middleware = new WeakETag();
        $middlewareResponse = $middleware->handle($request, function () use ($response) {
            return $response;
        });
    }

    /**
     * Tear down the test.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }
}
