<?php

class ProgressPieChart extends ChartComponent {
  protected $credentials;
  protected $JiraURL;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  protected $projectID;
  public function setProjectID ($projectID) {
    $this->projectID = $projectID;
  }

  public function setURL ($url) {
    $this->JiraURL = rtrim($url, "/");
  }

  public function initialize () {
    $issuesCount = $this->getIssuesCount();
    $this->setLabels(["Open/Re-Opened", "In Progress", "Resolved/Closed"]);
    $this->setPieValues($issuesCount);
  }

  public function makeRequest ($query) {
    $projectID = $this->projectID;
    $userName = $this->credentials->getAdminUserName();
    $password = $this->credentials->getAdminPassword();

    $baseURI= $this->JiraURL . "/rest/api/latest/search?jql=project=$projectID";
    $uri =  $baseURI . $query;
    $response = Httpful\Request::get($uri)
                          ->authenticateWith($userName, $password)
                          ->send();
    return (int) $response->body->total;

  }
  
  public function getIssuesCount () {
    $openIssuesQuery = "+and+status+=+open+or+status+=+reopened";
    $openIssuesCount = $this->makeRequest ($openIssuesQuery);
    
    $inProgressQuery = "+and+status+=+" . urlencode("'in progress'");
    $inProgressIssuesCount = $this->makeRequest ($inProgressQuery);

    $resolvedIssuesQuery = "+and+status+=+resolved+or+status+=+closed";
    $resolvedIssuesCount = $this->makeRequest ($resolvedIssuesQuery);

    return [$openIssuesCount, $inProgressIssuesCount, $resolvedIssuesCount];

  }
}