<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    foreach(get_all_usertags_limited() as $value){
        if($value){
            $isactive = "";
            if(isset($_GET["active"]) && $value->id == $_GET["active"]){
                $isactive = "row_active";
            }
            echo "
                <div class='usertag_link_list_div $isactive' data-id='$value->id'>
                    $value->name
                </div>
            ";
        }
    }
?>

<script>
    $(".usertag_link_list_div").click(function(){ //when user clicks on one of the usertags
        if(!$(this).attr("disabled")){
            $(".usertag_link_list_div").each(function(i, v){
                $(v).removeClass("row_active")
            })
            $(this).addClass("row_active")
            selectedUsertag = this

            $.get("fillin/getusertagfillin", {id: $(selectedUsertag).data("id")}, function(html){
                $("#fillin_usertag").html(html)
            })
        }
    })
</script>

<?isset($_GET["active"]) ? "<script>selectedUsertag = ".$_GET["active"]."</script>" : "";?>
