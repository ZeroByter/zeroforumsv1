<div class='forum_fake_list_div' id='create_new_forum' style='color:green;'>Create a new forum</div>

<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/forums.php");

    foreach(get_all_forums() as $value){
        if($value){
            $subforums_html = "";
            foreach(get_all_subforums($value->id) as $value2){
                if($value2){
                    $subforums_html = $subforums_html . "<div class='subforum_list_div' data-id='$value2->id'><span class='fa fa-circle'></span> $value2->name</div>";
                }
            }

            echo "
                <div class='forum_parent_div'>
                    <div class='forum_list_div' data-id='$value->id'>
                        $value->name
                    </div>
                    <div class='subforum_fake_list_div' id='create_new_subforum' data-id='$value->id' style='color:green;'>Create a new sub-forum</div>
                    $subforums_html
                </div>
            ";

            if(!tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
                removeHTMLElement("#create_new_subforum");
                removeHTMLElement("#create_new_forum");
            }
        }
    }
?>

<script>
    $(".forum_list_div, .subforum_list_div").click(function(){ //when user clicks on one of the forums
        $(".forum_list_div, .subforum_list_div, .forum_fake_list_div, .subforum_fake_list_div").each(function(i, v){
            $(v).removeClass("row_active")
        })
        $(this).addClass("row_active")
        selectedForumItem = this
        redo_forums_panel()
    })

    $(".forum_fake_list_div").click(function(){
        $(".forum_list_div, .subforum_list_div, .forum_fake_list_div, .subforum_fake_list_div").each(function(i, v){
            $(v).removeClass("row_active")
        })
        selectedForumItem = undefined
        $.get("/admin/fillin/getforumcreatefillin", function(html){
            $("#fillin_forums").html(html)
        })
    })

    $(".subforum_fake_list_div").click(function(){
        $(".forum_list_div, .subforum_list_div, .forum_fake_list_div, .subforum_fake_list_div").each(function(i, v){
            $(v).removeClass("row_active")
        })
        selectedForumItem = undefined
        $.get("/admin/fillin/getsubforumcreatefillin", {id: $(this).data("id")}, function(html){
            $("#fillin_forums").html(html)
        })
    })
</script>

<?phpisset($_GET["active"]) ? "<script>selectedForumItem = ".$_GET["active"]."</script>" : "";?>
