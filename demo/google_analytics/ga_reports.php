<?php

require "../../rfphp/razorflow.php";
require "../../lib/google_analytics/GoogleAnalyticsCredentials.php";
require "../../lib/google_analytics/VisitorStatsKPI.php";
require "../../vendor/autoload.php";

class GAReportsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Google Analytics Dashboard");

    $cred = new GoogleAnalyticsCredentials();
    $cred->setAccessToken ("ya29.1.AADtN_VQrJKdK6YhULHsDfnl0g9o9l2ooY1ZCHcf5BHsH96b6WW6ZUOMLJmKKV0");

    $statsKPI = new VisitorStatsKPI ('vs');
    $statsKPI->setCredentialsObject ($cred);
    $statsKPI->setDimensions (4,4);
    $statsKPI->setCaption ("Number of View this Week");
    $statsKPI->setViewID ("69481643");
    $statsKPI->setQuery("metrics=ga:visits&start-date=9daysAgo&end-date=today");
    $this->addComponent ($statsKPI);
  }
}

$db = new GAReportsDashboard();
$db->renderStandalone();

?>