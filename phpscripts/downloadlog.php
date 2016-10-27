<?phpphp
    include("getsql.php");
    include("accounts.php");
    include("usertags.php");
    include("logs.php");

    if(isset($_GET["date"])){
        if(tag_has_permission(get_current_usertag(), "logs_download_log")){
            $date = str_replace("/", "-", $_GET["date"]);
            $file = $_SERVER['DOCUMENT_ROOT'] . "/$date logs.txt";

            create_log(get_current_account()->username . " downloaded the logs from " . $_GET["date"]);

            file_put_contents($file, "Times are 2.00+ CUT (Coordinated Universal Time)\n\n");
            foreach(get_logs_by_date($_GET["date"]) as $value){
                if($value){
                    file_put_contents($file, "$value->time: $value->text\n", FILE_APPEND);
                }
            }

            if(file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                unlink($file);
            }
        }
    }
?>
