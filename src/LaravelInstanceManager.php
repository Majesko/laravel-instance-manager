<?php


use Illuminate\Support\Facades\Config;
use InstanceManager\AdapterInterface;
use InstanceManager\AWS\AwsAdapter;
use InstanceManager\InstanceManager;

class LaravelInstanceManager implements AdapterInterface {
	private $config;
	private $defaultProvider;
	private $adapters;

	public function __construct() {
		$this->adapters = [
			'aws' => AwsAdapter::class
		];
		$this->config = app('config')->get('instance-manager::config');
		$this->defaultProvider = $this->config[$this->config['default']];
	}

	public function boot($provider) {

		if (array_key_exists($provider, $this->config) && array_key_exists($provider, $this->adapters)) {

			$adapter = new $this->adapters[$provider]($this->config[$provider]);

			return new InstanceManager($adapter);
		}

		throw new AdapterNotFoundException();
	}

	public function createInstances($count) {
		$adapter = new $this->adapters[$this->config['default']]($this->config[$this->defaultProvider]);

		return (new InstanceManager($adapter))->createInstances($count);
	}

	public function describeInstances($names) {
		$adapter = new $this->adapters[$this->config['default']]($this->config[$this->defaultProvider]);

		return (new InstanceManager($adapter))->describeInstances($names);
	}

	public function terminateInstances($names) {
		$adapter = new $this->adapters[$this->config['default']]($this->config[$this->defaultProvider]);

		return (new InstanceManager($adapter))->terminateInstances($names);
	}
}