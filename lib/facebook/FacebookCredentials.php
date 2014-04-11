<?php

class FacebookCredentials {
  protected $access_token;

  public function setAccessToken ($access_token) {
    $this->access_token = $access_token;
  }

  public function getAccessToken () {
    return $this->access_token;
  }
}

?>