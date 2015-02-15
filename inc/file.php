<?php
class fileCache extends CacheInterface {
	private $_timeToLive, $_cacheDir;

	public function __construct($settings) {
		$this->_timeToLive = isset($settings['timeToLive']) ? $settings['timeToLive'] : SimplePhpCacherConfig::TimeToLiveDefault;
		$this->_cacheDir = isset($settings['cacheDir']) ? $settings['cacheDir'] : SimplePhpCacherConfig::cacheDirDefault();
		if(!is_dir($this->_cacheDir)) {
			if(!mkdir($this->_cacheDir)) {
				throw new Exception("Simple PHP CACHER error: file implementation is not working. Check file privelages");
			}
		}
	}

	public function getCached($key, &$isFound) {
		$isFound = false;
		$value = false;
		$cachefile = $this->_cacheDir.'/_' . $key;
		// Read cachefile content if it exists
		if(file_exists($cachefile) && filemtime($cachefile) + $this->_timeToLive > time()) {
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
		$cachefile = $this->_cacheDir.'/_' . $key;
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
		$cachefile = $this->_cacheDir.'/_' . $key;

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
