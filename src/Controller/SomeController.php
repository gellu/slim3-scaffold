<?php
/**
 * Author: gellu
 * Date: 22.07.2016 11:34
 */

namespace Controller;

use Slim\Container;

class SomeController extends Controller
{
	public function who($request, $response, $args)
	{
		/** @var \Slim\Http\Request $request */
		/** @var \Service\SomeService $someService */
		$someService = $this->container->someService;

		if(!$someService->someMethod())
		{
			throw new \Exception('Sorry no talentmatrix for you :(');
		}

		$params = ['who' => $args['who']];
		return $this->container->renderer->render($response, 'some/index.html.twig', $params);
	}
}

