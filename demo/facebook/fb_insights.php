<?php

require "../../rfphp/razorflow.php";
require "../../lib/facebook/FacebookCredentials.php";
require "../../lib/facebook/PageLikesKPI.php";
require "../../vendor/autoload.php";

class FBInsightsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle ("RazorFlow Facebook Insights");

    $cred = new FacebookCredentials ();
    $cred->setAccessToken ("CAACEdEose0cBAPgZCVZBpZAVn6hBeLFf2yITwBClR7kFU0KnZAyHMX3alwewxmwLNTWaBFqqqNS72kw0ynyskMgdW5HsZBzHIvulBdTEjhm6cEDme4ni4yQzI4wHn65y9jSGYVZAFyHxZBZAWHqW5W4abF6AuqbOmykmXhzthhcpD3ExCzDGTaa1tNQqlLpOh1AZD");

    $pageLikes = new PageLikesKPI ('pl');
    $pageLikes->setCredentialsObject ($cred);
    $pageLikes->setDimensions (4,4);
    $pageLikes->setCaption ("Page Likes");
    $pageLikes->setPageID ("319090954847321");

    $this->addComponent ($pageLikes);
  }
}

  $db = new FBInsightsDashboard();
  $db->renderStandalone();

?>