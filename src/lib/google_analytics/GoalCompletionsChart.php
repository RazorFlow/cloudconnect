<?php

class GoalCompletionsChart extends ChartComponent {
  protected $credentials;
  protected $viewID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }

  public function initialize () {
    $access_token = $this->credentials->getAccessToken();
    $viewID = $this->viewID;

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID&metrics=ga:goalStartsAll,ga:goalCompletionsAll";
    $uri .= "&start-date=2005-01-01&end-date=today&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart ($response->body->totalsForAllResults);    
  }

  public function setupChart ($valuesObj) {
    $values = get_object_vars($valuesObj);
    $goalsStarted = (int) $values["ga:goalStartsAll"];
    $completions = (int) $values["ga:goalCompletionsAll"];
    $abandons =  $goalsStarted - $completions; 
    $this->setLabels(["Completions", "Abandons"]);
    $this->setPieValues([$completions, $abandons]);
  }

}
?>