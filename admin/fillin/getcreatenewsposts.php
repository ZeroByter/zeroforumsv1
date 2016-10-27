<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
?>

<script src="/jsscripts/zeroeditor.js"></script>

<style>
    #newsposts_main_div{
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
</style>

<div id="newsposts_main_div" class="panel panel-default">
    <div class="panel-body">
        <form id="newspost_submit_form" onsubmit="void(0)">
            <div class="input-group">
                <span class="input-group-addon">Title</span>
                <input type="text" required class="form-control" id="post_name_in" value="">
            </div>
            <div class="input-group">
                <span class="input-group-addon">Post body</span>
                <span type="text" id="fillin_zeroeditor" class="form-control" value=""></span>
            </div>
            <div class="post_canview_div">
                Who can view?<br>
                <button type="button" class="toggle_btn" id="canview_all" data-name="all" data-state="true">All</button>
                <button type="button" class="toggle_btn" id="canview_registered" data-name="registered" data-state="false">Registered</button>
                <button type="button" class="toggle_btn" id="canview_staff" data-name="staff" data-state="false">Staff</button>
                <br><br>Usertags:<br>
                <?php
                    foreach(get_all_usertags() as $value){
                        if($value){
                            echo "<button type='button' class='toggle_btn' id='canview_tag_$value->id' data-name='$value->id' data-state='false'>$value->name</button>";
                        }
                    }
                ?>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;" id="create_newspost">Create new usertag</button>
        </form>
    </div>
</div>

<script>
    $.get("/phpscripts/fillin/zeroeditor", function(content){
        $("#fillin_zeroeditor").html(content)
        $("#textarea").attr("required", "")
    })

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })
    canviewstring = "all;"

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

    $("#newspost_submit_form").submit(function(){
        var name = $("#post_name_in").val()
        var text = getEditorString()

        $.post("/admin/requests/createnewspost", {title: name, text: text, canview: canviewstring}, function(html){
            console.log(html)
            $("#fillin_newsposts").html("")
            redo_newspostslist()
        })
        return false
    })
</script>
