<?php

require "../../rfphp/razorflow.php";
require "../../lib/mixpanel/MixpanelCredentials.php";
require "../../lib/mixpanel/TrendsCount.php";
require "../../vendor/autoload.php";

class MixpanelDashboard extends StandaloneDashboard {
  public function buildDashboard () {
    $this->setDashboardTitle("Mixpanel Events Dashboard");

    $cred = new MixpanelCredentials ();
    $cred->setAPIKey("adc70f1d915b1506418d4facbdbe2a56");
    $cred->setAPISecret("cb7afce7a13288009917a7920508f190");

    $trendsCount = new TrendsCount ('tc');
    $trendsCount->setCredentialsObject($cred);
    $trendsCount->setDimensions(4,4);
    $trendsCount->setCaption("Demo Views in Last Month");
    $trendsCount->setEvent('["Demo Viewed"]', "general");
    $trendsCount->setTimePeriod("month", "1");

    $this->addComponent ($trendsCount);
  }
}

$db = new MixpanelDashboard ();
$db->renderStandalone();

?>