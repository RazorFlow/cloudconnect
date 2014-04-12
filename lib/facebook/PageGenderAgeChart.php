<?php

class PageGenderAgeChart extends ChartComponent {
  protected $credentials;
  protected $pageID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  public function initialize () {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();

    $uri = "https://graph.facebook.com/$pageID/insights/page_fans_gender_age?access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart($response);
  }

  public function generateAgeRangesMap () {
    $ageRanges = array("18-24" => 0);
    $start = 24;
    //no one lives more than this :P
    for ($i=1; $i <9 ; $i++) { 
      $range = (string)($start+1) . "-" . (string)($start+10);
      $ageRanges[$range] = $i;
      $start += 10;
    }
    return $ageRanges;
  }

  public function setupChart($response) {
    $values = $response->body->data[0]->values;
    $recentValuesObj = $values[count($values)-1];
    $recentValues = get_object_vars($recentValuesObj->value);
    $ageRanges = $this->generateAgeRangesMap();

    $maleAgeValues = array_fill(0, 9, 0);
    $femaleAgeValues = array_fill(0, 9, 0);

    //work in progress
    foreach ($variable as $key => $value) {
      # code...
    }

  }

}
?>