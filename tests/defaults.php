<?php

use UConfig\DefaultsHandler;

class DefaultsHandlerTestCase extends PHPUnit_Framework_TestCase {

	static protected $tmpdir;

	public function testLoad() {

		$defaults = [
			'section1' => [
				'foo' => 'bar',
			],
			'section2' => [
				'moo' => 'zee',
			],
		];

		$handler = new DefaultsHandler($defaults);

		$this->assertEquals($defaults, $handler->load());


	}
}
