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

	public function testGet() {
		$cfg = new Config([
			                  'section' => [
				                  'a' => 'b',
			                  ],
		                  ]);
		$this->assertEquals($cfg->get('section', 'a'), 'b');
	}

	public function testNonexistentSectionThrowsException() {
		$cfg = new Config();
		$this->setExpectedException('UConfig\SectionNotFoundException');
		$cfg->get('foo', 'bar');
	}

	public function testNonexistentOptionThrowsException() {
		$cfg = new Config(['section' => []]);
		$this->setExpectedException('UConfig\OptionNotFoundException');
		$cfg->get('section', 'bar');
	}
}
