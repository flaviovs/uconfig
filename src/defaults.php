<?php

namespace UConfig;

class DefaultsHandler implements Handler {
	protected $defaults;

	public function __construct(array $defaults) {
		$this->defaults = $defaults;
	}

	public function load() {
		return $this->defaults;
	}
}
