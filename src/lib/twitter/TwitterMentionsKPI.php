<?php
require_once("TwitterHelper.php");

class TwitterMentionsKPI extends KPIComponent {
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

		$mentions = $twitter->mentions();
		$count = count($mentions);
		$this->setValue ($count);
	}
}

?>