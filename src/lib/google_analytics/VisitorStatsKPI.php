<?php

class VisitorStatsKPI extends KPIComponent {
  protected $credentials;
  protected $query;
  protected $viewID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setQuery ($query) {
    $this->query = $query;
  }

  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }


  public function getURI () {
    $query = $this->query;

    $BaseURI = "https://www.googleapis.com/analytics/v3/data/ga?";
    $BaseURI .= "ids=ga:" . $this->viewID . "&";
    $BaseURI .= $this->query;
    return $BaseURI . "&access_token=" . $this->credentials->getAccessToken();
  }

  public function initialize () {
    $uri = $this->getURI();
    $response = Httpful\Request::get($uri)->send();
    $metricName = $response->body->columnHeaders[0]->name;
    $metricValue = (int) $response->body->totalsForAllResults->$metricName;

    $this->setValue($metricValue);

  }
}


?>