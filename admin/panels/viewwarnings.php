<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/logs.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_users_tab")){
        echo "<script>window.close()</script>";
    }
    if(!$_GET["id"]){
        echo "<script>window.close()</script>";
    }
    @$account = get_account_by_id($_GET["id"]);
	if(!$account){
		echo "<script>window.close()</script>";
	}else{
		$displayName = get_account_display_name($account->id);
		$usertag = get_usertag_by_id($account->tag);
	}
?>

<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/font-awesome.css" rel="stylesheet">

<style>
    .main_body_div{
        width: 100%;
        height: 100%;
    }
</style>

<span id="getid" style="display:none;"><?phpecho $account->id?></span>
<div class="main_body_div">
    <table id="main_table" class="table table-hover">
        <thead>
            <tr class="header">
                <th>Warned by</th>
                <th>Time issued</th>
                <th>Warning message</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach(get_user_warnings($account->id) as $key=>$value){
                    if($value){
                        $remove_warning_string = "";
                        if(tag_has_permission(get_current_usertag(), "userspnl_remove_warning")){
                            $remove_warning_string = "<td><button class='btn btn-danger remove_warning' data-id='$key'><span class='fa fa-times'></span></button></td>";
                        }

                        echo "
                            <tr class='table_row'>
                                <td>".get_account_display_name($value->warnedby)."</td>
                                <td>".timestamp_to_date($value->time, true)."</td>
                                <td>$value->message</td>
                                $remove_warning_string
                            </tr>
                        ";
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    $(".remove_warning").click(function(){
        $.post("/admin/requests/removewarning", {userid: $("#getid").html(), warningid: $(this).data("id")}, function(html){
            location.reload()
        })
    })
</script>
