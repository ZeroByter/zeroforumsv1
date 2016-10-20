<?
    function rules_create_db(){
        $conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS rules(
			id int(6) NOT NULL auto_increment,
			postdate int(6) NOT NULL,
			lastedited int(6) NOT NULL,
			lastediteduser int(6) NOT NULL,
			poster int(6) NOT NULL,
			parent int(6) NOT NULL,
            type varchar(28) NOT NULL,
            listorder int(6) NOT NULL,
			text text NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
    }

    function get_rule_by_id($id){
        $conn = sql_connect();
        $id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM rules WHERE id='$id'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
    }

    function get_all_rules_in_category($parent){
        $conn = sql_connect();
        $parent = mysqli_real_escape_string($conn, $parent);
		$result = mysqli_query($conn, "SELECT * FROM rules WHERE parent='$parent' ORDER BY listorder ASC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function get_all_rule_categories(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM rules WHERE type='category' ORDER BY listorder ASC");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

    function create_new_rules_category($name, $listorder){
        $conn = sql_connect();

		$name = mysqli_real_escape_string($conn, htmlspecialchars($name));
		$listorder = mysqli_real_escape_string($conn, $listorder);

        $time = time();
        $currAccount = get_current_account();
		$result = mysqli_query($conn, "INSERT INTO rules(postdate, poster, type, listorder, text) VALUES ('$time', '$currAccount->id', 'category', '$listorder', '$name')");
		mysqli_close($conn);
    }

    function create_new_rule($parent, $text, $listorder){
        $conn = sql_connect();

		$parent = mysqli_real_escape_string($conn, $parent);
		$text = mysqli_real_escape_string($conn, htmlspecialchars($text));
		$listorder = mysqli_real_escape_string($conn, $listorder);

        $time = time();
        $currAccount = get_current_account();
		$result = mysqli_query($conn, "INSERT INTO rules(postdate, poster, parent, type, listorder, text) VALUES ('$time', '$currAccount->id', '$parent', 'rule', '$listorder', '$text')");
		mysqli_close($conn);
    }

    function edit_rule($id, $text, $listorder){
        $conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$text = mysqli_real_escape_string($conn, htmlspecialchars($text));
		$listorder = mysqli_real_escape_string($conn, $listorder);
		$result = mysqli_query($conn, "UPDATE rules SET text='$text',listorder='$listorder' WHERE id='$id'");
		mysqli_close($conn);
    }

    function delete_rule($id){
        $conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "DELETE FROM rules WHERE id='$id'");
		mysqli_close($conn);
    }
?>
