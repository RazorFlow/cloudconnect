<?php

require "../../rfphp/razorflow.php";
require "../../src/lib/google_analytics/GoogleAnalyticsCredentials.php";
require "../../src/lib/google_analytics/VisitorStatsKPI.php";
require "../../src/lib/google_analytics/BounceRateKPI.php";
require "../../vendor/autoload.php";

class GAReportsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Google Analytics Dashboard");

    $cred = new GoogleAnalyticsCredentials();
    $cred->setAccessToken ("ya29.1.AADtN_X1pu-Vh4s_D9IQqbV9zlOBPJL_a9GIev3PbTVUZTxRbqgZoerWmNhbUaxGpa_V1g");

    $statsKPI = new VisitorStatsKPI ('vs');
    $statsKPI->setCredentialsObject ($cred);
    $statsKPI->setDimensions (2,2);
    $statsKPI->setCaption ("Number of View this Week");
    $statsKPI->setViewID ("69481643");
    $statsKPI->setQuery("metrics=ga:visits&start-date=9daysAgo&end-date=today");

    $bounceRate = new BounceRateKPI ('br');
    $bounceRate->setCredentialsObject ($cred);
    $bounceRate->setDimensions (2,2);
    $bounceRate->setCaption ("Bounce Rate");
    $bounceRate->setViewID("69481643");

    $this->addComponent ($statsKPI);
    $this->addComponent ($bounceRate);
  }
}

$db = new GAReportsDashboard();
$db->renderStandalone();

?>