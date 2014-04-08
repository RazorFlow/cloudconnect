<?php

class MixpanelCredentials {
  protected $api_key;
  protected $api_secret;

  public function setAPIKey ($key) {
    $this->api_key = $key;
  }

  public function setAPISecret ($secret) {
    $this->api_secret = $secret;
  }

  public function getAPIKey () {
    return $this->api_key;
  }

  public function getAPISecret () {
    return $this->api_secret;
  }
}