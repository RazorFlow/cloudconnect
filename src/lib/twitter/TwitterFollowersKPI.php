<?php
require_once("TwitterHelper.php");

class TwitterFollowersKPI extends KPIComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	/**
	 * This function sets the username for whom the results will be retreived will be retrieved.
	 * @param [string] $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	public function initialize () {
		$TwitterHelper = new TwitterHelper();
		$twitter = $TwitterHelper->authenticate($this->credentials);
		if (!$twitter->authenticate()) {
		    die('Invalid name or password');
		}

		$followers = $twitter->followers($this->username);
		$count = count($followers->ids);
		$this->setValue ($count);
	}
}

?>