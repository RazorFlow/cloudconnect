<?php

class PageLikesKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;

  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  public function setCredentialsObject ($credentials) {
    $this->credentials = $credentials;
  }

  public function initialize () {
    $pageID = $this->pageID;
    $access_token = $this->credentials->getAccessToken();

    $uri = "https://graph.facebook.com/$pageID/insights/page_fans?access_token=" . $access_token;
    $response = Httpful\Request::get($uri)->send();

    $metricValues = $response->body->data[0]->values;
    $metricValLatest = (int) count($metricValues);
    $pageLikes = (int) $metricValues[$metricValLatest-1]->value;
    $this->setValue ($pageLikes);
  }
}