<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = null; // or '*' if behind a load balancer/CDN

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    // Use this if you just need basic detection:
    protected $headers = Request::HEADER_X_FORWARDED_FOR | 
                         Request::HEADER_X_FORWARDED_HOST | 
                         Request::HEADER_X_FORWARDED_PORT | 
                         Request::HEADER_X_FORWARDED_PROTO;

    // Or if on AWS ELB/ALB:
    // protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;
}
