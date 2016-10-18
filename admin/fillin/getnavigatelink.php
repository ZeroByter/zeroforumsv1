<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");

    $navlink = get_navlink_by_id($_GET["id"]);

    $canedit = (!$navlink->canedit) ? "disabled" : "";
?>

<style>
    #link_main_div{
        width: 80%;
        margin: 0px auto;
    }

    .link_canview_list_div{
        width: 367px;
        float: right;
        padding: 6px 16px;
        border: 1px solid #cccccc;
        border-radius: 4px;
    }

    .link_canview_div{
        text-align: center;
        margin-top: 20px;
        margin-bottom: 18px;
    }
</style>

<span id="getinfo" data-id="<?echo $navlink->id?>" data-canview="<?echo $navlink->canview?>" data-text="<?echo $navlink->text?>" data-link="<?echo $navlink->link?>" data-listorder="<?echo $navlink->listorder?>"></span>
<div id="link_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Text</span>
            <input type="text" class="form-control" id="navlink_text_in" value="<?echo $navlink->text?>" <?echo $canedit?>>
        </div>
        <div class="input-group">
            <span class="input-group-addon">URL Link</span>
            <input type="text" class="form-control" id="navlink_link_in" value="<?echo $navlink->link?>" <?echo $canedit?>>
        </div>
        <div class="input-group">
            <span class="input-group-addon" data-toggle='tooltip' data-placement='bottom' title='In what order should this link be viewed?'>The viewing order</span>
            <input type="number" class="form-control" id="navlink_listorder_in" value="<?echo $navlink->listorder?>" <?echo $canedit?>>
        </div>
        <button type="button" class="btn btn-danger" style="width:100%;" id="delete_link" <?echo $canedit?>>Delete</button>
        <div class="link_canview_div">
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
    </div>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "navigatepnl_create_new_link")){
        removeHTMLElement("#delete_link");
    }
?>

<script id="navlink_script">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    var navlinkid = $("#getinfo").data("id")
    var text = $("#getinfo").data("text")
    var link = $("#getinfo").data("link")
    var listorder = $("#getinfo").data("listorder")
    var canviewstring = $("#getinfo").data("canview")

    function updatenavlink(){
        $.post("/admin/requests/updatenavlink", {id: navlinkid, text: text, link: link, listorder: listorder, canview: canviewstring}, function(html){
            redo_navigatelist($(selectedNavigatelink).data("id"))
            redo_panel()
        })
    }

    $($("#getinfo").data("canview").split(";")).each(function(i, v){
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
                canviewstring = "all;"
            }
        }else{ //turn on
            $(this).attr("data-state", "true")
            canviewstring = canviewstring + name + ";"
        }
        updatenavlink()
    })

    $("#navlink_text_in").bind("change", function(){
        text = $("#navlink_text_in").val()
        updatenavlink()
    })
    $("#navlink_link_in").bind("change", function(){
        link = $("#navlink_link_in").val()
        updatenavlink()
    })
    $("#navlink_listorder_in").bind("change", function(){
        listorder = $("#navlink_listorder_in").val()
        updatenavlink()
    })
    $("#delete_link").click(function(){
        $.post("/admin/requests/deletenavlink", {id: navlinkid}, function(){
            $("#fillin_navigatebar").html("")
            redo_navigatelist()
        })
    })
</script>

<?
    if(!$navlink->canedit){
        removeHTMLElement("#navlink_script");
        removeHTMLElement("#delete_link");
        removeHTMLElement(".link_canview_div");
    }
?>
