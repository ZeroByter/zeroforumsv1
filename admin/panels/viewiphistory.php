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

<style>
    #side_list_div{
        width: 150px;
        height: calc(100%);
        border-right: 1px solid #dddddd;
        float: left;
    }
    .main_body_div{
        width: calc(100% - 150px);
        height: 100%;
        float: left;
    }

    .side_list_item_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .side_list_item_div:hover, .row_active{
        background: #dddddd;
    }

    #same_ip_accounts_div{
        padding: 30px;
    }
    .same_ip_account_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .same_ip_account_list_div:hover{
        background: #dddddd;
    }
</style>

<div id="side_list_div">
    <center><br>'<?phpecho $displayName?>' IP history</center>
    <br><br>
    <div class='side_list_item_div row_active' id="ip_history">Account IP history</div>
    <div class='side_list_item_div' id="same_ip_list">Other accounts with the same IP</div>
</div>
<div id="ip_list_div" class="main_body_div">
    <table id="main_table" class="table table-hover">
        <thead>
            <tr class="header">
                <th>IP</th>
                <th>First seen</th>
                <th>Last seen</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach(get_user_iplist($account->id) as $value){
                    if($value){
                        echo "
                            <tr class='table_row'>
                                <td>$value->ip</td>
                                <td>".timestamp_to_date($value->firstseen, true)."</td>
                                <td>".timestamp_to_date($value->lastseen, true)."</td>
                            </tr>
                        ";
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<div id="same_ip_accounts_div" class="main_body_div" style="display:none;">
    <?php
        $all_same_ip_accounts = get_all_same_ip_accounts($account->id, $account->id);
        foreach($all_same_ip_accounts as $value){
            echo "<div class='same_ip_account_list_div' data-id='$value->id'>".get_account_display_name($value->id)."</div>";
        }
        if(count($all_same_ip_accounts) == 0){
            echo "<center><h4>No other accounts with the same IP!</h4></center>";
        }
    ?>
</div>

<script>
    $("#ip_history").click(function(){
        $("#same_ip_list").removeClass("row_active")
        $(this).addClass("row_active")
        $("#ip_list_div").css("display", "block")
        $("#same_ip_accounts_div").css("display", "none")
    })
    $("#same_ip_list").click(function(){
        $("#ip_history").removeClass("row_active")
        $(this).addClass("row_active")
        $("#ip_list_div").css("display", "none")
        $("#same_ip_accounts_div").css("display", "block")
    })
    $(".same_ip_account_list_div").click(function(){
        window.location = "/admin/panels/viewiphistory?id=" + $(this).data("id")
    })
</script>
