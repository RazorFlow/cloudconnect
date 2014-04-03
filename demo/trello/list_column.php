<?php

require "../../rfphp/razorflow.php";
require "../../lib/trello/TrelloCredentials.php";
require "../../lib/trello/ListColumnChart.php";
require "../../vendor/autoload.php";

class TrelloListDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashBoardTitle("Trello List Overview");

    $credentials = new TrelloCredentials();
    $credentials->setAPIKey("97b2882040c4a25d0e9aeb3ff157b35c");
    $credentials->setToken("9460904af5046dcfcc6163687fca5b5414e2db27771d87915637352c8dc1d591");

    $colChart = new ListColumnChart ('trlist');
    $colChart->setCredentialsObject ($credentials);
    $colChart->setDimensions(4,4);
    $colChart->setBoardID("xg4HlDhn");
    $colChart->setCaption("Number of Cards in each List");

    $this->addComponent($colChart);
  }
}

$db = new TrelloListDashboard();
$db->renderStandalone();
?>