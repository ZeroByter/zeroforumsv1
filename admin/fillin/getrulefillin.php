<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/essentials.php");

    $rule = get_rule_by_id($_GET["id"]);
?>

<style>
    #getid, #gettext, #getlistorder{
        display: none;
    }
</style>

<span id="getid"><?echo $rule->id?></span>
<span id="gettext"><?echo $rule->text?></span>
<span id="getlistorder"><?echo $rule->listorder?></span>
<div id="rules_main_panel_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Text</span>
            <input type="text" class="form-control" id="rule_text_in" value="<?echo $rule->text?>">
        </div>
        <div class="input-group">
            <span class="input-group-addon">List order</span>
            <input type="number" class="form-control" id="rule_listorder_in" value="<?echo $rule->listorder?>">
        </div>

        <button type="button" class="btn btn-danger" style="width:100%;" id="delete_rule">Delete</button>
    </div>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "rulespnl_create_rule")){
        removeHTMLElement("#delete_rule");
    }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    var ruleid = $("#getid").html()
    var text = $("#gettext").html()
    var listorder = $("#getlistorder").html()

    function updaterule(){
        $.post("/admin/requests/updaterule", {id: ruleid, text: text, listorder: listorder}, function(html){
            console.log(html)
            redo_rules_list($(selectedRule).data("id"))
            redo_rules_panel()
        })
    }

    $("#rule_text_in").bind("change", function(){
        text = $("#rule_text_in").val()
        updaterule()
    })
    $("#rule_listorder_in").bind("change", function(){
        listorder = $("#rule_listorder_in").val()
        updaterule()
    })
    $("#delete_rule").click(function(){
        $.post("/admin/requests/deleterule", {id: ruleid}, function(html){
            console.log(html)
            $("#fillin_rules").html("")
            redo_rules_list()
        })
    })
</script>
