<?php
/**
 * Author: gellu
 * Date: 22.07.2016 10:40
 */

namespace Command;

use Slim\Container;

abstract class Command
{
	/** @var  Container */
	protected $container;

	/** @var \Illuminate\Database\Capsule\Manager */
	protected $db;

	public function __construct(Container $container)
	{
		$this->container 	= $container;
		$this->db			= $container->get('db');
	}

}