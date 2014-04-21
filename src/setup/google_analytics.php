<?php
if(isset($_POST['clientID'])) {
	// TODO: Do the hybridauth thingie
	require_once("hybridauth/Hybrid/Auth.php");
	$config = array(
		"base_url" => "http://$_SERVER[HTTP_HOST]/hybridauth/",
		"providers" => array (
			"Google" => array (
				"enabled" => true,
				"keys" => array("id" => $_POST['clientID'], "secret" => $_POST['clientSecret']),
				"access_type" => "offline"
			)
		)
	);

	$hybridauth = new Hybrid_Auth( $config );
 	$adapter = $hybridauth->authenticate( "Google" );
 	$access_token = $adapter->getAccessToken();

 	if($access_token) {
 		$access_token_str = $access_token["access_token"];
 		$done_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?done=true&access_token=$access_token_str";
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
	<pre>$cred = new GoogleAnalyticsCredentials();
$cred->setAccessToken ("<?php echo $_GET['access_token']; ?>);</pre>
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
			<h1>RazorFlow Bridge Helpers <small>Google Analytics</small></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Instructions:</h3>
			<ol>
				<li>Visit <a href="https://console.developers.google.com/">Google Developer Console</a>. </li>
				<li>Click on 'Create Project' or select a project, and skip to step 4 if you already have one.</li>
				<li>Enter a name and ID for the project.</li>
				<li>Click on APIs &amp; auth in the sidebar, and select APIs. Turn on the Analytics API.</li>
				<li>Now click on credentials from the sidebar, and click on 'Create New Client ID'.</li>
				 <ol>
					<li>Set the Application type to 'Web Application'.</li>
					<li>Set the Authorized JavaScript origins to 'http://path/to/razorflow/src/setup'.</li>
					<li>Set the Authorized redirect URI to 'http://path/to/razorflow/src/setup/hybridauth?hauth.done=Google'.</li>
				</ol>
				<li>Copy your Client ID, Client Secret, and paste them in the form below.</li>
			</ol>
			<p>For more instructions visit <a href="#">This Link</a></p>

			<h3>Values</h3>
			<ol>

				<li>Authorized Redirect URIs: <code><?php echo("http://$_SERVER[HTTP_HOST]/hybridauth?hauth.done=Google") ?></code></li>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Setup:</h3>
			<p>Note: <b>No secret information about the client ID and email will be stored on the server. They're temporarily used to generate the access token</b></p>
			<form class="form-horizontal" role="form" method="post" action="google_analytics.php">
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