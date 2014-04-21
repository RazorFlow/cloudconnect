<?php

class VisitorStatsKPI extends KPIComponent {
  protected $credentials;
  protected $query;
  protected $viewID;

  /**
   * This function sets your Google Analytics credentials for VisitorStatsKPI.
   * @param Object $credentials GoogleAnalyticsCredentials object
   */
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  /**
   * This function lets you write a custom query to generate a KPI Component.
   * The query should be in Google Analytics query string format. It can contain only one metric
   * with an aggregated output.
   *
   * Example: metrics=ga:visits&start-date=7daysAgo&end-date=today
   * @param String $query 
   */
  public function setQuery ($query) {
    $this->query = $query;
  }

  /**
   * Sets the ID of the View for which the data has to be pulled.
   * To know the ID of the view you want, follow these steps
   *   1) Click on Admin
   *   2) Select the required view under the VIEW Column (which is the last column)
   *   3) Click on view settings
   *   4) Note down your View ID
   * @param String $viewID
   */ 
  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }

  /**
   * This should be used for internal purposes only
   */
  private function getURI () {
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