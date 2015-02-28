<?php

namespace Test;

use Nette;


abstract class TestCase extends \Tester\TestCase
{

	/**
	 * @var \Nette\DI\Container
	 */
	private $container;


	/**
	 * @return mixed|\Nette\DI\Container
	 */
	protected function getContainer()
	{
		if ($this->container === NULL) {
			$this->container = $this->doCreateContainer();
		}

		return $this->container;
	}


	protected function doCreateContainer()
	{
		$configurator = new Nette\Configurator;
		$configurator->setDebugMode(FALSE);
		$configurator->setTempDirectory(__DIR__ . '/../temp');
		$configurator->createRobotLoader()
			->addDirectory(__DIR__ . '/../app')
			->register();

		$configurator->addParameters([
			'appDir' => __DIR__ .'/../app',
			'wwwDir' => __DIR__ .'/../www',
		]);

		$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
		$configurator->addConfig(__DIR__ . '/../app/config/config.local.neon');
		$configurator->addConfig(__DIR__ . '/tests-reset.neon');

		return $configurator->createContainer();

	}

}
