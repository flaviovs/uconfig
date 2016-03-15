<?php

namespace UConfig;

class Exception extends \Exception {}
class SectionNotFoundException extends Exception {}
class OptionNotFoundException extends Exception {}


interface Handler {
	public function load();
}


class Config {
	protected $conf;
	protected $handlers = [];

	public function __construct(array $defaults = []) {
		if ($defaults) {
			$this->addHandler(new DefaultsHandler($defaults));
		}
	}

	public function addHandler(Handler $handler) {
		$this->handlers[] = $handler;
	}

	public function reload() {
		$this->conf = [];
		foreach ($this->handlers as $handler) {
			$this->conf = array_replace_recursive($this->conf,
												  $handler->load());
		}
	}

	public function getItems() {
		if ($this->conf === NULL)
			$this->reload();
		return $this->conf;
	}

	public function get($section, $key) {
		if ($this->conf === NULL)
			$this->reload();

		if (!array_key_exists($section, $this->conf)) {
			throw new SectionNotFoundException($section);
		}

		if ( !array_key_exists($key, $this->conf[$section])) {
			throw new OptionNotFoundException($key);
		}

		return $this->conf[$section][$key];
	}
}
