<?php

class TwitterRetweetedKPI extends KPIComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	public function initialize () {
		$TwitterHelper = new TwitterHelper();
		$twitter = $TwitterHelper->authenticate($this->credentials);
		
		if (!$twitter->authenticate()) {
		    die('Invalid name or password');
		}

		$retweeted = $twitter->retweeted();
		$count = count($retweeted);
		$this->setValue ($count);
	}
}

?>