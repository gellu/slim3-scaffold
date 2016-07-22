<?php
/**
 * Author: gellu
 * Date: 22.07.2016 10:40
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CliRequest
{

	/**
	 * @var ServerRequestInterface
	 */
	protected $request = null;

	/**
	 * Exposed for testing.
	 * @return ServerRequestInterface
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Invoke middleware
	 *
	 * @param  ServerRequestInterface   $request  PSR7 request object
	 * @param  ResponseInterface        $response PSR7 response object
	 * @param  callable                 $next     Next middleware callable
	 *
	 * @return ResponseInterface PSR7 response object
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		global $argv;

		$this->request = $request;

		if (isset($argv)) {

			list($call, $path, $params) = $argv;

			$this->request = \Slim\Http\Request::createFromEnvironment(\Slim\Http\Environment::mock([
					'REQUEST_METHOD'    => 'GET',
					'REQUEST_URI'       => '/' . $path . '?' . $params,
					'QUERY_STRING'      => $params
			]));

			unset($argv);

		}

		return $next($this->request, $response);
	}
}