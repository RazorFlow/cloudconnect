<?php

class PageAttritionRateKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;
  protected $period;
  protected $timezone;

  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setPeriod ($period) {
    $this->period = $period;
  }

  public function initialize () {
    $fanRemoves = $this->getFanRemoves();
    $totalFans = $this->getTotalFans();

    $attritionRate = ($fanRemoves/$totalFans) * 100;
    $this->setValue($attritionRate, array("numberSuffix" => "%"));
    
  }

  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  } 

  public function makeRequest ($endpoint) {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();

    $uri = "https://graph.facebook.com/$pageID/insights" . $endpoint;
    $uri .= "access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();
    return $response;
  }

  public function getFanRemoves () {
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

  public function getTotalFans () {
    $endpoint = "/page_fans?";
    $response = $this->makeRequest ($endpoint);

    $metricValues = $response->body->data[0]->values;
    $metricValLatest = (int) count($metricValues);
    $pageLikes = (int) $metricValues[$metricValLatest-1]->value;

    return $pageLikes;
  }
}

?>