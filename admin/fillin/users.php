<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
?>

<style>
    .navbar .container-fluid, .navbar-collapse {
        padding-left:5;
    }

    #ban_prompt{
        position: absolute;
        width: 425px;
        left: 60%;
        margin-left: -212.5px;
        top: 160px;
    }
    #ban_prompt_close{
        color: white;
        float: right;
    }
</style>

<nav id="nav_bar" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_navbar_collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="main_navbar_collapse">
			<ul class="nav navbar-nav">
                <div class="btn-group navbar-btn">
                    <button type="button" disabled class="btn btn-default dropdown-toggle users_actions_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Assign new rank <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?
                            foreach(get_all_usertags_limited() as $value){
                                if($value){
                                    echo "<li><a href='javascript:void(0)' class='set_user_usertag' data-id='$value->id'>$value->name</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </div>
                <button type="button" disabled class="btn btn-warning navbar-btn users_actions_btn" id="warnuser">Warn user</button>
                <button type="button" disabled class="btn btn-danger navbar-btn users_actions_btn test" id="banuser">Ban user</button>
                <button type="button" disabled class="btn btn-default navbar-btn users_actions_btn" id="unbanuser">Unban user</button>
			</ul>
		</div>
	</div>
</nav>
<table id="users_main_table" class="table table-bordered">
    <thead>
        <tr class="header">
            <th>Is banned</th>
            <th>Is warned</th>
            <th>Joined</th>
            <th>Last active</th>
            <th>Username</th>
            <th>Display name</th>
            <th>Posts</th>
        </tr>
    </thead>
    <tbody>
        <?
            foreach(get_all_accounts_by_usertag($_GET["usertag"]) as $value){
                if($value){
                    $lastjoined = get_human_time($value->joined);
                    $lastactive = get_human_time($value->lastactive);
                    $isbanned = ($value->bannedby != 0) ? "Yes" : "No";
                    $isbannedraw = ($value->bannedby != 0) ? "true" : "false";
                    echo "
                        <tr class='users_list_row' data-id='$value->id' data-isbanned='$isbannedraw'>
                            <td>$isbanned</td>
                            <td>n/a</td>
                            <td>$lastjoined ago</td>
                            <td>$lastactive ago</td>
                            <td>$value->username</td>
                            <td>$value->displayname</td>
                            <td>$value->posts</td>
                        </tr>
                    ";
                }
            }
        ?>
    </tbody>
</table>

<div class="panel panel-primary" id="ban_prompt" style="display: none;">
    <div class="panel-heading">Ban prompt<a href="javascript:void(0)" id="ban_prompt_close">Close</a></div>
    <div class="panel-body">
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Ban reason</span>
        <input type="text" class="form-control" id="ban_prompt_reason_in">
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Ban time</span>
        <input type="number" class="form-control" value="1" id="ban_prompt_time_in" disabled>
        <select class="form-control" id="ban_prompt_time_type_in" disabled>
            <option>Minutes</option>
            <option>Hours</option>
            <option>Days</option>
            <option>Weeks</option>
            <option>Months</option>
            <option>Years</option>
        </select>
        </div><br>
        <center>
            <button type="button" class="btn btn-primary" id="ban_prompt_issue_ban" disabled>Issue ban</button>
            <button type="button" class="btn btn-default" id="ban_prompt_cancel">Cancel ban</button>
        </center>
    </div>
</div>

<script>
    var selectedUser
    $(".users_list_row").click(function(){ //when user clicks on user in userslist
        $(".users_list_row").each(function(i, v){
            $(v).removeClass("row_active")
        })
        $(this).addClass("row_active")
        selectedUser = this

        if($(this).data("isbanned") == true){
            $("#unbanuser").css("display", "block-inline")
            $("#banuser").css("display", "none")
        }else{
            $("#unbanuser").css("display", "none")
            $("#banuser").css("display", "block-inline")
        }

        $(".users_actions_btn").each(function(i, v){
            $(v).removeAttr("disabled")
        })
    })

    $(".set_user_usertag").click(function(){
        var userid = $(selectedUser).data("id")
        var usertagid = ($(this).data("id"))
        $.post("/admin/requests/setusertag", {userid: userid, usertagid: usertagid}, function(html){
            console.log(html)
            redo_users_panel()
        })
    })

    $("#warnuser").click(function(){
        var reason = prompt("Please state your reason for warning!")
        if(reason){
            $.post("/admin/requests/warnuser", {id: $(selectedUser).data("id"), reason: reason}, function(html){

            })
        }
    })

    $("#banuser").click(function(){
        $("#ban_prompt").css("display", "block")
    })

    $("#ban_prompt_close, #ban_prompt_cancel").click(function(){
    	$("#ban_prompt").css("display", "none")
    })

    var time = 1
    var timetype = "minutes"
    function get_real_time(){
    	if(timetype == "minutes"){
      	return time * 60
      }
      if(timetype == "hours"){
      	return time * 60 * 60
      }
      if(timetype == "days"){
      	return time * 60 * 60 * 24
      }
      if(timetype == "weeks"){
      	return time * 60 * 60 * 24 * 7
      }
      if(timetype == "months"){
      	return time * 60 * 60 * 24 * 7 * 4
      }
      if(timetype == "years"){
      	return time * 60 * 60 * 24 * 7 * 4 * 12
      }
    }

    $("#ban_prompt_reason_in").keyup(function(){
        if($(this).val() == ""){
            $("#ban_prompt_time_in").attr("disabled", "")
            $("#ban_prompt_time_type_in").attr("disabled", "")
            $("#ban_prompt_issue_ban").attr("disabled", "")
        }else{
            $("#ban_prompt_time_in").removeAttr("disabled", "")
            $("#ban_prompt_time_type_in").removeAttr("disabled", "")
            $("#ban_prompt_issue_ban").removeAttr("disabled", "")
        }
    })
    $("#ban_prompt_time_in").keyup(function(){
        time = $(this).val()
    })
    $("#ban_prompt_time_type_in").change(function(){
    	timetype = $(this).val().toLowerCase()
    })

    $("#ban_prompt_issue_ban").click(function(){
        $.post("/admin/requests/banuser", {id: $(selectedUser).data("id"), reason: $("#ban_prompt_reason_in").val(), time: get_real_time()}, function(html){
            console.log(html)
            $("#ban_prompt").css("display", "none")
        })
    })
</script>
