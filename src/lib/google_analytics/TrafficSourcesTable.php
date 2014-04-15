<?php

class TrafficSourcesTable extends TableComponent {
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

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID";
    $uri .= "&metrics=ga:organicSearches&dimensions=ga:source&sort=-ga:organicSearches&max-results=10";
    $uri .= "&start-date=2005-01-01&end-date=today&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart ($response->body->rows);

  }

  public function setupChart ($dataRows) {
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