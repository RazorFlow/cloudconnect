<?php

class AverageTimeChart extends ChartComponent {
  protected $credentials;
  protected $viewID;
  protected $timezone;
 
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }

  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  }

  public function initialize () {
    $access_token = $this->credentials->getAccessToken();
    $viewID = $this->viewID;

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID";
    $uri .= "&metrics=ga:timeOnSite,ga:visits&start-date=30daysAgo&end-date=today&dimensions=ga:date";
    $uri .= "&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart ($response->body->rows);
  }

  /**
   * In the order of the above query string, each row will be ordered
   * this way, 0 -> timestamp, 1 -> timeOnSite, 2 -> vists  
   */
  public function setupChart ($dataRows) {
    $labels = [];
    $avgTimeSeries = [];
    date_default_timezone_set($this->timezone);

    foreach ($dataRows as $row ) {
      $timeStamp = strtotime($row[0]);
      $date = date("Y-M-d", $timeStamp);
      $dateParts = explode("-", $date);
      $currLabel = $dateParts[1] . "-" . $dateParts[2];
      $timeOnSite = (int) $row[1] / 60; //calculate in minutes
      $avgTimeOnSite = (int) ($timeOnSite / (int) $row[2]);

      array_push($labels, $currLabel);
      array_push($avgTimeSeries, $avgTimeOnSite);
    }
    
    $this->setLabels($labels);
    $this->addSeries("time", "Time", $avgTimeSeries, array(
        "seriesDisplayType" => "line"
    ));
  }

}
?>