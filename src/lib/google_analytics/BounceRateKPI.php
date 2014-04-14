<?php

class BounceRateKPI extends KPIComponent {
  protected $credentials;
  protected $viewID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

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