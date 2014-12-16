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

	protected $filePath = 'cache/';
	protected $cacheMaxAge = 86400;
	protected $cacheExtension = '.cache';
	protected $cacheFile;
	protected $cacheExists;
	protected $pageName;

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

	private static function cacheFilename () {
		return $this->path . md5($this->pageName) . $this->cacheExtension;
	}

	private static function cacheExists () {
		return file_exists($this->cacheFilename);
	}

	private static function cacheAge () {
		return filemtime($this->cacheFilename);
	}

	private static function cacheValid () {
		if (round(abs(time() - self::cacheAge())) >= $this->cacheMaxAge) {
			unlink($this->cacheFilename);
			return false;
		} else {
			return true;
		}
	}

	private static function cacheWrite ($html) {
		$f = fopen($this->cacheFilename, 'w');
		fwrite($f, $html);
		fclose($f);

		return true;
	}

	public function cacheInit () {
		if (!$this->pageName)
			return false;

		$this->cacheFilename = self::cacheFilename();

		if (self::cacheExists() && self::cacheValid()) {
			require_once $this->cacheFilename;
			exit;
		} else {
			ob_start();
		}
	}

	public function cacheEnd () {
		self::cacheWrite(ob_get_contents());
		return ob_end_flush();
	}

}