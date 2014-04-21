<?php

class PageAttritionRateKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;
  protected $period;
  protected $timezone;

  /**
   * Sets the ID of the page for which data should be pulled.
   * Follow these steps to know your Facebook Page ID,
   *   1) On the Page home, click on Edit Page 
   *   2) Select Edit Settings
   *   3) Click on Page Info tab
   *   4) Scroll to the bottom and note down your Facebook Page ID
   * 
   * @param String $pageID
   */
  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  /**
  * This function sets your Facebook credentials for PageAttritionKPI.
  * @param Object $credentials FacebookCredentials object
  */
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  /**
   * Set the period for which the data should be retrieved
   * @param String $period Accepted values: day, week, month, and year
   */
  public function setPeriod ($period) {
    $this->period = $period;
  }

  public function initialize () {
    $fanRemoves = $this->getFanRemoves();
    $totalFans = $this->getTotalFans();

    $attritionRate = ($fanRemoves/$totalFans) * 100;
    $this->setValue($attritionRate, array("numberSuffix" => "%"));
    
  }

  /**
   * Use this function to set your timezone for accurate results.
   * @param String $timezone
   */
  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  } 

  /**
   * This is an internal function.
   */
  private function makeRequest ($endpoint) {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();

    $uri = "https://graph.facebook.com/$pageID/insights" . $endpoint;
    $uri .= "access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();
    return $response;
  }

  /**
   * This is an internal function.
   */
  private function getFanRemoves () {
    $totalFanRemoves = 0;
    
    date_default_timezone_set($this->timezone);
    $period = "-1" . $this->period;
    $since = strtotime($period);
    $until = time();
    $endpoint = "/page_fan_removes?since=$since&until=$until&";

    $response = $this->makeRequest ($endpoint);
    $values = $response->body->data[0]->values; 

    foreach ($values as $unitValue) {
      $totalFanRemoves += (int) $unitValue->value;
    }

    return $totalFanRemoves;
  }

  /**
   * This is an internal function.
   */
  private function getTotalFans () {
    $endpoint = "/page_fans?";
    $response = $this->makeRequest ($endpoint);

    $metricValues = $response->body->data[0]->values;
    $metricValLatest = (int) count($metricValues);
    $pageLikes = (int) $metricValues[$metricValLatest-1]->value;

    return $pageLikes;
  }
}

?>