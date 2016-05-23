<?php

namespace Klsandbox\LoginThrottle\Services;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

/**
 * Class Middleware
 */
class Middleware
{
    /**
     * @var Throttle
     */
    protected $throttle;

    /**
     * Middleware constructor.
     *
     * @param Throttle $throttle
     */
    public function __construct(Throttle $throttle)
    {
        $this->throttle = $throttle;
    }

    /**
     * @param Request $request
     * @param \Closure $next
     *
     * @return \Closure
     */
    public function handle(Request $request, \Closure $next)
    {
        if (!$this->throttle->create($request)) {
            throw new TooManyRequestsHttpException(86400,
                'Failed Login attempts limit from this IP exceeded'
            );
        }

        return $next($request);
    }
}
