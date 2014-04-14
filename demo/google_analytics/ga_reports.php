<?php

require "../../rfphp/razorflow.php";
require "../../src/lib/google_analytics/GoogleAnalyticsCredentials.php";
require "../../src/lib/google_analytics/VisitorStatsKPI.php";
require "../../src/lib/google_analytics/BounceRateKPI.php";
require "../../src/lib/google_analytics/AverageTimeChart.php";
require "../../src/lib/google_analytics/TopPagesTable.php";
require "../../vendor/autoload.php";

class GAReportsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Google Analytics Dashboard");

    $cred = new GoogleAnalyticsCredentials();
    $cred->setAccessToken ("ya29.1.AADtN_X2_j4OlxBBLd1hH5kn3Enko4dEqCSut8fByRFJzxN7t465YY3XgKJiuQiQsdRq6w");

    $statsKPI = new VisitorStatsKPI ('vs');
    $statsKPI->setCredentialsObject ($cred);
    $statsKPI->setDimensions (2,2);
    $statsKPI->setCaption ("Number of Views this Week");
    $statsKPI->setViewID ("69481643");
    $statsKPI->setQuery("metrics=ga:visits&start-date=9daysAgo&end-date=today");

    $bounceRate = new BounceRateKPI ('br');
    $bounceRate->setCredentialsObject ($cred);
    $bounceRate->setDimensions (2,2);
    $bounceRate->setCaption ("Bounce Rate");
    $bounceRate->setViewID("69481643");

    $avgTime = new AverageTimeChart ('av');
    $avgTime->setCredentialsObject($cred);
    $avgTime->setDimensions(12,4);
    $avgTime->setCaption ("Average Time on Site");
    $avgTime->setViewID("69481643");
    $avgTime->setTimezone("Asia/Kolkata");

    $topPages = new TopPagesTable ('tp');
    $topPages->setCredentialsObject($cred);
    $topPages->setDimensions(4,4);
    $topPages->setCaption("Top Pages");
    $topPages->setViewID("69481643");

    $this->addComponent ($avgTime);
    $this->addComponent ($topPages);
    $this->addComponent ($statsKPI);
    $this->addComponent ($bounceRate);
 

  }
}

$db = new GAReportsDashboard();
$db->renderStandalone();

?>