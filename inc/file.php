<?php
class fileCache extends CacheInterface {
	public function __construct() {
		if(!is_dir(SimplePhpCacherConfig::cacheDir())) {
			if(!mkdir(SimplePhpCacherConfig::cacheDir())) {
				throw new Exception("Simple PHP CACHER error: file implementation is not working. Check file privelages");
			}
		}
	}

	public function getCached($key, &$isFound) {
		$isFound = false;
		$value = false;
		$cachefile = SimplePhpCacherConfig::cacheDir().'/_' . $key;
		// Read cachefile content if it exists
		if(file_exists($cachefile) && filemtime($cachefile) + SimplePhpCacherConfig::TimeToLive > time()) {
			$fh = fopen($cachefile, 'r');
			if(!$fh) {
				throw new Exception('Simple PHP CACHER error: file implementation is not working. Check file privelages');
			}
			$value = json_decode(fread($fh, filesize($cachefile)));
			$isFound = true;
			fclose($fh);
		}
		return $value;
	}

	public function setCached($key, $value) {
		$cachefile = SimplePhpCacherConfig::cacheDir().'/_' . $key;
		$fh = fopen($cachefile, 'w');
		if(!$fh) {
			throw new Exception('Simple PHP CACHER error: file implementation is not working. Check file privelages');
		}
		fwrite($fh, json_encode($value));
		fclose($fh);
		chmod($cachefile, 0777);
	}

	public function deleteCached($key) {
		$value = false;
		$cachefile = SimplePhpCacherConfig::cacheDir().'/_' . $key;

		if(file_exists($cachefile)) {
			$value = unlink($cachefile);
			if(!$value) {
				throw new Exception('Simple PHP CACHER error: file implementation is not working. Check file privelages');
				return false;
			}
		}
		return true;
	}

	public function flushCache() {
		$files = glob(SimplePhpCacherConfig::cacheDir.'/_*', GLOB_BRACE);
		foreach($files as $file) {
			if(is_file($file)) {
				unlink($file);
			}
		}
		return true;
	}
}
