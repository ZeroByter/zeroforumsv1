<?
    function newsposts_create_db(){
        $conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS newsposts(
			id int(6) NOT NULL auto_increment,
			postdate int(6) NOT NULL,
			releasedate int(6) NOT NULL,
			poster int(6) NOT NULL,
			posttitle varchar(128) NOT NULL,
			posttext text NOT NULL,
			canview text NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
    }

    function newsposts_get_all_posts(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM newsposts ORDER BY releasedate DESC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_newspost_by_id($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM newsposts WHERE id='$id'");
		mysqli_close($conn);

        return mysqli_fetch_object($result);
    }

    function newsposts_create_newspost($title, $text, $canview="all;"){
        $conn = sql_connect();

		$title = mysqli_real_escape_string($conn, $title);
		$text = mysqli_real_escape_string($conn, $text);
		$canview = mysqli_real_escape_string($conn, $canview);

        $time = time();
        $currAccount = get_current_account();
		$result = mysqli_query($conn, "INSERT INTO newsposts(postdate, releasedate, poster, posttitle, posttext, canview) VALUES ('$time', '$time', '$currAccount->id', '$title', '$text', '$canview')");
		mysqli_close($conn);
    }

    function delete_newspost($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $result = mysqli_query($conn, "DELETE FROM newsposts WHERE id='$id'");
        mysqli_close($conn);
    }

    function update_newspost($id, $title, $text, $canview){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
        $title = mysqli_real_escape_string($conn, $title);
        $text = mysqli_real_escape_string($conn, $text);
        $canview = mysqli_real_escape_string($conn, $canview);
        $result = mysqli_query($conn, "UPDATE newsposts SET posttitle='$title',posttext='$text',canview='$canview' WHERE id='$id'");
        mysqli_close($conn);
    }
?>
