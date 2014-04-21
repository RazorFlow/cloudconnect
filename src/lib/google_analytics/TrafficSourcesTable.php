<?php

class TrafficSourcesTable extends TableComponent {
  protected $credentials;
  protected $viewID;

  /**
  * This function sets your Google Analytics credentials for TrafficSourcesTable.
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


  public function initialize () {
    $access_token = $this->credentials->getAccessToken();
    $viewID = $this->viewID;

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID";
    $uri .= "&metrics=ga:organicSearches&dimensions=ga:source&sort=-ga:organicSearches&max-results=10";
    $uri .= "&start-date=2005-01-01&end-date=today&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart ($response->body->rows);

  }

  /**
   * This function is to be used internally only.
   * @param  Array $dataRows 
   */
  private function setupChart ($dataRows) {
    $rows = [];
    $this->addColumn("source", "Traffic Source");
    $this->addColumn("searches", "Searches");

    foreach ($dataRows as $dataRow) {
      array_push($rows, array(
        "source" => $dataRow[0],
        "searches" => $dataRow[1]
      ));
    }

    $this->addMultipleRows($rows);
  }
}

?>