<?php namespace Klsandbox\LoginThrottle;

use Illuminate\Support\ServiceProvider;
use Klsandbox\LoginThrottle\Services\Throttle;

class LoginThrottleServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Throttle main class
		$this->app->singleton('throttle', function () {
			return new Throttle(config('throttle'));
		});
		$this->app->alias('throttle', Throttle::class);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return [
			'throttle',
		];
	}

	public function boot() {
		if (!$this->app->routesAreCached()) {
			require __DIR__ . '/../../../routes/routes.php';
		}

		$this->loadViewsFrom(__DIR__ . '/../../../views/', 'login-throttle');

		$this->publishes([
			__DIR__ . '/../../../views/' => base_path('resources/views/vendor/login-throttle')
		], 'views');

		$this->publishes([
			__DIR__ . '/../../../config/' => config_path()
		], 'config');

		$this->publishes([
			__DIR__ . '/../../../database/migrations/' => database_path('/migrations')
		], 'migrations');
	}
}
