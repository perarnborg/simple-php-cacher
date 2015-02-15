<?php
class memoryCache extends CacheInterface {
	private $_memcached = null, $_timeToLive, $_memcachedServers;

	public function __construct() {
		if($this->_memcached == null) {
			$this->_memcached = new Memcached();
		}
		$this->_timeToLive = isset($settings['timeToLive']) ? $settings['timeToLive'] : SimplePhpCacherConfig::TimeToLiveDefault;
		$this->_memcachedServers = isset($settings['memcachedServers']) ? $settings['memcachedServers'] : SimplePhpCacherConfig::memcachedServersDefault();

		$this->_memcached->setOption(Memcached::OPT_BINARY_PROTOCOL,true);

		$servers = $this->_memcachedServers;

		// Check if servers are added otherwise add them.
		$this->addServersIfNotAdded();
	}

	private function addServersIfNotAdded() {
		$addedHosts = array();
		foreach ($this->_memcached->getServerList() as $server) {
			$addedHosts[$server['host']] = $server;
		}
		$serversToAdd = array();
		foreach ($this->_memcachedServers as $server) {
			array_push($serversToAdd, $server);
		}
		if(count($serversToAdd) > 0) {
			$this->_memcached->addServers($serversToAdd);
		}
	}

	public function getCached($key, &$isFound) {
		$isFound = false;
		$value = $this->_memcached->get($key);
		if(!$value) {
			return false;
		}
		$isFound = true;
		return json_decode($value);
	}

	public function setCached($key, $value) {
		if(!$this->_memcached->add($key, json_encode($value), $this->_timeToLive)) {
			return false;
		}
		return true;
	}

	public function deleteCached($key) {
		if(!$this->_memcached->delete($key)) {
			return false;
		}
		return true;
	}

	public function flushCache() {
		$this->_memcached->flush();
	}
}
?>
