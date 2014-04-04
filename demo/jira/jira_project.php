<?php

require "../../rfphp/razorflow.php";
require "../../lib/jira/JiraCredentials.php";
require "../../lib/jira/ProgressPieChart.php";
require "../../lib/jira/DaysToRelease.php";
require "../../lib/jira/IssuesCount.php";
require "../../vendor/autoload.php";

class JiraProgressDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Jira Project Progress Dashboard");

    $cred = new JiraCredentials();
    $cred->setCredentials("selwyn", "razorflow");

    $progPie = new ProgressPieChart('pp');
    $progPie->setCredentialsObject($cred);
    $progPie->setDimensions(4, 4);
    $progPie->setCaption("Project Progress");
    $progPie->setURL("https://razorflow.atlassian.net/");
    $progPie->setProjectID("10000");

    $DaysToRelease = new DaysToRelease('nr');
    $DaysToRelease->setCredentialsObject($cred);
    $DaysToRelease->setDimensions(4,4);
    $DaysToRelease->setCaption("Days to Release");
    $DaysToRelease->setVersion("10200");
    $DaysToRelease->setTimezone("Asia/Kolkata");
    $DaysToRelease->setURL("https://razorflow.atlassian.net/");

    $issuesCount = new IssuesCount('ic');
    $issuesCount->setCredentialsObject($cred);
    $issuesCount->setDimensions(4,4);
    $issuesCount->setCaption("number of Issues");
    $issuesCount->setProjectID("10000");
    $issuesCount->setURL("https://razorflow.atlassian.net/");

    $this->addComponent ($progPie);
    $this->addComponent ($DaysToRelease);
    $this->addComponent ($issuesCount);
  }
}

$db = new JiraProgressDashboard ();
$db->renderStandalone();

?>