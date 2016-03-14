<?php

class INIFileHandlerTestCase extends PHPUnit_Framework_TestCase {

	static protected $tmpdir;

	public static function setUpBeforeClass() {
		static::$tmpdir = \PhpunitTempDir\Helper::createTempDir();
	}

	public function testLoadFileFromConstructor() {

		$ini = static::$tmpdir . DIRECTORY_SEPARATOR . 'config.ini';

		file_put_contents($ini, '
[section]
foo = bar
');

		$handler = new \UConfig\INIFileHandler($ini);

		$this->assertEquals([
			                    'section' => [
				                    'foo' => 'bar',
			                    ],
		                    ], $handler->load());

	}

	public function testLoadFileFromAddedFile() {

		$ini = static::$tmpdir . DIRECTORY_SEPARATOR . 'config.ini';

		file_put_contents($ini, '
[section]
foo = bar
');

		$handler = new \UConfig\INIFileHandler();
		$handler->addPath($ini);

		$this->assertEquals([
			                    'section' => [
				                    'foo' => 'bar',
			                    ],
		                    ], $handler->load());

	}

	public function testLoadFoldGlobal() {

		$ini = static::$tmpdir . DIRECTORY_SEPARATOR . 'config.ini';

		file_put_contents($ini, '
a = b
c = d

[section]
foo = bar
');

		$handler = new \UConfig\INIFileHandler();
		$handler->addPath($ini);

		$this->assertEquals([
			                    NULL => [
				                    'a' => 'b',
				                    'c' => 'd',
			                    ],
			                    'section' => [
				                    'foo' => 'bar',
			                    ],
		                    ], $handler->load());

	}

	public function testMultipleFilesOverrideOrderIsCorrect() {

		$ini1 = static::$tmpdir . DIRECTORY_SEPARATOR . 'config1.ini';
		$ini2 = static::$tmpdir . DIRECTORY_SEPARATOR . 'config2.ini';

		file_put_contents($ini1, '
[section1]
foo = bar

[sectionx]
lee = zoo
unc = hanged
');

		file_put_contents($ini2, '
[sectionx]
new = option
lee = overriden
');

		$handler = new \UConfig\INIFileHandler();
		$handler->addPath($ini1);
		$handler->addPath($ini2);

		$this->assertEquals([
			                    'section1' => [
				                    'foo' => 'bar',
			                    ],
			                    'sectionx' => [
				                    'lee' => 'overriden',
				                    'unc' => 'hanged',
				                    'new' => 'option',
			                    ],
		                    ], $handler->load());

	}
}
