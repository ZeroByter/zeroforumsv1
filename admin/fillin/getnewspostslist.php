<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/newsposts.php");

    foreach(newsposts_get_all_posts() as $value){
        if($value){
            $isactive = "";
            if(isset($_GET["active"]) && $value->id == $_GET["active"]){
                $isactive = "row_active";
            }

            echo "
                <div class='newsposts_list_item_div $isactive' data-id='$value->id'>
                    $value->posttitle
                </div>
            ";
        }
    }
?>

<script>
    $(".newsposts_list_item_div").click(function(){ //when user clicks on one of the links
        $(".newsposts_list_item_div").removeClass("row_active")
        $("#create_new_post").removeClass("row_active")
        $(this).addClass("row_active")
        selectedPost = this

        $.get("fillin/getnewspost", {id: $(selectedPost).data("id")}, function(html){
            $("#fillin_newsposts").html(html)
        })
    })
</script>

<?isset($_GET["active"]) ? "<script>selectedPost = ".$_GET["active"]."</script>" : "";?>
