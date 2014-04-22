<?php

class TwitterCredentials {

	protected $consumerKey;
	protected $consumerSecret;
	protected $accessToken;
	protected $accessTokenSecret;


	/**
	 * This functions sets the API key of the App you are trying to authenticate.
	 * @param [string] $consumerKey
	 */
	public function setConsumerKey ($consumerKey) {
		$this->consumerKey = $consumerKey;
	}

	public function getConsumerKey () {
		return $this->consumerKey;
	}

	/**
	 * This functions sets the API Secret of the App you are trying to authenticate.
	 * @param [string] $consumerSecret
	 */
	public function setConsumerSecret ($consumerSecret) {
		$this->consumerSecret = $consumerSecret;
	}

	public function getConsumerSecret () {
		return $this->consumerSecret;
	}

	/**
	 * This functions sets the access token received after authorizing the app.
	 * @param [string] $accessToken
	 */
	public function setAccessToken ($accessToken) {
		$this->accessToken = $accessToken;
	}

	public function getAccessToken () {
		return $this->accessToken;
	}

	/**
	 * This functions sets the access token Secret received after authorizing the app.
	 * @param [string] $accessTokenSecret
	 */
	public function setAccessTokenSecret ($accessTokenSecret) {
		$this->accessTokenSecret = $accessTokenSecret;
	}

	public function getAccessTokenSecret () {
		return $this->accessTokenSecret;
	}
}

?>