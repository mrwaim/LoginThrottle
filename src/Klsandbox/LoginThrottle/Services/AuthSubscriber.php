<?php

namespace Klsandbox\LoginThrottle\Services;

use Illuminate\Auth\Events\Login;
use Illuminate\Events\Dispatcher;

/**
 * Class AuthSubscriber
 */
class AuthSubscriber
{
    /**
     * @var Throttle
     */
    protected $throttle;

    /**
     * AuthSubscriber constructor.
     *
     * @param Throttle $throttle
     */
    public function __construct(Throttle $throttle)
    {
        $this->throttle = $throttle;
    }

    /**
     * @param $event
     */
    public function onLoginSuccess($event)
    {
        $this->throttle->reset(
            app('request')->getClientIp(),
            $event->user->ic_number
        );
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        $dispatcher->listen(Login::class, '\Klsandbox\LoginThrottle\Services\AuthSubscriber@onLoginSuccess');
    }
}
