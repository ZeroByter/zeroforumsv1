<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/rules.php");

    foreach(get_all_rule_categories() as $value){
        if($value){
            $rules_string = "";
            foreach(get_all_rules_in_category($value->id) as $value2){
                if($value2){
                    $charLimit = 32;
                    $text = substr($value2->text, 0, $charLimit);
                    if(strlen($value2->text) >= $charLimit){
                        $text = "$text...";
                    }
                    $rules_string = $rules_string . "<div class='rules_list_item_div' data-id='$value2->id'><span class='fa fa-circle'></span> $text</div>";
                }
            }

            echo "
                <div class='rule_category_list_item_div' data-id='$value->id'>
                    $value->text
                </div>
                <div class='rules_fake_list_item_div create_new_rule' data-parent='$value->id' style='color: green;'>Create a new rule</div>
                $rules_string
            ";

            if(!tag_has_permission(get_current_usertag(), "rulespnl_create_rule")){
                removeHTMLElement("#create_new_rule_category");
                removeHTMLElement(".create_new_rule");
            }
        }
    }
?>

<script>
    $(".rule_category_list_item_div, .rules_list_item_div").click(function(){ //when user clicks on one of the rule categories
        if(!$(this).attr("disabled")){
            $(".rule_category_list_item_div").each(function(i, v){
                $(v).removeClass("row_active")
            })
            $(this).addClass("row_active")
            selectedRule = this

            $.get("fillin/getrulefillin", {id: $(selectedRule).data("id")}, function(html){
                $("#fillin_rules").html(html)
            })
        }
    })
    $(".create_new_rule").click(function(){
        var parent = $(this).data("parent")
        $.get("/admin/fillin/getcreaterule", {parent: parent}, function(html){
            $("#fillin_rules").html(html)
            $(".rule_category_list_item_div").removeClass("row_active")
            $(".rules_list_item_div").removeClass("row_active")
        })
    })
</script>

<?phpisset($_GET["active"]) ? "<script>selectedRule = ".$_GET["active"]."</script>" : "";?>
