<?php

namespace UConfig;

class INIFileHandler implements Handler {
	protected $paths = [];

	public function __construct($path = NULL) {
		if ($path)
			$this->addPath($path);
	}

	public function addPath($path) {
		$this->paths[] = $path;
	}

	public function load() {
		$conf = [];
		foreach ($this->paths as $path) {
			$conf = array_replace_recursive($conf,
			                                parse_ini_file($path, TRUE));
		}
		$global = [];
		foreach ($conf as $section => $values) {
			if (!is_array($values)) {
				$global[$section] = $values;
				unset($conf[$section]);
			}
		}
		if ($global)
			$conf[NULL] = $global;
		return $conf;
	}
}
