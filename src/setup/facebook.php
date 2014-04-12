<?php
if(isset($_POST['clientID'])) {
	// TODO: Do the hybridauth thingie
	require_once("hybridauth/Hybrid/Auth.php");
	$config = array(
		"base_url" => "http://localhost:8080/hybridauth/",
		"providers" => array (
			"Facebook" => array (
				"enabled" => true,
				"keys" => array("id" => $_POST['clientID'], "secret" => $_POST['clientSecret']),
				"scope" => "manage_pages"
			)
		)
	);

	$hybridauth = new Hybrid_Auth( $config );
 	$adapter = $hybridauth->authenticate( "Facebook" );

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
	<pre>$cred = new FacebookCredentials();
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
			<h1>RazorFlow Bridge Helpers <small>Facebook</small></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Instructions:</h3>
			<ol>
				<li>Step 1</li>
				<li>Step 2</li>
			</ol>
			<p>For more instructions visit <a href="#">This Link</a></p>

			<h3>Values</h3>
			<ol>

				<li>Authorized Redirect URIs: <code><?php //TODO: Selwyn echo $_SERVER['REQUEST_URI']; ?>http://foo</code></li>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Setup:</h3>
			<p>Note: <b>No secret information about the client ID and email will be stored on the server. They're temporarily used to generate the access token</b></p>
			<form class="form-horizontal" role="form" method="post" action="facebook.php">
				<div class="form-group">
					<label for="clientID" class="col-sm-2 control-label">App ID</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientID" placeholder="App ID" name="clientID">
					</div>
				</div>
				<div class="form-group">
					<label for="clientSecret" class="col-sm-2 control-label">App Secret</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientSecret" placeholder="App Secret" name="clientSecret">
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