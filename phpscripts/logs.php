<?
    function create_log($text){
        $time = time() + 60 * 60;
        $filedate = getdate($time)["mday"] . "-" . getdate($time)["mon"] . "-" . getdate($time)["year"];
        $dir = $_SERVER["DOCUMENT_ROOT"] . "/logs";
        $filedir = "$dir/$filedate.txt";
        $logdate = getdate($time)["hours"] . ":" . getdate($time)["minutes"] . ":" . getdate($time)["seconds"];
        $ampm = (getdate($time)["hours"] > 12) ? "(PM)" : "(AM)";

        if(!file_exists($dir)){
            mkdir($dir);
        }
        if(!file_exists($filedir)){
            file_put_contents($filedir, "Times are 2.00+ CUT (Coordinated Universal Time):\n\n");
        }
        file_put_contents($filedir, file_get_contents($filedir) . "$logdate $ampm $text\n");
    }
?>
