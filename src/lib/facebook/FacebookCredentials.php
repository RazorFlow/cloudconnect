<?php

class FacebookCredentials {
  protected $access_token;

  /**
   * Use this function to set your Facebook account access token.
   * You can use the Facebook helper to know your access token.
   * @param string $access_token 
   */
  public function setAccessToken ($access_token) {
    $this->access_token = $access_token;
  }

  /**
   * This is an access_token getter to be used internally
   * @return string
   */
  public function getAccessToken () {
    return $this->access_token;
  }
}

?>