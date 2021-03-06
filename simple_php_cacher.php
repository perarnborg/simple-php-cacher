<?php
/*
Project: https://github.com/perarnborg/simple-php-cacher
Creator: Per Arnborg
*/
require_once 'config.php';
require_once 'inc/_interface.php';
require_once 'inc/no.php';
require_once 'inc/file.php';
require_once 'inc/memory.php';

class SimplePhpCacher {
	private $_cache;

	public function __construct($implementation = SimplePhpCacherConfig::CacheImplementationDefault, $settings = array()) {
		if(!$settings) {
			$settings = SimplePhpCacherConfig::cacheSettingsDefault();
		}
	    $this->_cache = $this->getCache($implementation, $settings);
	}

	public function get($keys, &$isFound = false) {
		$isFound = false;
		$key = $this->getCacheKey($keys);
		return $this->_cache->getCached($key, $isFound);
	}

	public function set($keys, $value) {
		$key = $this->getCacheKey($keys);
		return $this->_cache->setCached($key, $value);
	}

	public function delete($keys) {
		$key = $this->getCacheKey($keys);
		return $this->_cache->deleteCached($key);
	}

	public function flush() {
		return $this->_cache->flushCache();
	}

	public function getCacheKey($keys = '') {
		$key = (is_array($keys) ? implode('_', $keys) : $keys);
		return md5($key);
	}

	private function getCache($implementation, $settings) {
		return SimplePhpCacherConfig::getCache($implementation, $settings);
	}
}
