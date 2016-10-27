<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");

    $usertag = get_usertag_by_id($_GET["id"]);
?>

<style>
    #usertag_main_div{
        width: 80%;
        margin: 0px auto;
    }
</style>

<span id="getinfo" data-id="<?phpecho $usertag->id?>" data-name="<?phpecho $usertag->name?>" data-listorder="<?phpecho $usertag->listorder?>" data-isstaff="<?phpecho $usertag->isstaff?>"></span>
<div id="usertag_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Name</span>
            <input type="text" class="form-control" id="usertag_name_in" value="<?phpecho $usertag->name?>">
        </div>
        <div class="input-group">
            <span class="input-group-addon" data-toggle='tooltip' data-placement='bottom' title='In what order should this usertag be sorted?'>The usertag order</span>
            <input type="number" class="form-control" id="usertag_listorder_in" value="<?phpecho $usertag->listorder?>">
        </div>
        <div class="checkbox" data-toggle="tooltip" title="Is this usertag considered a staff usertag? If so, it will be shown in the 'staff' page.">
            <label><input type="checkbox" id="usertag_isstaff_in">Is this usertag a staff usertag?</label>
        </div>
        <button type="button" class="btn btn-danger" style="width:100%;" id="delete_usertag" data-toggle="tooltip" title="If you delete this usertag, all users in it will be switched to the default usertag!">Delete</button>
        <button type="button" class="btn btn-default" style="width:100%;margin-top:6px;" id="make_default_usertag">Make this usertag the default usertag</button><br><br>
        <span style="text-align:center;display:block;font-size:14px;" class="label label-info" data-toggle='tooltip' title="You must go to the 'permissions' tab to set the permissions for any created usertag">Where can I set the permissions for my usertag?</span>
        <?php
            if($usertag->isdefault){
                echo "<script>$('#delete_usertag').attr('disabled', '').html('You can\'t delete the default usertag!')</script>";
                echo "<script>$('#make_default_usertag').attr('disabled', '').html('This usertag is already the default!')</script>";
            }
            if($usertag->isstaff){
                echo "<script>$('#usertag_isstaff_in').attr('checked', '')</script>";
            }
        ?>
    </div>
</div>

<?php
    if(!tag_has_permission(get_current_usertag(), "usertagpnl_create_usertag")){
        removeHTMLElement("#delete_usertag");
    }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    var usertagid = $("#getinfo").data("id")
    var name = $("#getinfo").data("name")
    var listorder = $("#getinfo").data("listorder")
    var isstaff = $("#getinfo").data("isstaff")

    function updateusertag(){
        $.post("/admin/requests/updateusertag", {id: usertagid, name: name, listorder: listorder, isstaff: isstaff}, function(html){
            redo_usertaglist($(selectedUsertag).data("id"))
            redo_panel()
        })
    }

    $("#usertag_name_in").bind("change", function(){
        name = $("#usertag_name_in").val()
        updateusertag()
    })
    $("#usertag_listorder_in").bind("change", function(){
        listorder = $("#usertag_listorder_in").val()
        updateusertag()
    })
    $("#usertag_isstaff_in").click(function(){
        isstaff = $(this).prop("checked")
        updateusertag()
    })
    $("#delete_usertag").click(function(){
        $.post("/admin/requests/deleteusertag", {id: usertagid}, function(){
            $("#fillin_usertag").html("")
            redo_usertaglist()
            redo_panel()
        })
    })
    $("#make_default_usertag").click(function(){
        $.post("/admin/requests/setusertagdefault", {id: usertagid}, function(){
            $("#fillin_usertag").html("")
            redo_panel()
        })
    })
</script>
