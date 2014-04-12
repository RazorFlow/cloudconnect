<?php

class PageLikesSourcesChart extends ChartComponent {
  protected $credentials;
  protected $pageID;
  protected $timezone;

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  public function setTimezone ($timezone) {
    $this->timezone = $timezone;
  }

  public function initialize () {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();
    date_default_timezone_set($this->timezone);
    $since = strtotime("-1month");
    $until = time();

    $uri = "https://graph.facebook.com/$pageID/insights/page_fans_by_like_source";
    $uri .= "?since=$since&until=$until&access_token=$access_token";
    $response = Httpful\Request::get($uri)->send();

    $this->setupChart($response);
  }

  public function setupChart($response) {
    $values = $response->body->data[0]->values;
    $sourcesBucket = array();

    foreach ($values as $item) {
      if($item->value) {
        foreach ($item->value as $source => $count) {
          if(array_key_exists($source, $sourcesBucket)) {
            $sourcesBucket[$source] += (int) $count;
          } else {
            $sourcesBucket[$source] = (int) $count;
          }
        }
      }
    }

    $sourcesCount = [];
    $sourcesNames = [];

    foreach ($sourcesBucket as $sourceName => $sourceCount) {
      array_push($sourcesNames, $sourceName);
      array_push($sourcesCount, $sourceCount);
    }
    
    $this->setLabels ($sourcesNames);
    $this->addSeries ("likes_sources", "Likes Sources", $sourcesCount);

  }
} 
?>