<?php
require_once("TwitterHelper.php");

class TwitterKeywordList extends TableComponent {
	protected $credentials;
	protected $query;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	public function query($query){
		$this->query = $query;
	}

	public function getQuery(){
		return $this->query;
	}

	public function initialize () {
		$TwitterHelper = new TwitterHelper();
		$twitter = $TwitterHelper->authenticate($this->credentials);
	
		if (!$twitter->authenticate()) {
		    die('Invalid name or password');
		}
		$query = $this->getQuery();
		$keyword_search = $twitter->keyword_search($query);

		foreach ($keyword_search->statuses as &$status) {
			$name = $status->user->name;
			$text = $status->text;
			$profile_image = $status->user->profile_image_url_https;
			$time = $TwitterHelper->time_passed(strtotime($status->created_at));
			$message = $TwitterHelper->create_list_text($profile_image, $name, $time, $text);
		    $this->addRow (array("searchList" => $message));
		}
	}
}

?>