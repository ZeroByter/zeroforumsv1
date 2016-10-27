<?php
	function navigatebar_create_db(){
		$conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS navigatebar(
			id int(6) NOT NULL auto_increment,
			type varchar(8) NOT NULL,
			text varchar(30) NOT NULL,
			link varchar(30) NOT NULL,
			canview text NOT NULL,
			listorder int(6) NOT NULL,
			canedit boolean NOT NULL,
			candelete boolean NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
	}

	function get_navbar_title(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM navigatebar WHERE type='title'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_navlink_by_id($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM navigatebar WHERE id='$id'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_navlink_by_listorder($listorder){
		$conn = sql_connect();
		$listorder = mysqli_real_escape_string($conn, $listorder);
		$result = mysqli_query($conn, "SELECT * FROM navigatebar WHERE listorder='$listorder'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function set_navbar_title($text){
		$text = $text;
		if(get_navbar_title()){
			$conn = sql_connect();
			$text = mysqli_real_escape_string($conn, $text);
			$result = mysqli_query($conn, "UPDATE navigatebar SET text='$text' WHERE type='title'");
			mysqli_close($conn);
		}else{
			$conn = sql_connect();
			$text = mysqli_real_escape_string($conn, $text);
			mysqli_query($conn, "INSERT INTO navigatebar(type, text) VALUES ('title', '$text')");
			mysqli_close($conn);
		}
	}

	function get_navbar_links(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM navigatebar WHERE type='link' ORDER BY listorder ASC");
		mysqli_close($conn);

		$array = array();
		while($array[] = mysqli_fetch_object($result));

		return $array;
	}

	function add_navbar_link($text, $link, $listorder, $canview, $canedit=true, $candelete=true){
		$conn = sql_connect();
		$text = mysqli_real_escape_string($conn, $text);
		$link = mysqli_real_escape_string($conn, $link);
		$listorder = mysqli_real_escape_string($conn, $listorder);
		$canview = mysqli_real_escape_string($conn, $canview);
		$canedit = mysqli_real_escape_string($conn, $canedit);
		$candelete = mysqli_real_escape_string($conn, $candelete);
		mysqli_query($conn, "INSERT INTO navigatebar(type, text, link, canview, listorder, canedit, candelete) VALUES ('link', '$text', '$link', '$canview', '$listorder', '$canedit', '$candelete')");
		mysqli_close($conn);
	}

	function remove_navbar_link($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_query($conn, "DELETE FROM navigatebar WHERE type='link' && id='$id'");
		mysqli_close($conn);
	}

	function update_navbar_link($id, $text, $link, $canview, $listorder){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$text = mysqli_real_escape_string($conn, $text);
		$link = mysqli_real_escape_string($conn, $link);
		$canview = mysqli_real_escape_string($conn, $canview);
		$listorder = mysqli_real_escape_string($conn, $listorder);
		mysqli_query($conn, "UPDATE navigatebar SET text='$text', link='$link', canview='$canview', listorder='$listorder' WHERE id='$id'");
		mysqli_close($conn);
	}

	function get_next_navbar_link($id, $offset){
		$link = get_navlink_by_id($id);

		return get_navlink_by_listorder($link->listorder + $offset);
	}
?>
