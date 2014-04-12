<?php

class PageGrowthRateKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;  
  protected $timezone;
  protected $period;

  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setPeriod ($period) {
    $this->period = $period;
  }

  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  } 

  public function initialize () {
    $growthRate = $this->getGrowthRateForPeriod ($this->period);
    $this->setValue($growthRate, array("numberSuffix" => "%"));
  }

  public function makeRequest ($endpoint) {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();

    $uri = "https://graph.facebook.com/$pageID/insights" . $endpoint;
    $uri .= "access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();
    return $response;
  }

  public function getGrowthRateForPeriod ($period) {
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