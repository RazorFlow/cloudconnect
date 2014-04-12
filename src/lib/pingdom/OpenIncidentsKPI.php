<?php

class OpenIncidentsKPI extends KPIComponent {
	protected $credentials;
	public function setCredentialsObject ($credentials) {
		$this->credentials = $credentials;
	}

	public function initialize () {
		$listId = $this->listId;
		$apiKey = $this->credentials->getAPIKey ();

		$uri = "https://api.pingdom.com/api/2.0/checks";
		$response = Httpful\Request::get($uri)->authenticateWith('selwynjacob90@gmail.com', 'sXkFIJtG')
											  ->addHeader('App-Key', '85i4kkl8nnn3w1r7uspukc2em0b2sfe0')
											  ->send();

		$this->setValue ('1');
	}
}

?>