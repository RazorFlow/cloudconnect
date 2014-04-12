<?php

require "../../rfphp/razorflow.php";
require "../../lib/facebook/FacebookCredentials.php";
require "../../lib/facebook/PageLikesKPI.php";
require "../../lib/facebook/PageAttritionRateKPI.php";
require "../../lib/facebook/PageGrowthRateKPI.php";
require "../../lib/facebook/PageLikesSourcesChart.php";
require "../../vendor/autoload.php";

class FBInsightsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle ("RazorFlow Facebook Insights");

    $cred = new FacebookCredentials ();
    $cred->setAccessToken ("CAACEdEose0cBALDdAHUu7TMhlxC99FOzEhT6enQcHJ80OAeWM7ZAdrHnUPASYmNXOjo7OiZC6U9GHOAk6gOqPxP6qpogigvvPr9o1nCrBHftPmlU7VZAQThq5QUEunbgdwvFsPYI5yDjEQpdK4CZAiIgMkdhZAktyakpAkQLa8clghbR37lDk7bljOGJC97MZD");

    $pageLikes = new PageLikesKPI ('pl');
    $pageLikes->setCredentialsObject ($cred);
    $pageLikes->setDimensions (2,2);
    $pageLikes->setCaption ("Page Likes");
    $pageLikes->setPageID ("319090954847321");

    $attrition = new PageAttritionRateKPI ('ar');
    $attrition->setCredentialsObject ($cred);
    $attrition->setDimensions (2,2);
    $attrition->setCaption ("Weekly Attrition Rate");
    $attrition->setPageID ("319090954847321");
    $attrition->setPeriod ("week");
    $attrition->setTimezone ("Asia/Kolkata");

    $growthRate = new PageGrowthRateKPI ('pg');
    $growthRate->setCredentialsObject ($cred);
    $growthRate->setDimensions (2,2);
    $growthRate->setCaption ("Weekyl Growth Rate");
    $growthRate->setPageID ("319090954847321");
    $growthRate->setPeriod ("week");
    $growthRate->setTimezone("Asia/Kolkata");

    $likesSources = new PageLikesSourcesChart ('ls');
    $likesSources->setCredentialsObject ($cred);
    $likesSources->setDimensions (4,4);
    $likesSources->setCaption ("Likes Sources");
    $likesSources->setPageID ("319090954847321");
    $likesSources->setTimezone("Asia/Kolkata");

    $this->addComponent ($pageLikes);
    $this->addComponent ($attrition);
    $this->addComponent ($growthRate);
    $this->addComponent ($likesSources);
  }
}

  $db = new FBInsightsDashboard();
  $db->renderStandalone();

?>