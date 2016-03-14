<?php

use UConfig\Config;

class ConfigTestCase extends PHPUnit_Framework_TestCase {

	public function testConstructorDefaults() {

		$defaults = [
			'section' => [
				'foo' => 'bar',
			],
		];

		$cfg = new Config($defaults);

		$this->assertEquals($defaults, $cfg->getItems());
	}
}
