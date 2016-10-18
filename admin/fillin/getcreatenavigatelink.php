<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
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

<div id="link_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Text</span>
            <input type="text" class="form-control" id="navlink_text_in" value="">
        </div>
        <div class="input-group">
            <span class="input-group-addon">URL Link</span>
            <input type="text" class="form-control" id="navlink_link_in" value="">
        </div>
        <div class="input-group">
            <span class="input-group-addon" data-toggle='tooltip' data-placement='bottom' itle='In what order shouold this link be viewed?'>The viewing order</span>
            <input type="number" class="form-control" id="navlink_listorder_in" value="1">
        </div>
        <div class="link_canview_div">
            Who can view?<br><br>
            <button class="toggle_btn" id="canview_all" data-name="all" data-state="true">All</button>
            <button class="toggle_btn" id="canview_registered" data-name="registered" data-state="false">Registered</button>
            
            <button class="toggle_btn" id="canview_staff" data-name="staff" data-state="false">Staff</button>
            <br>Usertags:<br>
            <?
                foreach(get_all_usertags() as $value){
                    if($value){
                        echo "<button class='toggle_btn' id='canview_tag_$value->id' data-name='$value->id' data-state='false'>$value->name</button>";
                    }
                }
            ?>
        </div>
        <button type="button" class="btn btn-success" style="width:100%;" id="create_link">Create new link</button>
    </div>
</div>

<script>
    var canviewstring = "all;"

    $(".toggle_btn").click(function(){
        var state = $(this).attr("data-state")
        var name = $(this).data("name")

        if(state == "true"){ //turn off
            $(this).attr("data-state", "false")
            canviewstring = canviewstring.replace(new RegExp(name + ";", "g"), "")
            if(canviewstring.length == 0){
                canviewstring = "all;"
                $("#canview_all").attr("data-state", "true")
            }
        }else{ //turn on
            $(this).attr("data-state", "true")
            canviewstring = canviewstring + name + ";"
        }
    })

    $("#create_link").click(function(){
        var text = $("#navlink_text_in").val()
        var link = $("#navlink_link_in").val()
        var listorder = $("#navlink_listorder_in").val()

        if(canviewstring.length == 0){
            canviewstring = "all;"
        }

        $.post("/admin/requests/createnavlink", {text: text, link: link, listorder: listorder, canview: canviewstring}, function(html){
            $("#fillin_navigatebar").html("")
            redo_navigatelist()
        })
    })
</script>
