<?php

namespace Klsandbox\LoginThrottle\Http\Controllers;

use Klsandbox\LoginThrottle\Models\LoginAttempt;
use DB;
use App\Http\Controllers\Controller;

/**
 * Class LoginAttemptController
 *
 * @package App\Http\Controllers
 */
class LoginAttemptController extends Controller
{
    /**
     * Show the list of all failed login attempts
     */
    public function index()
    {
        $attempts = LoginAttempt::forSite()->get();

        return view('login-throttle::list-attempts', compact('attempts'));
    }

    /**
     * Purge all failed login attempts
     */
    public function purge()
    {
        $attempts = LoginAttempt::forSite()->get();
        foreach ($attempts as $attempt)
        {
            $attempt->delete();
        }

        return redirect()->back()->with('success_message', 'Purge complete');
    }
}