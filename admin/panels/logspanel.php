<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_navigation_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #logs_list_div{
        text-align: center;
        margin: 40px auto;
        max-width: 200px;
    }
</style>

<div id="logs_main_div">
    <br>
    <center>Click on a date to view or download the entire log file <span data-toggle="tooltip" data-placement="bottom" title="If you want to watch a log file over a time, view it. If you want to download a log as a copy or evidence, download it.">[?]</span></center>

    <div id="logs_list_div">
        <?
            function endsWith($haystack, $needle) {
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
            }

            foreach(scandir($_SERVER["DOCUMENT_ROOT"] . "/logs", 1) as $num => $value){
                //if(endsWith($value, ".txt") && strpos($value, '-') !== false){
                //    $date = str_replace(".txt", "", $value);
                //    $date = str_replace("-", "/", $date);

                //    echo "
                //        <div class='panel panel-default'>
                //            <div class='panel-heading'>$date</div>
                //            <div class='panel-body'>
                //                <button class='btn btn-default'>View</button>
                //                <button class='btn btn-default download_log_btn' data-date='$value'>Download</button>
                //            </div>
                //        </div>
                //    ";
                //}
            }
        ?>
    </div>
</div>

<iframe id="download_iframe" style="display:none;"></iframe>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(".download_log_btn").click(function(){

    })
</script>
