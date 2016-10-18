<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");
    include("../../phpscripts/essentials.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_logs_tab")){
        echo "<script>window.close()</script>";
    }
    if(!$_GET["date"]){
        echo "<script>window.close()</script>";
    }
?>

<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">

<style>
    #view_log_main{
        text-align: center;
    }

    .log_time, .log_text{
        display: inline-block;
        font-size: 12px;
    }
    .log_text{
        margin-bottom: 6px;
    }
</style>

<div id="view_log_main">
    <h3>Viewing log: <?echo $_GET["date"]?></h3><br>
    <?
        foreach(get_logs_by_date($_GET["date"]) as $value){
            if($value){
                echo "<div><span class='label label-primary log_time'>$value->time:</span><span class='label label-default log_text'>".filterXSS($value->text)."</span></div>";
            }
        }
    ?>
</div>
