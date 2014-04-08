<?php

class TrendsCount extends KPIComponent {
  protected $args = [];

  public function setCredentialsObject ($credentials) {
    $this->args["api_key"] = $credentials->getAPIKey();
    $this->api_secret = $credentials->getAPISecret();
  }

  public function setEvent ($event_name, $event_type) {
    $this->args["event"] = $event_name;
    $this->args["type"] = $event_type;
  }

  public function setTimePeriod ($unit, $interval) {
    $this->args["unit"] = $unit;
    $this->args["interval"] = $interval;
  }

  public function initialize () {
    $sig = $this->getSignature();
    $eventName = trim($this->args["event"], "[]\"");
    $baseURI = "http://mixpanel.com/api/2.0/events/?";

    foreach ($this->args as $key => $value) {
      $baseURI .= $key . "=" . urlencode($value) . "&";
    }
    $uri = $baseURI . "sig=" . $sig;

    $response = Httpful\Request::get($uri)->send();
    $eventData = $response->body->data;
    $eventPeriod = $eventData->series[0];
    $eventCount = (int) $eventData->values->$eventName->$eventPeriod;

    $this->setValue($eventCount);
    
  }

  public function getSignature () {
    $args_concat = "";
    $this->args["expire"] = time() + 60;
    ksort($this->args);

    foreach ($this->args as $key => $value) {
      $args_concat .= $key . "=" . $value;
    }

    $sig = $args_concat . $this->api_secret;
    return md5($sig);
  }


}