<?php

class BounceRateKPI extends KPIComponent {
  protected $credentials;
  protected $viewID;

  /**
  * This function sets your Google Analytics credentials for BounceRateKPI.
  * @param Object $credentials GoogleAnalyticsCredentials object
  */
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
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

  public function initialize () {
    $access_token = $this->credentials->getAccessToken();
    $viewID = $this->viewID;

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID";
    $uri .= "&metrics=ga:visits,ga:bounces&start-date=2005-01-01&end-date=today&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $metrics = get_object_vars($response->body->totalsForAllResults);
    $visits = (int) $metrics['ga:visits'];
    $bounces = (int) $metrics["ga:bounces"];
    $bounceRate = ($bounces/$visits) * 100;
    
    $this->setValue($bounceRate, array("numberSuffix" => "%"));
  }
}
?>