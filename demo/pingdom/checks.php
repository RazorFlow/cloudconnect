<?php

require "../../rfphp/razorflow.php";
require "../../lib/pingdom/PingdomCredentials.php";
require "../../lib/pingdom/OpenIncidentsKPI.php";
require "../../vendor/autoload.php";

class NumIncidentsDashboard extends StandaloneDashboard {
	public function buildDashboard () {
		$this->setDashboardTitle ("Pingdom Dashboard");

		$cred = new PingdomCredentials('oi');
		$cred->setAPIKey ("85i4kkl8nnn3w1r7uspukc2em0b2sfe0");

		$oiKPI = new OpenIncidentsKPI('oi');
		$oiKPI->setCredentialsObject ($cred);
		$oiKPI->setDimensions (4, 4);
		$oiKPI->setCaption ("Checks Left");
		$this->addComponent ($oiKPI);
	}
}

$db = new NumIncidentsDashboard ();
$db->renderStandalone ();

?>