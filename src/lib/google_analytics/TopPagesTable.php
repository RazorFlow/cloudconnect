<?php

class TopPagesTable extends TableComponent {
  protected $credentials;
  protected $viewID;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setViewID ($viewID) {
    $this->viewID = $viewID;
  }

  public function initialize() {
    $access_token = $this->credentials->getAccessToken();
    $viewID = $this->viewID;

    $uri = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga:$viewID";
    $uri .= "&metrics=ga:pageviews&dimensions=ga:pageTitle&sort=-ga:pageviews&max-results=10&start-date=7daysAgo&end-date=today";
    $uri .= "&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupTable ($response->body->rows);
  }

  public function setupTable ($dataRows) {
    $rows = [];
    $this->addColumn("name", "Page Name");
    $this->addColumn("visits", "Visits");

    foreach ($dataRows as $dataRow) {
      array_push($rows, array(
        "name" => $dataRow[0],
        "visits" => $dataRow[1]
      ));
    }

    $this->addMultipleRows($rows);

  }
}
?>