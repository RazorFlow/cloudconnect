<?php

class TrelloCredentials {
  protected $apiKey;
  protected $token;

  /**
   * Sets Application Key for a Trello account
   */
  public function setAPIKey($apiKey ) {
    $this->apiKey = $apiKey;
  }

  /**
   * Set the Token, you can set for a period or forever
   * URI to get the token:
   * https://trello.com/1/authorize?key=apikey&name=RazorFlow&expiration=never&response_type=token
   */
  public function setToken($token) {
    $this->token = $token;
  }

  /**
   * Get the Applicaton key that was set using setAPIKey
   */
  public function getAPIKey () {
    return $this->apiKey;
  }

  /**
   * Get the Token
   */
  public function getToken () {
    return $this->token;
  }
}

?>