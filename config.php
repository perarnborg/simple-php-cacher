<?php
class SimplePhpCacherConfig {
	// Cache time to live in seconds
	const TimeToLive = 3600;

	// Could be one of the following: file, memory, no
	const CacheType = 'file';

	// file cache settings
	public static function cacheDir() {
		return __DIR__ . '/cachefiles';
	}

	// memory cache settings
	public static function memcachedServers() {
		return array(
			array('host'=>'127.0.0.1', 'port'=>'11211', 'weight'=>0)
		);
	}

	// get the curently active cache
	public static function getCache() {
		$cacheType = self::CacheType.'Cache';
		return new $cacheType();
	}
}
