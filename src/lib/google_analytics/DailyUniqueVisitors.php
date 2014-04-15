<?php

class DailyUniqueVisitors extends ChartComponent {
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
    $uri .= "&metrics=ga:visitors&dimensions=ga:date&start-date=30daysAgo&end-date=today&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart ($response->body->rows);
  }

  public function setupChart ($dataRows) {
    $labels = [];
    $uniqueVisitorsSeries = [];
    date_default_timezone_set($this->timezone);

    foreach ($dataRows as $row) {
      $timeStamp = strtotime($row[0]);
      $date = date("Y-M-d", $timeStamp);
      $dateParts = explode("-", $date);
      $currLabel = $dateParts[1] . "-" . $dateParts[2];

      array_push($labels, $currLabel);
      array_push($uniqueVisitorsSeries, (int)$row[1]);
    }

    $this->setLabels ($labels);
    $this->addSeries("uniqueVisitors", "Unique Visitors", $uniqueVisitorsSeries);
  }
}

?>