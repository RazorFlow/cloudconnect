<?php require "layout/header.php"; ?>
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
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>Setup:</h3>
			<p>Note: <b>No secret information about the client ID and email will be stored on the server. They're temporarily used to generate the access token</b></p>
			<form class="form-horizontal" role="form" method="post" action=".">
				<div class="form-group">
					<label for="clientID" class="col-sm-2 control-label">Client ID</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientID" placeholder="Client ID" name="clientID">
					</div>
				</div>
				<div class="form-group">
					<label for="clientEmail" class="col-sm-2 control-label">Email Address</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="clientEmail" placeholder="Email" name="clientEmail">
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
<?php require "layout/footer.php"; ?>