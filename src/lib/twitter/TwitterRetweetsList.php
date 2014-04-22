<?php

class TwitterRetweetsList extends TableComponent {
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

		$retweets = $twitter->retweeted();

		foreach ($retweets as &$retweet) {
			$userobj = $twitter->retweeted_by(strval($retweet->id));
			if(!empty($userobj)){
				$name = $userobj[0]->user->name;
				$profile_image = $userobj[0]->user->profile_image_url_https;
			} else {
				$name = 'Unavailable';
				$profile_image = 'https://pbs.twimg.com/profile_images/2284174872/7df3h38zabcvjylnyfe3_normal.png';
			}
			$text = $retweet->text;
			$time = $TwitterHelper->time_passed(strtotime($retweet->created_at));
			$message = $TwitterHelper->create_list_text($profile_image, $name, $time, $text);
		    $this->addRow (array("retweets" => $message));
		}
	}
}

?>