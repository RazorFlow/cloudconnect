<?php

require "../../rfphp/razorflow.php";
require "../../lib/facebook/FacebookCredentials.php";
require "../../lib/facebook/PageLikesKPI.php";
require "../../lib/facebook/PageAttritionRateKPI.php";
require "../../vendor/autoload.php";

class FBInsightsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle ("RazorFlow Facebook Insights");

    $cred = new FacebookCredentials ();
    $cred->setAccessToken ("CAACEdEose0cBAAGEKTab8KvbYyLre8mTscL7f4ES0hMFmTDZCJ1L3Je3vRdxq3evBZB6ZBTLRM3btQXEkCvsyBvTJGWfkY1VfnzXGnrcnRqnDZCBQJj9dJjEHW8J6NfCE0Rp9DVHMF0ZCku2e7IsPYXrKjaKY6uVSeqAi8O5t1yDS8rd1o1yzzaxXGajhZBtIZD");

    $pageLikes = new PageLikesKPI ('pl');
    $pageLikes->setCredentialsObject ($cred);
    $pageLikes->setDimensions (4,4);
    $pageLikes->setCaption ("Page Likes");
    $pageLikes->setPageID ("319090954847321");

    $attrition = new PageAttritionRateKPI ('ar');
    $attrition->setCredentialsObject ($cred);
    $attrition->setDimensions (4,4);
    $attrition->setCaption ("Weekly Attrition Rate");
    $attrition->setPageID ("319090954847321");
    $attrition->setPeriod ("week");
    $attrition->setTimezone ("Asia/Kolkata");

    $this->addComponent ($pageLikes);
    $this->addComponent ($attrition);
  }
}

  $db = new FBInsightsDashboard();
  $db->renderStandalone();

?>