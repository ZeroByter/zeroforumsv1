<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    foreach(get_navbar_links() as $value){
        if($value){
            $text = $value->text;
            if(!$value->canedit){
                $text = "<i>$text</i>";
            }
            $isactive = "";
            if(isset($_GET["active"]) && $value->id == $_GET["active"]){
                $isactive = "row_active";
            }
            echo "
                <div class='navigation_link_list_div $isactive' data-toggle='tooltip' data-placement='right' title='$value->link' data-id='$value->id'>
                    $text
                </div>
            ";
        }
    }
?>

<script>
    $(".navigation_link_list_div").click(function(){ //when user clicks on one of the links
        $(".navigation_link_list_div").removeClass("row_active")
        $("#create_new_link").removeClass("row_active")
        $(this).addClass("row_active")
        selectedNavigatelink = this

        $.get("fillin/getnavigatelink", {id: $(selectedNavigatelink).data("id")}, function(html){
            $("#fillin_navigatebar").html(html)
        })
    })
</script>

<?isset($_GET["active"]) ? "<script>selectedNavigatelink = ".$_GET["active"]."</script>" : "";?>
