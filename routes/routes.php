<?php
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['auth.admin']], function () {
        Route::group(['prefix' => 'failed-logins'], function () {

            Route::get('list/all', [
                'as' => 'failed-logins.index',
                'uses' => '\Klsandbox\LoginThrottle\Http\Controllers\LoginAttemptController@index',
            ]);

            Route::delete('purge', [
                'as' => 'failed-logins.purge',
                'uses' => '\Klsandbox\LoginThrottle\Http\Controllers\LoginAttemptController@purge',
            ]);
        });
    });
});
