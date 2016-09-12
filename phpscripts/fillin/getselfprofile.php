<?
	include("../getsql.php");
	include("../accounts.php");

	$callerurl = "/";
	if(isset($_GET["callerurl"])){
		$callerurl = $_GET["callerurl"];
	}
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<?echo (false) ? "Profile" : "Login";?>
	</div>
	<div class="panel-body">
		<div id="profile_login_div">
			<center>
				<a href="/login?next=<?echo $callerurl;?>"><button type="button" class="btn btn-default">Login</button></a>
				<a href="/register"><button type="button" class="btn btn-default">Register</button></a>
			</center>
		</div>
		<div id="profile_view_div">
			<center>
				<button type="button" class="btn btn-default">View profile</button>
				<a href="/phpscripts/requests/logout?next=<?echo $callerurl;?>"><button type="button" class="btn btn-default">Logout</button></a>
			</center>
		</div>
		<?
			$isvalid = false;
			if(isset($_COOKIE["sessionid"])){
				if(get_account_by_sessionid($_COOKIE["sessionid"]) != null){
					$isvalid = true;
				}
			}else{
				$isvalid = false;
			}
			echo "<script>";
			echo ($isvalid) ? "$('#profile_login_div').remove()" : "$('#profile_view_div').remove()";
			echo "</script>";
		?>
	</div>
</div>
