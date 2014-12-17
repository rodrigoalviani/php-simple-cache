<?php

namespace Rodrigoalviani\Cache;

/*
 * PHP Simple Cache v0.1.0
 *
 * By Rodrigo Alviani
 * http://github.com/rodrigoalviani
 *
 * MIT license
 * http://www.opensource.org/licenses/mit-license.php
 */
class Cache {

	public $filePath = 'cache/';
	public $cacheMaxAge = 86400;
	public $cacheExtension = '.cache';
	public $cacheFile;
	public $cacheExists;
	public $pageName;

	public function __construct($src) {
		$this->pageName = $src;
	}

	public function set_filePath ($value) {
		$this->filePath = $value;
	}

	public function set_cacheMaxAge ($value) {
		$this->cacheMaxAge = $value;
	}

	public function set_cacheExtension ($value) {
		$this->cacheExtension = $value;
	}

	public function set_pageName ($value) {
		$this->pageName = $value;
	}

	public function cacheFile () {
		$this->cacheFile = $this->filePath . md5($this->pageName) . $this->cacheExtension;
		return $this->cacheFile;
	}

	public function cacheExists () {
		return file_exists($this->cacheFile);
	}

	public function cacheAge () {
		return filemtime($this->cacheFile);
	}

	public function cacheValid () {
		if (round(abs(time() - $this->cacheAge())) >= $this->cacheMaxAge) {
			unlink($this->cacheFile);
			return false;
		} else {
			return true;
		}
	}

	public function cacheWrite ($html) {
		if (!is_dir($this->filePath) && !@mkdir($this->filePath, 0777, true)) {
			throw new \Exception('Cannot create and grant permission to cache folder!');
			return false;
		}

		$f = fopen($this->cacheFile, 'w');
		fwrite($f, $html);
		fclose($f);

		return true;
	}

	public function cacheInit () {
		if (!$this->pageName)
			return false;

		 $this->cacheFile();

		if ($this->cacheExists() && $this->cacheValid()) {
			require_once $this->cacheFile;
			exit;
		} else {
			ob_start();
		}
	}

	public function cacheEnd () {
		$this->cacheWrite(ob_get_contents());
		return ob_end_flush();
	}

}