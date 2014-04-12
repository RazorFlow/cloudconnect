<?php

class SubscriberCountKPI extends KPIComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	public function initialize () {
		$listId = $this->listId;
		$apiKey = $this->credentials->getAPIKey ();

		$uri = "https://api.createsend.com/api/v3.1/lists/$listId/stats.json";
		$response = Httpful\Request::get($uri)->authenticateWith($apiKey, 'x')->send();
		$totalSubscribers = $response->body->TotalActiveSubscribers;
		$this->setValue ($totalSubscribers);
	}

	protected $listId;
	public function setListID ($listId) {
		$this->listId = $listId;
	}
}

?>