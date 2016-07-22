<?php
/**
 * Author: gellu
 * Date: 22.07.2016 10:40
 */

// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    /** @var \Slim\Container $c */

    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\Twig($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    /** @var \Slim\Container $c */

    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// database - eloquent
$container['db'] = function ($c) {

	if(!$c['settings']['db_enabled'])
	{
		return null;
	}

	/** @var \Slim\Container $c */

	$capsule = new \Illuminate\Database\Capsule\Manager;
	$capsule->addConnection($c['settings']['db']);

	$capsule->setAsGlobal();
	$capsule->bootEloquent();

	return $capsule;
};

if(!$container['settings']['displayErrorDetails'])
{
	$container['errorHandler']    = function ($c)
	{
		return function ($request, $response, $exception) use ($c)
		{
			$c->logger->error($exception);

			return $c->renderer->render($response, 'base/500.html.twig', []);
		};
	};
	$container['notFoundHandler'] = function ($c)
	{
		return function ($request, $response) use ($c)
		{
			return $c->renderer->render($response, 'base/404.html.twig', []);
		};
	};
}

$container['someService'] = function($c) {
    return new \Service\SomeService($c);
};