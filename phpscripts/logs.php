<?
    function logs_create_db(){
        $conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS logs(
			id int(6) NOT NULL auto_increment,
			date varchar(24) NOT NULL,
			time varchar(24) NOT NULL,
			text text NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
    }

    function get_all_log_dates(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT date FROM logs ORDER BY id DESC");
		mysqli_close($conn);
		while($array[] = mysqli_fetch_object($result));
        $finalArray = array();

        foreach($array as $value){
            if($value){
                if(!in_array($value->date, $finalArray)){
                    array_push($finalArray, $value->date);
                }
            }
        }

        return $finalArray;
    }

    function get_logs_by_date($date){
        $conn = sql_connect();
        $date = mysqli_real_escape_string($conn, $date);
		$result = mysqli_query($conn, "SELECT * FROM logs WHERE date='$date' ORDER BY id DESC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

        return $array;
    }

    function create_log($text){
        $time = time() + 60 * 60; //Times are 2.00+ CUT (Coordinated Universal Time)
        $filedate = getdate($time)["mday"] . "/" . getdate($time)["mon"] . "/" . getdate($time)["year"];
        $logdate = getdate($time)["hours"] . ":" . getdate($time)["minutes"] . ":" . getdate($time)["seconds"];
        $ampm = (getdate($time)["hours"] > 12) ? "(PM)" : "(AM)";

        $conn = sql_connect();
		$text = mysqli_real_escape_string($conn, $text);
		mysqli_query($conn, "INSERT INTO logs(date, time, text) VALUES ('$filedate', '$logdate $ampm', '$text')");
		mysqli_close($conn);
    }
?>
