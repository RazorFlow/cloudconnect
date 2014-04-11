<?php

class TwitterFollowersKPI extends KPIComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function initialize () {
		$consumerKey = $this->credentials->getConsumerKey();
		$consumerSecret = $this->credentials->getConsumerSecret();
		$accessToken = $this->credentials->getAccessToken();
		$accessTokenSecret = $this->credentials->getAccessTokenSecret();

		$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		if (!$twitter->authenticate()) {
		    die('Invalid name or password');
		}

		$followers = $twitter->followers($this->username);
		$count = count($followers->ids);
		$this->setValue ($count);
	}
}

?>