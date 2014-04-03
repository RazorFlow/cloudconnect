<?php

class FeedTable extends TableComponent {
  protected $feedURL;

  /**
   * Set the URL to the RSS Feed
   */
  public function setFeedURL ($url) {
    $this->feedURL = $url;
  }

  /**
   * Get the Feed URL set using setFeedURL
   */
  public function getFeedURL () {
    return $this->feedURL;
  }

  public function initialize() {
    $feedURL = $this->getFeedURL();
    $feed = simplexml_load_file($feedURL);

    $this->addColumn ('title', 'Title');
    $this->addColumn ('date', 'Date');

    $rows = [];
    
    foreach ($feed->channel->item as $item) {
      array_push($rows, array(
        "title" => (string) $item->title,
        "date" => (string) $item->pubDate
      ));
    }
    $this->addMultipleRows($rows);
  }
}