<?php

class daysToRelease extends KPIComponent {
  protected $credentials;
  protected $JiraURL;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  protected $versionID;
  public function setVersion ($versionID) {
    $this->versionID = $versionID;
  }

  public function setURL ($url) {
    $this->JiraURL = rtrim($url, "/");
  }

  protected $timezone;
  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  }

  public function initialize () {
    $versionID = $this->versionID;

    $userName = $this->credentials->getAdminUserName();
    $password = $this->credentials->getAdminPassword();

    $uri = $this->JiraURL . "/rest/api/2/version/$versionID";
    $response = Httpful\Request::get($uri)
                             ->authenticateWith($userName, $password)
                             ->send();

    date_default_timezone_set($this->timezone);
    $currentDate = new DateTime(date("Y-m-d"));
    $releaseDate = new DateTime($response->body->releaseDate);
    $daysToRelease = (int) $currentDate->diff($releaseDate, $absolute=false)->format("%R%a");
    $this->setValue($daysToRelease);
  }

}