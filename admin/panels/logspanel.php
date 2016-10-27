<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_logs_tab")){
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
        <?php
            function endsWith($haystack, $needle) {
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
            }

            $canDownload = tag_has_permission(get_current_usertag(), "logs_download_log");

            foreach(get_all_log_dates() as $value){
                $downloadHTML = "<button class='btn btn-default download_log_btn' data-date='$value'>Download</button>";
                if(!$canDownload){
                    $downloadHTML = "";
                }
                echo "
                    <div class='panel panel-default'>
                        <div class='panel-heading'>$value</div>
                        <div class='panel-body'>
                            <button class='btn btn-default view_log_btn' data-date='$value'>View</button>
                            $downloadHTML
                        </div>
                    </div>
                ";
            }
        ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(".download_log_btn").click(function(){
        var w = 600
		var h = 160

        var width = screen.width
		var height = screen.height
		var left = (width / 2) - (w / 2)
		var top = (height / 2) - (h / 2)

        window.open("/phpscripts/downloadlog?date=" + $(this).data("date"), "_blank", "width=" + w + ",height=" + h + ",top=" + top + ",left=" + left)
    })
    $(".view_log_btn").click(function(){
        var w = 600
		var h = 700

        var width = screen.width
		var height = screen.height
		var left = (width / 2) - (w / 2)
		var top = (height / 2) - (h / 2)

        var newWindow = window.open("/admin/panels/viewlog?date=" + $(this).data("date"), "_blank", "width=" + w + ",height=" + h + ",top=" + top + ",left=" + left)
		newWindow.focus()
    })
</script>
