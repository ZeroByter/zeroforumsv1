<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/essentials.php");

    $parent = get_rule_by_id($_GET["parent"]);
?>

<style>
    #create_rule_main_div{
        width: 80%;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }
</style>

<span style="display:none;" id="getparent"><?echo $_GET["parent"]?></span>
<div id="create_rule_main_div" class="panel panel-default">
    <div class="panel-body">
        <center><h5>Creating a rule for category '<?echo $parent->text;?>'</h5></center>
        <form id="create_rule">
            <div class="input-group">
                <span class="input-group-addon">Rule text</span>
                <input type="text" class="form-control" id="rule_text_in" value="" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Rule list order</span>
                <input type="number" class="form-control" id="rule_listorder_in" value="1" required>
            </div><br>
            <button type="submit" class="btn btn-success" style="width:100%;">Create new rule</button>
        </form>
    </div>
</div>

<script>
    var parent = $("#getparent").html()
    console.log(parent)
    var text = ""
    var listorder = 1

    $("#rule_text_in").bind("change keyup", function(){
        text = $("#rule_text_in").val()
    })
    $("#rule_listorder_in").bind("change keyup", function(){
        listorder = $("#rule_listorder_in").val()
    })
    $("#create_rule").submit(function(){
        $.post("/admin/requests/createrule", {parent: parent, text: text, listorder: listorder}, function(html){
            console.log(html)
            $("#fillin_rules").html("")
            redo_rules_list()
        })
        return false
    })
</script>
