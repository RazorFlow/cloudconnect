<?php

class PingdomCredentials {
	protected $apiKey;
	public function setAPIKey ($apiKey) {
		$this->apiKey = $apiKey;
	}

	public function getAPIKey () {
		return $this->apiKey;
	}
}

?>