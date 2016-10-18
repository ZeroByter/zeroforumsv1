<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/newsposts.php");
    include("../../phpscripts/essentials.php");

    $newspost = get_newspost_by_id($_GET["id"]);
?>

<style>
    #newspost_main_div{
        width: 80%;
        margin: 0px auto;
    }

    .post_canview_div{
        text-align: center;
        margin-top: 20px;
        margin-bottom: 18px;
    }

    #fillin_zeroeditor{
        height: initial;
    }

    #getid, #gettitle, #gettext, #getcanview{
        display: none;
    }
</style>

<span id="getid"><?echo $newspost->id?></span>
<span id="gettitle"><?echo $newspost->posttitle?></span>
<span id="gettext"><?echo $newspost->posttext?></span>
<span id="getcanview"><?echo $newspost->canview?></span>
<div id="newspost_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Title</span>
            <input type="text" class="form-control" id="post_title_in" value="<?echo $newspost->posttitle?>">
        </div>
        <div class="input-group">
            <span class="input-group-addon">Post body</span>
            <span type="text" id="fillin_zeroeditor" class="form-control" value=""></span>
        </div>
        <div class="post_canview_div">
            Who can view?<br>
            <button class="toggle_btn" id="canview_all" data-name="all" data-state="false">All</button>
            <button class="toggle_btn" id="canview_registered" data-name="registered" data-state="false">Registered</button>

            <button class="toggle_btn" id="canview_staff" data-name="staff" data-state="false">Staff</button>
            <br><br>Usertags:<br>
            <?
                foreach(get_all_usertags() as $value){
                    if($value){
                        echo "<button class='toggle_btn' id='canview_tag_$value->id' data-name='$value->id' data-state='false'>$value->name</button>";
                    }
                }
            ?>
        </div>
        <button type="button" class="btn btn-success" style="width:100%;" id="update_post">Update</button><br><br>
        <button type="button" class="btn btn-danger" style="width:100%;" id="delete_post">Delete</button>
    </div>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "newspnl_create_post")){
        removeHTMLElement("#delete_post");
    }
?>

<script id="navlink_script">
    var postid = $("#getid").html()
    var title = $("#gettitle").html()
    var text = $("#gettext").html()
    var canviewstring = $("#getcanview").html()

    $.get("/phpscripts/fillin/zeroeditor", function(content){
        $("#fillin_zeroeditor").html(content)
        setEditorString(text)
        $("#textarea").attr("required", "")
    })

    function updatepost(){
        $.post("/admin/requests/updatenewspost", {id: postid, title: title, text: getEditorString(), canview: canviewstring}, function(html){
            redo_newspostslist($(selectedPost).data("id"))
            redo_panel()
            console.log(html)
        })
    }

    $($("#getcanview").html().split(";")).each(function(i, v){
        if(Number(v)){
            $("#canview_tag_" + v).attr("data-state", "true")
        }else{
            $("#canview_" + v).attr("data-state", "true")
        }
    })

    $(".toggle_btn").click(function(){
        var state = $(this).attr("data-state")
        var name = $(this).data("name")

        if(state == "true"){ //turn off
            $(this).attr("data-state", "false")
            canviewstring = canviewstring.replace(new RegExp(name + ";", "g"), "")
            if(canviewstring.length == 0){
                $("#canview_all").attr("data-state", "true")
                canviewstring = "all;"
            }
        }else{ //turn on
            $(this).attr("data-state", "true")
            canviewstring = canviewstring + name + ";"
        }
        console.log(canviewstring)
    })

    $("#post_title_in").bind("change keyup", function(){
        title = $("#post_title_in").val()
    })
    $("#update_post").click(function(){
        updatepost()
    })
    $("#delete_post").click(function(){
        $.post("/admin/requests/deletenewspost", {id: postid}, function(){
            $("#fillin_newsposts").html("")
            redo_newspostslist()
        })
    })
</script>
