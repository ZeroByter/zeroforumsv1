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
                <button type="button" disabled class="btn btn-warning navbar-btn users_actions_btn">Warn user</button>
                <button type="button" disabled class="btn btn-danger navbar-btn users_actions_btn">Ban user</button>
			</ul>
		</div>
	</div>
</nav>
<table id="users_main_table" class="table table-bordered">
    <thead>
        <tr class="header">
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
                    echo "
                        <tr class='users_list_row' data-id='$value->id'>
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

<script>
    var selectedUser
    $(".users_list_row").click(function(){ //when user clicks on user in userslist
        $(".users_list_row").each(function(i, v){
            $(v).removeClass("row_active")
        })
        $(this).addClass("row_active")
        selectedUser = this

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
</script>
