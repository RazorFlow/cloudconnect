<?php

require "../../rfphp/razorflow.php";
require "../../lib/rss/FeedTable.php";
require "../../vendor/autoload.php";

class FeedTableDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("RSS Feed Overview");

    $feedTable = new FeedTable('rss_tbl');
    $feedTable->setDimensions(6,6);
    $feedTable->setFeedURL("http://blog.evernote.com/tech/feed/");
    $feedTable->setCaption("Feed Table");

    $this->addComponent($feedTable);
  }
}

$db = new FeedTableDashboard();
$db->renderStandalone();

?>