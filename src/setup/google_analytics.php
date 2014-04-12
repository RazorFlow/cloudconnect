<?php
if(isset($_POST['clientID'])) {
	// TODO: Do the hybridauth thingie
	echo $_POST['clientID'];
	echo $_POST['clientSecret'];

	
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