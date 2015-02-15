<?php
class noCache extends CacheInterface {
	public function __construct($settings) {
	}

	public function getCached($key, &$isFound) {
		$isFound = false;
		return false;
	}

	public function setCached($key, $value) {
		return false;
	}

	public function deleteCached($key) {
		return true;
	}

	public function flushCache() {
		return true;
	}
}
?>
