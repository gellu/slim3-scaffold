<?php
/**
 * Author: gellu
 * Date: 22.07.2016 10:40
 */

namespace Command;

class SomeCommand extends Command
{

	public function __invoke($request, $response, $args)
	{
		echo "bang\n";
	}

}