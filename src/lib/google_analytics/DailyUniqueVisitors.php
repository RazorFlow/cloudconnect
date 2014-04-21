<?php

class DailyUniqueVisitors extends ChartComponent {
  protected $credentials;
  protected $viewID;
  protected $timezone;

  /**
  * This function sets your Google Analytics credentials for DailyUniqueVisitors.
  * @param Object $credentials GoogleAnalyticsCredentials object
  */
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  /**
   * Sets the ID of the View for which the data has to be pulled.
   * To know the ID of the view you want, follow these steps
   *   1) Click on Admin
   *   2) Select the required view under the VIEW Column (which is the last column)
   *   3) Click on view settings
   *   4) Note down your View ID
   * @param String $viewID
   */ 
  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }

  /**
   * Use this function to set your timezone for accurate results.
   * @param String $timezone
   */
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

  /**
   * This function is to be used internally only.
   * @param  Array $dataRows 
   */
  private function setupChart ($dataRows) {
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