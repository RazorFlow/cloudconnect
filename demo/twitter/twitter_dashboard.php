<?php

require "../../rfphp/razorflow.php";
require "../../src/lib/twitter/TwitterCredentials.php";
require "../../src/lib/twitter/TwitterFollowersKPI.php";
require "../../src/lib/twitter/TwitterFollowingKPI.php";
require "../../src/lib/twitter/TwitterListedKPI.php";
require "../../src/lib/twitter/TwitterRetweetedKPI.php";
require "../../src/lib/twitter/TwitterMentionsKPI.php";
require "../../src/lib/twitter/TwitterMentionsList.php";
require "../../src/lib/twitter/TwitterRetweetsList.php";
require "../../src/lib/twitter/TwitterKeywordList.php";
require "../../src/lib/twitter/TwitterHelper.php";
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
		$tfKPI->setDimensions (2, 2);
		$tfKPI->setCaption ("Followers");
		$tfKPI->setUsername("godgeez");
		$this->addComponent ($tfKPI);

		$tKPI = new TwitterFollowingKPI ('t');
		$tKPI->setCredentialsObject ($cred);
		$tKPI->setDimensions (2, 2);
		$tKPI->setCaption ("Following");
		$tKPI->setUsername("godgeez");
		$this->addComponent ($tKPI);

		$tlKPI = new TwitterListedKPI ('tl');
		$tlKPI->setCredentialsObject ($cred);
		$tlKPI->setDimensions (2, 2);
		$tlKPI->setCaption ("Listed");
		$tlKPI->setUsername("godgeez");
		$this->addComponent ($tlKPI);

		$trKPI = new TwitterRetweetedKPI ('tr');
		$trKPI->setCredentialsObject ($cred);
		$trKPI->setDimensions (2, 2);
		$trKPI->setCaption ("Retweeted");
		$this->addComponent ($trKPI);

		$tmKPI = new TwitterMentionsKPI ('tm');
		$tmKPI->setCredentialsObject ($cred);
		$tmKPI->setDimensions (2, 2);
		$tmKPI->setCaption ("Mentions");
		$this->addComponent ($tmKPI);

		$tmlList = new TwitterMentionsList ('tml');
		$tmlList->setCredentialsObject ($cred);
		$tmlList->setDimensions (4, 4);
		$tmlList->setCaption ("Twitter Mentions");
		$tmlList->addColumn('mentions', "");
		$this->addComponent ($tmlList);

		$trlList = new TwitterRetweetsList ('trl');
		$trlList->setCredentialsObject ($cred);
		$trlList->setDimensions (4, 4);
		$trlList->setCaption ("Twitter Retweets");
		$trlList->addColumn('retweets', "");
		$this->addComponent ($trlList);

		$tklList = new TwitterKeywordList ('tkl');
		$tklList->setCredentialsObject ($cred);
		$tklList->setDimensions (4, 4);
		$tklList->setCaption ("Twitter Keywords Search");
		$tklList->addColumn('searchList', "");
		$tklList->query('@noradio');
		$this->addComponent ($tklList);

	}
}

$db = new TwitterDashboard ();
$db->renderStandalone ();

?>