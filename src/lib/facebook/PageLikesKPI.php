<?php

class PageLikesKPI extends KPIComponent {
  protected $credentials;
  protected $pageID;

  /**
   * Sets the ID of the page for which data should be pulled.
   * Follow these steps to know your Facebook Page ID,
   *   1) On the Page home, click on Edit Page 
   *   2) Select Edit Settings
   *   3) Click on Page Info tab
   *   4) Scroll to the bottom and note down your Facebook Page ID
   * 
   * @param String $pageID
   */
  public function setPageID ($pageID) {
    $this->pageID = $pageID;
  }

  /**
  * This function sets your Facebook credentials for PageGrowthRateKPI.
  * @param Object $credentials FacebookCredentials object
  */
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