<?php

class TwitterCredentials {

	protected $consumerKey;
	protected $consumerSecret;
	protected $accessToken;
	protected $accessTokenSecret;

	public function setConsumerKey ($consumerKey) {
		$this->consumerKey = $consumerKey;
	}

	public function getConsumerKey () {
		return $this->consumerKey;
	}

	public function setConsumerSecret ($consumerSecret) {
		$this->consumerSecret = $consumerSecret;
	}

	public function getConsumerSecret () {
		return $this->consumerSecret;
	}

	public function setAccessToken ($accessToken) {
		$this->accessToken = $accessToken;
	}

	public function getAccessToken () {
		return $this->accessToken;
	}

	public function setAccessTokenSecret ($accessTokenSecret) {
		$this->accessTokenSecret = $accessTokenSecret;
	}

	public function getAccessTokenSecret () {
		return $this->accessTokenSecret;
	}
}

?>