<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/register.css" rel="stylesheet">

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_center_space">
                <div id="register_div" class="panel panel-primary">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form onsubmit="return false">
                            <div class="form-group">
    							<label for="username_in">Username: <span class="label label-danger" id="username_warning"></span></label>
    							<input type="text" class="form-control" id="username_in" placeholder="Username">
    						</div>
                            <div class="form-group">
    							<label for="password_in">Password: <span class="label label-danger" id="password_warning"></span></label>
    							<input type="password" class="form-control" id="password_in">
    						</div>
                            <div class="form-group">
    							<label for="password_confirm_in">Confirm password:</label>
    							<input type="password" class="form-control" id="password_confirm_in">
    						</div>
                            <center>Optional:<br><br></center>
							<div class="form-group">
    							<label for="displayname_in">Display name:</label>
    							<input type="text" class="form-control" id="displayname_in" data-toggle="tooltip" data-placement="right" title="You can leave this empty if you would like. If you choose to not use a display name, your username will be used to identify you instead. (You can change this later at any time)">
    						</div>
                            <div class="form-group">
    							<label for="email_in">Email:</label>
    							<input type="email" class="form-control" id="email_in" placeholder="Email" data-toggle="tooltip" data-placement="right" title="Giving us your email is not crucial. As for the current time we won't send you any email notifications what so ever. But we might in the future, so if you are interested you can input your email here.">
    						</div>
                            <center>
								<span class="label label-danger" id="final_warning"></span><br><br>
    							<button type="submit" class="btn btn-primary" id="register_submit">Register</button>
    						</center>
                        </form>
                    </div>
                </div>
			</td>
		</tr>
	</table>
</div>

<script src="/jsscripts/register.js"></script>
