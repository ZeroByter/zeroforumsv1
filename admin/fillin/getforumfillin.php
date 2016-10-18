<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/essentials.php");

    $forum = get_forum_by_id($_GET["id"]);
?>

<style>
    #forum_main_div{
        width: 80%;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }

    .toggle_btn{
        border-style: none;
		border-radius: 8px;
		padding: 4px 6px;
		margin: 2px;
		outline: none;
		box-shadow: 1px 1px 3px;
    }
    .toggle_btn[data-state=false]{
		color: black;
		background: #FF4F4F;
	}
	.toggle_btn[data-state=true]{
		color: black;
		background: #00CC00;
	}
</style>

<span id="getinfo" data-id="<?echo $forum->id?>" data-name="<?echo $forum->name?>" data-posttext="<?echo $forum->posttext?>" data-listorder="<?echo $forum->listorder?>"></span>
<div id="forum_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Name</span>
            <input type="text" class="form-control" id="forum_name_in" value="<?echo $forum->name?>">
        </div>
        <div class="input-group">
            <span class="input-group-addon">Description</span>
            <input type="text" class="form-control" id="forum_posttext_in" value="<?echo $forum->posttext?>">
        </div>
        <div class="input-group">
            <span class="input-group-addon">The list order</span>
            <input type="number" class="form-control" id="forum_listorder_in" value="<?echo $forum->listorder?>">
        </div><br>

        <center>
            View permissions for <select id="permissions_type_in">
                <option data-type="canview">who can view</option>
                <option data-type="canpost">who can post</option>
            </select><br><br>
            <button class="toggle_btn" id="permissions_all" data-name="all" data-state="false">All</button>
            <button class="toggle_btn" id="permissions_registered" data-name="registered" data-state="false">Registered</button>
            <button class="toggle_btn" id="permissions_non-registered" data-name="non-registered" data-state="false">Non-registered</button>
            <button class="toggle_btn" id="permissions_staff" data-name="staff" data-state="false">Staff</button>
            <br><br>Usertags:<br>
            <?
                foreach(get_all_usertags() as $value){
                    if($value){
                        echo "<button class='toggle_btn' id='permissions_tag_$value->id' data-name='$value->id' data-state='false'>$value->name</button>";
                    }
                }
            ?><br><br>
            <button type="button" class="btn btn-danger" style="width:100%;" id="delete_forum">Delete forum</button>
        </center>
    </div>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
        removeHTMLElement("#delete_forum");
    }
?>

<script>
    var forumid = $("#getinfo").data("id")
    var name = $("#getinfo").data("name")
    var posttext = $("#getinfo").data("posttext")
    var listorder = $("#getinfo").data("listorder")
    var permissionstype = "canview"
    var permissions = ""

    function getpermissions(type){
        $(".toggle_btn").attr("data-state", "false")
        $.get("/admin/requests/getforumperms", {id: forumid, type: type}, function(html){
            permissionstype = type
            permissions = html

            $(permissions.split(";")).each(function(i, v){
                if(Number(v)){
                    $("#permissions_tag_" + v).attr("data-state", "true")
                }else{
                    $("#permissions_" + v).attr("data-state", "true")
                }
            })
        })
    }
    getpermissions("canview")

    function updateforum(){
        $.post("/admin/requests/updateforum", {id: forumid, name: name, posttext: posttext, listorder: listorder}, function(html){
            console.log(html)
            redo_forums_list($(selectedForumItem).data("id"))
            redo_forums_panel()
        })
    }

    $(".toggle_btn").click(function(){
        var state = $(this).attr("data-state")
        var name = $(this).data("name")

        if(state == "true"){ //turn off
            $(this).attr("data-state", "false")
            permissions = permissions.replace(new RegExp(name + ";", "g"), "")
            if(permissions.length == 0){
                permissions = "all;"
                $("#permissions_all").attr("data-state", "true")
            }
        }else{ //turn on
            $(this).attr("data-state", "true")
            permissions = permissions + name + ";"
        }

        $.post("/admin/requests/updateforumperms", {id: forumid, type: permissionstype, permissions: permissions}, function(html){
            console.log(html)
        })
    })

    $("#permissions_type_in").change(function(){
        if($(this).val() == "who can post"){
            getpermissions("canpost")
        }
        if($(this).val() == "who can view"){
            getpermissions("canview")
        }
    })
    $("#forum_name_in").bind("change", function(){
        name = $("#forum_name_in").val()
        updateforum()
    })
    $("#forum_posttext_in").bind("change", function(){
        posttext = $("#forum_posttext_in").val()
        updateforum()
    })
    $("#forum_listorder_in").bind("change", function(){
        listorder = $("#forum_listorder_in").val()
        updateforum()
    })
    $("#delete_forum").click(function(){
        if(confirm("Are you sure you want to delete this forum? If you do all threads and sub-forums will be permanently deleted!") == true){
            $.post("/admin/requests/forum_delete", {id: forumid}, function(){
                redo_forums_list()
                $("#fillin_forums").html("")
            })
        }else{

        }
    })
</script>
