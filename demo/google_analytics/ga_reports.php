<?php

require "../../rfphp/razorflow.php";
require "../../src/lib/google_analytics/GoogleAnalyticsCredentials.php";
require "../../src/lib/google_analytics/VisitorStatsKPI.php";
require "../../src/lib/google_analytics/BounceRateKPI.php";
require "../../src/lib/google_analytics/AverageTimeChart.php";
require "../../src/lib/google_analytics/TopPagesTable.php";
require "../../src/lib/google_analytics/TrafficSourcesTable.php";
require "../../vendor/autoload.php";

class GAReportsDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Google Analytics Dashboard");

    $cred = new GoogleAnalyticsCredentials();
    $cred->setAccessToken ("ya29.1.AADtN_Vfkx75VQB-q4viMSpBXWNvjFG4RZb4uGlT33ARbizTyMIt-Bdp8BltBSo");

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

    $topSources = new TrafficSourcesTable ('ts');
    $topSources->setCredentialsObject($cred);
    $topSources->setDimensions(4,4);
    $topSources->setCaption("Top Traffic Sources");
    $topSources->setViewID("69481643");

    $this->addComponent ($avgTime);
    $this->addComponent ($topPages);
    $this->addComponent ($topSources);
    $this->addComponent ($statsKPI);
    $this->addComponent ($bounceRate);
    
 

  }
}

$db = new GAReportsDashboard();
$db->renderStandalone();

?>