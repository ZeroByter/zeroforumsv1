<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/login.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/usertags.php");
?>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space">
				<span id="fillin_selfprofile"></span>
			</td>
			<td id="body_center_space">
				<div class="panel panel-primary" style="max-width: 500px; margin: 0 auto;">
					<div class="panel-heading">Login</div>
					<div class="panel-body">
						<form onsubmit="return false">
							<div class="form-group">
								<label for="username_in">Username or email:</label>
								<input type="text" class="form-control" id="username_in" placeholder="Username or email">
							</div>
							<div class="form-group">
								<label for="password_in">Password:</label>
								<input type="password" class="form-control" id="password_in" placeholder="Password">
							</div>
							<center>
								<span class="label label-danger" id="final_warning"></span><br><br>
								<button type="submit" class="btn btn-primary" id="login_submit"><span class="glyphicon glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</button>
							</center>
						</form>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<script src="/jsscripts/login.js"></script>
