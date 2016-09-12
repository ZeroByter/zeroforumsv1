<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">

<?
    include("../phpscripts/getsql.php");
    include("../phpscripts/accounts.php");
    include("../phpscripts/usertags.php");

    if(!can_tag_do(get_current_usertag(), "staff")){ //does the user's tag enable him to see this admin page
        echo "<script>window.close()</script>";
    }
?>

<!-- WARNING!!! This admin panel page IS GOING TO BE A COMPLETE MESS!!! I am too lazy to organize this one page which not many users will see anyways. Maybe later when everything else is done? !-->

<style>

</style>

<ul class="nav nav-tabs">
    <li role="presentation" id="forums_tab" class="navbar_link"><a href="javascript:void(0)">Forums</a></li>
    <li role="presentation" id="users_tab" class="navbar_link"><a href="javascript:void(0)" data-url="panels/userspanel">Users</a></li>
    <li role="presentation" id="usertags_tab" class="navbar_link"><a href="javascript:void(0)">User tags</a></li>
    <li role="presentation" id="permissions_tab" class="navbar_link"><a href="javascript:void(0)" data-url="panels/permissionspanel">Permissions</a></li>
    <li role="presentation" id="navigation_tab" class="navbar_link"><a href="javascript:void(0)" data-url="panels/navgiationpanel">Navigation bar</a></li>
</ul>

<?
    if(!tag_has_permission(get_current_usertag(), "adminpnl_forums_tab")){
        echo "<script>$('#forums_tab').remove()</script>";
    }
    if(!tag_has_permission(get_current_usertag(), "adminpnl_users_tab")){
        echo "<script>$('#users_tab').remove()</script>";
    }
    if(!tag_has_permission(get_current_usertag(), "adminpnl_usertags_tab")){
        echo "<script>$('#usertags_tab').remove()</script>";
    }
    if(!tag_has_permission(get_current_usertag(), "adminpnl_permissions_tab")){
        echo "<script>$('#permissions_tab').remove()</script>";
    }
    if(!tag_has_permission(get_current_usertag(), "adminpnl_navigation_tab")){
        echo "<script>$('#navigation_tab').remove()</script>";
    }
?>

<span id="fillin_panel"></span>

<script>
    $(".navbar_link").click(function(){ //select and highlight when a link from the navbar is clicked
        $(".navbar_link").each(function(i, v){
            $(v).removeClass("active")
        })
        $(this).addClass("active")

        $(".panel_span").each(function(i, v){
            $(v).html("")
        })

        if($($(this).find("a")).data("url") != undefined){
            $.get($($(this).find("a")).data("url"), function(html){
                $("#fillin_panel").html(html)
            })
        }else{
            $("#fillin_panel").html("<br><br><center style='color:red;'>Sorry, dude. We didn't find the panel for this tab!<br>:(</center>")
        }
    })
</script>
