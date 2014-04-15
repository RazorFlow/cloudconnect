<?php

class TwitterRetweetsList extends TableComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
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

		$retweets = $twitter->retweeted();
		foreach ($retweets as &$retweet) {
			$text = $retweet->text;
			$retweetCount = $retweet->retweet_count;
			$message = "<strong>".$text."</strong><br> Reweet Count: ".$retweetCount;
		    $this->addRow (array("retweets" => $message));
		}
	}
}

?>