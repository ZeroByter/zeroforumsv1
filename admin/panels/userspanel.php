<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_users_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #users_usertags_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .users_usertag_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .users_usertag_list_div:hover, .row_active{
        background: #dddddd;
    }

    #users_main_div{
        float: left;
        height: calc(100% - 42px);
        width: calc(100% - 150px);
    }
    #users_main_table{
        font-size: 12px;
    }
    #users_main_table tr:not(.header):hover, tr.row_active{
        background: #dddddd;
        cursor: pointer;
    }
</style>

<div id="users_usertags_list_div">
    <center><br><span class="glyphicon glyphicon-tags"></span> User tags</center>
    <br>
    <?php
        foreach(get_all_usertags_limited() as $value){
            if($value){
                echo "
                    <div class='users_usertag_list_div' data-id='$value->id'>
                        $value->name
                    </div>
                ";
            }
        }
    ?>
</div>
<div id="users_main_div">
    <div id="users_actions_div">
    </div>
    <span id="fillin_users"></div>
</div>

<script>
    var selectedUsertag
    $(".users_usertag_list_div").click(function(){ //when user clicks on one of the usertags
        $(".users_usertag_list_div").each(function(i, v){
            $(v).removeClass("row_active")
        })
        $(this).addClass("row_active")
        selectedUsertag = this
        $.get("/admin/fillin/users", {usertag: $(this).data("id")}, function(html){
            $("#fillin_users").html(html)
        })
    })

    function redo_users_panel(){
        $.get("/admin/fillin/users", {usertag: $(selectedUsertag).data("id")}, function(html){
            $("#fillin_users").html(html)
        })
    }
</script>
