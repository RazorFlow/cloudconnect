<?php

class TwitterMentionsList extends TableComponent {
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

		$mentions = $twitter->mentions();
		foreach ($mentions as &$mention) {
			$name = $mention->user->name;
			$text = $mention->text;
			$message = "<strong>".$name."</strong><br>".$text;
		    $this->addRow (array("mentions" => $message));
		}
	}
}

?>