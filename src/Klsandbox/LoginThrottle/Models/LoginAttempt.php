<?php

namespace Klsandbox\LoginThrottle\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
/**
 * Class LoginAttempt
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $client_ip
 * @property string $ic_number
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt withinIp($ip, $name)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt withinTimeFrame($ip, $name, $timeframe = 14400)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt whereClientIp($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\LoginThrottle\Models\LoginAttempt whereIcNumber($value)
 * @mixin \Eloquent
 */
class LoginAttempt extends Model
{
    /**
     * LoginAttempt constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // Setup model
        $this->setup();

        // Call parent constructor
        parent::__construct($attributes);
    }

    /**
     * Setup model
     */
    protected function setup()
    {
        // Set table
        $this->setTable('login_attempts');

        // Set fillable fields
        $this->fillable(['client_ip', 'ic_number']);
    }

    /**
     * @param Builder $query
     * @param string $ip
     * @param string $name
     *
     * @return mixed
     */
    public function scopeWithinIp($query, $ip, $name)
    {
        return $query
            ->where('client_ip', '=', $ip)
            ->where('ic_number', '=', $name);
    }

    /**
     * @param Builder $query
     * @param string $ip
     * @param string $name
     * @param int $timeframe
     *
     * @return mixed
     */
    public function scopeWithinTimeFrame($query, $ip, $name, $timeframe = 14400)
    {
        return $query
            ->where('client_ip', '=', $ip)
            ->where('ic_number', '=', $name)
            ->where('created_at', '<=', Carbon::now())
            ->where('created_at', '>=', Carbon::now()->subSeconds($timeframe));
    }
}
