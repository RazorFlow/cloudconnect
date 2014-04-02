<?php

require "../../rfphp/razorflow.php";
require "../../lib/campaignmonitor/CampaignMonitorCredentials.php";
require "../../lib/campaignmonitor/SubscriberCountKPI.php";
require "../../vendor/autoload.php";

class NumSubscribersDashboard extends StandaloneDashboard {
	public function buildDashboard () {
		$this->setDashboardTitle ("Campaign Monitor Dashboard");

		$cred = new CampaignMonitorCredentials();
		$cred->setAPIKey ("67efd612dcbda0acf20657dbe226566b36f2d3f312b5b8b3");

		$scKPI = new SubscriberCountKPI ('sc');
		$scKPI->setCredentialsObject ($cred);
		$scKPI->setDimensions (4, 4);
		$scKPI->setCaption ("Number of Subscribers");
		$scKPI->setListID ("550620f85f767592c498318ee04e6dd7");
		$this->addComponent ($scKPI);
	}
}

$db = new NumSubscribersDashboard ();
$db->renderStandalone ();

?>