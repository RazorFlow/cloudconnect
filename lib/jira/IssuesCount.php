<?php

class IssuesCount extends KPIComponent {
  protected $credentials;
  protected $JiraURL;
  protected $projectID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setProjectID ($projectID) {
    $this->projectID = $projectID;
  }

  public function setURL ($url) {
    $this->JiraURL = rtrim($url, "/");
  }

  public function initialize () {
    $projectID = $this->projectID;

    $userName = $this->credentials->getAdminUserName();
    $password = $this->credentials->getAdminPassword();

    $uri= $this->JiraURL . "/rest/api/2/search?jql=project=$projectID";
    $response = Httpful\Request::get($uri)
                             ->authenticateWith($userName, $password)
                             ->send();
    $IssuesCount = (int) $response->body->total;

    $this->setValue($IssuesCount);                             
  }
}