<?php

class TwitterMentionsList extends TableComponent {
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
		foreach ($mentions as &$mention) {
			$name = $mention->user->name;
			$text = $mention->text;
			$profile_image = $mention->user->profile_image_url_https;

			$time = $TwitterHelper->time_passed(strtotime($mention->created_at));
			$message = $TwitterHelper->create_list_text($profile_image, $name, $time, $text);
		    $this->addRow (array("mentions" => $message));
		}
	}
}

?>