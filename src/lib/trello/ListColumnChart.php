<?php

class ListColumnChart extends ChartComponent {
  protected $credentials;
  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  protected $boardID;
  
  /**
   * Function to set the board ID which is a part of the board url
   */
  public function setBoardID ($boardID) {
    $this->boardID = $boardID;
  }

  /**
   * Get the board ID that was set
   */
  public function getBoardID () {
    return $this->boardID;
  }

  public function initialize () {
    $boardID = $this->getBoardID();
    $apiKey = $this->credentials->getAPIKey();
    $token = $this->credentials->getToken();

    $uri = "https://api.trello.com/1/board/$boardID/lists?cards=all&key=$apiKey&token=$token";

    $response = Httpful\Request::get($uri)->send();
    //setup chart labels and series
    $this->setupChart($response->body);
  }

  /**
   * Function to setup the chart from a list of lists
   */
  public function setupChart($lists) {
    $list_names = [];
    $no_cards_in_lists = [];

    foreach ($lists as $list) {
      array_push($list_names, $list->name);
      array_push($no_cards_in_lists, count($list->cards));
    }

    $this->setLabels($list_names);
    $this->addSeries("no_cards", "Number of Cards", $no_cards_in_lists);
  }
}

?>