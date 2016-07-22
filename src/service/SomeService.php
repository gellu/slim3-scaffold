<?php
/**
 * Author: gellu
 * Date: 22.07.2016 10:47
 */

namespace Service;

use Slim\Container;

class SomeService
{
	/** @var \Illuminate\Database\Capsule\Manager */
	private $db;

	/** @var Container */
	private $container;

	public function __construct($container)
	{
		$this->container 	= $container;
		$this->db 			= $this->container->get('db');
	}

	public function someMethod()
	{
		return true;
	}
}

