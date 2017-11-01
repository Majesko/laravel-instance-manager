<?php

class InstanceManagerServiceProvider extends \Illuminate\Support\ServiceProvider {

	public function boot() {
		$app = $this->app;
		$app['config']->package('majesko/laravel-instance-manager', __DIR__ . '/config', 'instance-manager');
	}

	public function register() {
		$this->app->bind('instance-manager', function($app) {
			return new LaravelInstanceManager();
		});
	}
}