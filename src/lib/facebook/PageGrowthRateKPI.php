<?php

class PageGrowthRateKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;  
  protected $timezone;
  protected $period;

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
  * This function sets your Facebook credentials for PageGrowthRateKPI.
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

  /**
   * Use this function to set your timezone for accurate results.
   * @param String $timezone
   */
  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  } 

  public function initialize () {
    $growthRate = $this->getGrowthRateForPeriod ($this->period);
    $this->setValue($growthRate, array("numberSuffix" => "%"));
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
  private function getGrowthRateForPeriod ($period) {
    date_default_timezone_set($this->timezone);
    $period = "-1$period";
    $since = strtotime($period);
    $until = time();

    $endpoint = "/page_fans?since=$since&until=$until&";
    $response = $this->makeRequest ($endpoint);

    $values = $response->body->data[0]->values;

    $pastFans = $values[0]->value;
    $valuesCount = (int) count($values);
    $currentFans = (int) $values[$valuesCount-1]->value;
    $growthRate = ($currentFans - $pastFans)/$pastFans * 100;
    return $growthRate;
  }
}
?>