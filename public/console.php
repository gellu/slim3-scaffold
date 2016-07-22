<?php
if (PHP_SAPI !== 'cli') {
	return;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
require __DIR__ . '/../src/settings.local.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

$container = $app->getContainer();
$container['errorHandler'] = function($container) {
	return function ($request, $response, $exception) use ($container) {
		/** @var \Slim\Container $container */
		/** @var Exception $exception */
		return $container['response']
				->withStatus(500)
				->withHeader('Content-Type', 'text/html')
				->write($exception->getMessage() ."\n");
	};
};
$container['notFoundHandler'] = function($container) {
	return function ($request, $response) use ($container) {
		/** @var \Slim\Container $container */
		return $container['response']
				->withStatus(404)
				->withHeader('Content-Type', 'text/html')
				->write("Command not found\n");
	};
};

// Register middleware
require __DIR__ . '/../src/middleware.php';
$app->add(new CliRequest());

// Register routes
require __DIR__ . '/../src/commands.php';

// Run app
$app->run();
