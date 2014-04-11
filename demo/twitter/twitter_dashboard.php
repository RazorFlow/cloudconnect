<?php

require "../../rfphp/razorflow.php";
require "../../lib/twitter/TwitterCredentials.php";
require "../../lib/twitter/TwitterFollowersKPI.php";
require "../../lib/twitter/TwitterFollowingKPI.php";
require "../../vendor/autoload.php";

class TwitterDashboard extends StandaloneDashboard {
	public function buildDashboard () {
		$this->setDashboardTitle ("Twitter");

		$cred = new TwitterCredentials();
		$cred->setConsumerKey ("mVsbx41nd0PjSMOdw8NHw");
		$cred->setConsumerSecret("TyGHJa4szEUxrpywTYGn1aiyOXGfI8aLLxsePrekaw");
		$cred->setAccessToken("733429656-xcATA7WmWHCYQnMxxdQskKgEqdMMDxSFzDy651P3");
		$cred->setAccessTokenSecret("svxAGVSEwfY4MMq3lTJ3BPaUoKjmjsZQXf4qM7p4Vs");


		$tfKPI = new TwitterFollowersKPI ('tf');
		$tfKPI->setCredentialsObject ($cred);
		$tfKPI->setDimensions (4, 4);
		$tfKPI->setCaption ("Followers");
		$tfKPI->setUsername("selwynjacob90");
		$this->addComponent ($tfKPI);

		$tKPI = new TwitterFollowingKPI ('t');
		$tKPI->setCredentialsObject ($cred);
		$tKPI->setDimensions (4, 4);
		$tKPI->setCaption ("Following");
		$tKPI->setUsername("selwynjacob90");
		$this->addComponent ($tKPI);
	}
}

$db = new TwitterDashboard ();
$db->renderStandalone ();

?>