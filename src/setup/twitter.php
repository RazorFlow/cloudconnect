<?php
if(isset($_POST['clientID'])) {
	// TODO: Do the hybridauth thingie
	require_once("hybridauth/Hybrid/Auth.php");
	$config = array(
		"base_url" => "http://localhost:8080/hybridauth/",
		"providers" => array (
			"Twitter" => array (
				"enabled" => true,
				"keys" => array("key" => $_POST['clientID'], "secret" => $_POST['clientSecret']),
				"access_type" => "offline"
			)
		)
	);

	$hybridauth = new Hybrid_Auth( $config );
 	$adapter = $hybridauth->authenticate( "Twitter" );
 	$access_token = $adapter->getAccessToken();
 	$access_token_secret = $adapter->token('access_token_secret');
 	
 	if($access_token) {
 		$access_token_str = $access_token["access_token"];
 		$access_token_secret_str = $access_token_secret;
 		$consumer_key_str = $_POST['clientID'];
 		$consumer_secret_key_str = $_POST['clientSecret'];
 		$done_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?done=true&access_token=$access_token_str&access_token_secret=$access_token_secret_str";
 		$done_url .= "&consumer_key=$consumer_key_str&consumer_secret_key=$consumer_secret_key_str";
 		header('Location: '. $done_url);
 		die();
 	} else {
 		echo("Failed to Authenticate");
 		die();
 	}
	
}
else if(isset($_GET['done'])) {
	require "layout/header.php"; ?>
<div class="container">
	<div class="row">
	<p>Copy and paste the following code to create a credentials object;
	<pre>$cred = new TwitterCredentials();
$cred->setConsumerKey ("<?php echo $_GET['consumer_key']; ?>");
$cred->setConsumerSecret("<?php echo $_GET['consumer_secret_key']; ?>");
$cred->setAccessToken("<?php echo $_GET['access_token']; ?>");
$cred->setAccessTokenSecret("<?php echo $_GET['access_token_secret']; ?>");</pre>
	</div>
</div>
<?php require "layout/footer.php"; 
}
else {
	require "layout/header.php"; 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>RazorFlow Bridge Helpers <small>Twitter</small></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Instructions:</h3>
			<ol>
				<li>Visit <a href="https://apps.twitter.com/">Twitter Developer Page</a>.</li>
				<li>Click on 'Create New App' or select an App, and skip to step 6 if you already have one.</li>
				<li>Enter Application Name, Description and your Website URL.</li>
				<li>Set the Callback URL to 'http://path/to/razorflow/src/setup/hybridauth?hauth.done=Twitter'</li>
				<li>Create the application.</li>
				<li>Click on manage API Keys.</li>
				<li>Paste the API Key and API Secret into the form below</li>
			</ol>
			<p>For more instructions visit <a href="#">This Link</a></p>

			<h3>Values</h3>
			<ol>
				<li>Authorized Redirect URIs: <code><?php echo("http://$_SERVER[HTTP_HOST]/hybridauth?hauth.done=Twitter"); ?></code></li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Setup:</h3>
			<p>Note: <b>No secret information about the client ID and email will be stored on the server. They're temporarily used to generate the access token</b></p>
			<form class="form-horizontal" role="form" method="post" action="twitter.php">
				<div class="form-group">
					<label for="clientID" class="col-sm-2 control-label">Client ID</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientID" placeholder="Client ID" name="clientID">
					</div>
				</div>
				<div class="form-group">
					<label for="clientSecret" class="col-sm-2 control-label">Client Secret</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientSecret" placeholder="Client Secret" name="clientSecret">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>


</div>
<?php require "layout/footer.php";
}
?>