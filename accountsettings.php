<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/essentials.php");
	include("phpscripts/accounts.php");
	include("phpscripts/usertags.php");
	include("phpscripts/checkwarnings.php");
?>

<style>
	.settings_div{
		padding: 10px;
		border-left: 1px solid #dddddd;
		border-right: 1px solid #dddddd;
	}

	.settings_input_group{
		width: 25%;
	}
	.input-group{
		margin-bottom: 4px;
	}

	#confirm_login_div{
		position: absolute;
		left: 0px;
		top: 0px;
		background: rgba(62, 62, 62, 0.6);
		width: 100%;
		height: 100%;
		z-index: 10;
	}

	#confirm_login_panel{
		max-width: 400px;
		margin: 100px auto;
	}

	#privacysettings_div{
		padding-left: 40px;
	}

	.output_label{
		margin-bottom: 10px;
		display: inline-block;
	}
</style>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space" style="display:none;">

			</td>
			<td id="body_center_space">
				<ul class="nav nav-tabs">
					<li role="presentation" class="tabs_bar_item active" data-id="#pinfo_div"><a href="javascript:void(0)">Personal information</a></li>
					<li role="presentation" class="tabs_bar_item" data-id="#privacysettings_div"><a href="javascript:void(0)">Privacy settings</a></li>
				</ul>
				<div id="pinfo_div" class="settings_div">
					<center>
						<h4>Change new display name</h4>
						<span id="new_diplayname_label" class="output_label label label-default"></span>
						<div class="input-group settings_input_group">
							<span class="input-group-addon">New display name</span>
							<input type="text" class="form-control" id="new_displayname_in">
						</div>
						<button type="button" class="btn btn-success" id="new_displayname_btn">Change new display name</button><br><br>

						<h4>Change new password</h4>
						<span id="new_password_label" class="output_label label label-default"></span>
						<div class="input-group settings_input_group">
							<span class="input-group-addon">New password</span>
							<input type="password" class="form-control" id="new_password_in1">
						</div>
						<div class="input-group settings_input_group">
							<span class="input-group-addon">Confirm password</span>
							<input type="password" class="form-control" id="new_password_in2">
						</div>
						<button type="button" class="btn btn-success" id="new_password_btn">Change new password</button><br><br>

						<h4>Change new email</h4>
						<span id="new_email_label" class="output_label label label-default"></span>
						<div class="input-group settings_input_group">
							<span class="input-group-addon">New email</span>
							<input type="email" class="form-control" id="new_email_in">
						</div>
						<button type="button" class="btn btn-success" id="new_email_btn">Change new email</button><br><br>
					</center>
				</div>
				<div id="privacysettings_div" class="settings_div" style="display:none">
					<h4>Profile privacy settings:</h4>
					<div class="checkbox">
						<label><input type="checkbox" id="show_email_in">Show my email on my profile page?</label>
					</div><br>
					<h4>General privacy settings:</h4>
					<form>
						<div class="radio">
							<label><input type="radio" name="op1" id="privacy_use_displayname">Show my display name through out the website</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="op1" id="privacy_use_username">Show my username through out the website</label>
						</div>
					</form>
					<span id="change_privacysettings_label" class="output_label label label-default"></span><br>
					<button type="button" class="btn btn-success" id="update_privacy_settings">Update privacy settings</button>
				</div>
			</td>
			<td id="body_right_space" style="display:none;">

			</td>
		</tr>
	</table>
</div>

<div id="confirm_login_div" style="display:block;">
	<div class="panel panel-default" id="confirm_login_panel">
		<div class="panel-heading">Login</div>
		<div class="panel-body">
			<div class="input-group">
				<span class="input-group-addon">Username</span>
				<input type="text" autocomplete="nope" class="form-control" id="confirm_login_username_in">
			</div>
			<div class="input-group">
				<span class="input-group-addon">Password</span>
				<input type="password" autocomplete="nope" class="form-control" id="confirm_login_password_in">
			</div>
			<center>
				<button type="button" class="btn btn-success" id="confirm_login_btn">Confirm login</button>
				<button type="button" class="btn btn-danger" id="cancel_login_btn">Cancel</button>
			</center>
		</div>
	</div>
</div>

<script>
	var check_username = ""
	var check_password = ""

	$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
		$("#fillin_navbar").html(content)
	})
	$(".tabs_bar_item").click(function(){
		$(".tabs_bar_item").removeClass("active")
		$(this).addClass("active")
		var id = $(this).data("id")
		$(".settings_div").css("display", "none")
		$(id).css("display", "block")
	})

	$("#confirm_login_btn").click(function(){
		check_username = $("#confirm_login_username_in").val()
		check_password = $("#confirm_login_password_in").val()
		$.get("/phpscripts/requests/getaccountsettings", {username: check_username, password: check_password}, function(html){
			var results = JSON.parse(html)
			if(results.correct == true){
				console.log(results)
				$("#new_displayname_in").val(results.displayname)
				$("#new_email_in").val(results.email)
				if(results.show_email == true){
					$("#show_email_in").attr("checked", "")
				}
				if(results.use_displayname == true){
					$("#privacy_use_displayname").attr("checked", "")
				}else{
					$("#privacy_use_username").attr("checked", "")
				}
				$("#confirm_login_div").remove()
			}else{
				alert("Incorrect username and/or password")
			}
		})
	})
	$("#cancel_login_btn").click(function(){
		window.location = "/"
	})

	$("#new_displayname_btn").click(function(){
		$.post("/phpscripts/requests/changedisplayname", {username: check_username, password: check_password, displayname: $("#new_displayname_in").val()}, function(html){
			if(html.startsWith("error:")){
	            $("#new_diplayname_label").html(html.split(":")[1])
	        }
	        if(html == "success"){
	            $("#new_diplayname_label").html("display name changed!")
	        }
		})
	})

	$("#new_password_btn").click(function(){
		var password1 = $("#new_password_in1").val()
		var password2 = $("#new_password_in2").val()
		if(password1 == password2){
			if(password1.length >= 4){
				$.post("/phpscripts/requests/changepassword", {username: check_username, password: check_password, newpassword: $("#new_password_in1").val()}, function(html){
					console.log(html)
					if(html.startsWith("error:")){
			            $("#new_password_label").html(html.split(":")[1])
			        }
			        if(html == "success"){
			            $("#new_password_label").html("password changed!")
			        }
				})
			}else{
				alert("Password must be longer than 4 charachters!")
			}
		}else{
			alert("Passwords are not the same")
		}
	})

	$("#new_email_btn").click(function(){
		$.post("/phpscripts/requests/changeemail", {username: check_username, password: check_password, newemail: $("#new_email_in").val()}, function(html){
			if(html.startsWith("error:")){
				$("#new_email_label").html(html.split(":")[1])
			}
			if(html == "success"){
				$("#new_email_label").html("email changed!")
			}
		})
	})

	$("#update_privacy_settings").click(function(){
		var show_email = $("#show_email_in").prop("checked")
		var use_displayname = true
		if($("#privacy_use_displayname").prop("checked") == true){
			use_displayname = true
		}else{
			use_displayname = false
		}

		$.post("/phpscripts/requests/changeprivacy", {username: check_username, password: check_password, show_email: show_email, use_displayname: use_displayname}, function(html){
			console.log(html)
			if(html.startsWith("error:")){
				$("#change_privacysettings_label").html(html.split(":")[1])
			}
			if(html == "success"){
				$("#change_privacysettings_label").html("privacy settings changed!")
			}
		})
	})
</script>
