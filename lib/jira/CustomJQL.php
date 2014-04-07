<?php

class CustomJQL extends KPIComponent {
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

  public function getBaseQueryURL () {
    return $this->JiraURL . "/rest/api/latest/search?jql=";
  }

  protected $jql;
  public function setCustomJQL ($jql) {
    $this->jql = preg_replace("/\s/", "+", $jql);
  }


  public function initialize () {
    $projectID = $this->projectID;
    $jql = $this->jql;

    $userName = $this->credentials->getAdminUserName();
    $password = $this->credentials->getAdminPassword();

    $uri = $this->getBaseQueryURL() . $jql;
    $response = Httpful\Request::get($uri)
                             ->authenticateWith($userName, $password)
                             ->send();
    $IssuesCount = (int) $response->body->total;

    $this->setValue($IssuesCount);                             
  }
}