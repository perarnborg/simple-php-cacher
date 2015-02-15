<?php
class SimplePhpCacherConfig {
	private static function cacheImplementations() {
		return array(
			'no',
			'file',
			'memory',
		);
	}
	const CacheImplementationDefault = 'no';

	public static function cacheSettingsDefault() {
		return array(
			'timeToLive' => self::TimeToLiveDefault,
			'cacheDir' => self::cacheDirDefault(),
			'memcachedServer' => self::memcachedServersDefault()
		);
	}

	// Cache time to live in seconds
	const TimeToLiveDefault = 3600;

	// file cache settings
	public static function cacheDirDefault() {
		return __DIR__ . '/cachefiles';
	}

	// memory cache settings
	public static function memcachedServersDefault() {
		return array(
			array('host'=>'127.0.0.1', 'port'=>'11211', 'weight'=>0)
		);
	}

	// get the curently active cache
	public static function getCache($implementation, $settings) {
		if(!in_array($implementation, self::cacheImplementations())) {
			$implementation = self::CacheImplementationDefault;
		}
		$cacheType = $implementation.'Cache';
		return new $cacheType($settings);
	}
}
