<?php

namespace Klsandbox\LoginThrottle\Services;

use Klsandbox\LoginThrottle\Models\LoginAttempt;
use Illuminate\Http\Request;

/**
 * Class Throttle
 *
 * @package App\Services\Throttle
 */
class Throttle
{
    /**
     * Default limits
     */
    const DEF_LIMIT_TIME = 14400;
    const DEF_LIMIT_ATMP = 10;

    /**
     * @type array
     */
    protected $options = [];

    /**
     * Throttle constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Check request
     *
     * @param array|Request $request
     * @return bool
     */
    public function create(Request $request)
    {
        $withinLimits = true;
        foreach ($this->prepareLimits() as $limit) {
            $attempts = LoginAttempt::withinTimeFrame(
                $request->getClientIp(),
                $request->input('ic_number'),
                $limit['time']
            );

            if ($attempts->count() >= $limit['attempts']) {
                $withinLimits = false;
                continue;
            }
        }

        if ($withinLimits) {
            $this->hit([
                'client_ip' => $request->getClientIp(),
                'ic_number' => $request->input('ic_number'),
            ]);

            return true;
        }

        return false;
    }

    /**
     * Register hit
     * @param array $data
     * @return $this
     */
    public function hit(array $data)
    {
        LoginAttempt::create($data);

        return $this;
    }

    /**
     * Reset atempts cache
     * @param string $ip
     * @param string $name
     */
    public function reset($ip, $name)
    {
        LoginAttempt::withinIp($ip, $name)->delete();
    }

    /**
     * @return array
     */
    protected function prepareLimits()
    {
        if (array_key_exists('limits', $this->options)) {
            $limits = $this->options['limits'];
            usort($limits, function ($a, $b) {
                return $a['time'] - $b['time'];
            });
        } else {
            $limits[] = [
                'time' => self::DEF_LIMIT_TIME,
                'attempts' => self::DEF_LIMIT_ATMP,
            ];
        }

        return $limits;
    }
}