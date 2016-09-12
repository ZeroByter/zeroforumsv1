<?
	$permissions = [];
	$permissionsInfo = [];
	// Forums permissions
	$permissions[] = "createthread";
	$permissionsInfo["createthread"] = array("name" => "Create thread", "desc" => "Create a forum thread");
	$permissions[] = "createreply";
	$permissionsInfo["createreply"] = array("name" => "Create reply", "desc" => "Create a thread reply");
	$permissions[] = "viewhiddenthread";
	$permissionsInfo["viewhiddenthread"] = array("name" => "View hidden threads", "desc" => "View threads which are tagged as hidden from everyone else");
	// Admin panel permissions
	$permissions[] = "adminpnl_forums_tab";
	$permissionsInfo["adminpnl_forums_tab"] = array("name" => "Admin panel: view forums tab", "desc" => "View the forums tab in the admin panel");
	$permissions[] = "adminpnl_users_tab";
	$permissionsInfo["adminpnl_users_tab"] = array("name" => "Admin panel: view users tab", "desc" => "View the users tab in the admin panel");
	$permissions[] = "adminpnl_usertags_tab";
	$permissionsInfo["adminpnl_usertags_tab"] = array("name" => "Admin panel: view user tags tab", "desc" => "View the user tags tab in the admin panel");
	$permissions[] = "adminpnl_permissions_tab";
	$permissionsInfo["adminpnl_permissions_tab"] = array("name" => "Admin panel: view permissions tab", "desc" => "View the permisions tab in the admin panel");
	$permissions[] = "adminpnl_navigation_tab";
	$permissionsInfo["adminpnl_navigation_tab"] = array("name" => "Admin panel: view navigation tab", "desc" => "View the navigation tab in the admin panel");
	$permissions[] = "adminpnl_ignore_usertag_limit";
	$permissionsInfo["adminpnl_ignore_usertag_limit"] = array("name" => "Admin panel: ignore usertag listorder limit", "desc" => "View all usertags, regardless if they are higher sorted than user's");

	function get_permissions(){
		return $permissions;
	}

	//TO-DO: MAKE USER TAGS PERMISSION SYSTEMS

	function usertags_create_db(){
		$conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS usertags(
			id int(6) NOT NULL auto_increment,
			name varchar(64) NOT NULL,
			permissionstring text NOT NULL,
			listorder int(6) NOT NULL,
			isstaff boolean NOT NULL,
			isdefault boolean NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
	}

	function get_usertag_by_id($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM usertags WHERE id='$id'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_default_usertag(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM usertags WHERE isdefault='1'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_all_usertags(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM usertags ORDER BY listorder ASC");
		mysqli_close($conn);

		$array = array();
		while($array[] = mysqli_fetch_object($result));

		return $array;
	}

	function get_all_usertags_limited(){
		$currentlistorder = get_usertag_by_id(get_current_usertag())->listorder;

		if(tag_has_permission(get_current_usertag(), "adminpnl_ignore_usertag_limit")){
			return get_all_usertags();
		}

		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM usertags WHERE listorder<='$currentlistorder' ORDER BY listorder ASC");
		mysqli_close($conn);

		$array = array();
		while($array[] = mysqli_fetch_object($result));

		return $array;
	}

	function get_all_staff_usertags(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM usertags WHERE isstaff = 1 ORDER BY listorder ASC");
		mysqli_close($conn);

		$array = array();
		while($array[] = mysqli_fetch_object($result));

		return $array;
	}

	function add_usertag($name, $permissionstring, $listorder, $isdefault=false, $isstaff=false){
		$conn = sql_connect();

		$name = mysqli_real_escape_string($conn, $name);
		$permissionstring = mysqli_real_escape_string($conn, $permissionstring);
		$listorder = mysqli_real_escape_string($conn, $listorder);
		$isdefault = mysqli_real_escape_string($conn, $isdefault);
		$isstaff = mysqli_real_escape_string($conn, $isstaff);

		$result = mysqli_query($conn, "INSERT INTO usertags(name, permissionstring, listorder, isdefault, isstaff) VALUES ('$name', '$permissionstring', '$listorder', '$isdefault', '$isstaff')");
		mysqli_close($conn);
	}

	function edit_usertag($id, $name, $permissionstring, $listorder, $isstaff){
		$conn = sql_connect();

		$id = mysqli_real_escape_string($conn, $id);
		$name = mysqli_real_escape_string($conn, $name);
		$permissionstring = mysqli_real_escape_string($conn, $permissionstring);
		$listorder = mysqli_real_escape_string($conn, $listorder);
		$isstaff = mysqli_real_escape_string($conn, $isstaff);

		$result = mysqli_query($conn, "UPDATE usertags SET name='$name',permissionstring='$permissionstring',listorder='$listorder',isstaff='$isstaff' WHERE id='$id'");
		mysqli_close($conn);
	}

	function update_usertag_permissions($id, $permissionstring){
		$conn = sql_connect();

		$id = mysqli_real_escape_string($conn, $id);
		$permissionstring = mysqli_real_escape_string($conn, $permissionstring);

		$result = mysqli_query($conn, "UPDATE usertags SET permissionstring='$permissionstring' WHERE id='$id'");
		mysqli_close($conn);
	}

	function delete_usertag($id){
		$conn = sql_connect();

		$id = mysqli_real_escape_string($conn, $id);

		$result = mysqli_query($conn, "DELETE FROM usertags WHERE id='$id'");
		mysqli_close($conn);
	}

	function make_usertag_default($id){
		$conn = sql_connect();

		$id = mysqli_real_escape_string($conn, $id);

		$result = mysqli_query($conn, "UPDATE usertags SET isdefault='0'");
		$result = mysqli_query($conn, "UPDATE usertags SET isdefault='1' WHERE id='$id'");
		mysqli_close($conn);
	}

	function kick_all_users_from_usertag($id){
		$default_usertag = get_default_usertag()->id;

		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "UPDATE accounts SET tag='$default_usertag' WHERE tag='$id'");
		mysqli_close($conn);
	}

	function get_usertag_permissions_stacked($usertag){ //get all usertags permissions including the permissions of tags below it
		if($usertag == 0){
			return false;
		}
		$usertag = get_usertag_by_id($usertag);

		$permissionstring = "";

		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT permissionstring FROM usertags WHERE listorder<='$usertag->listorder'");
		while($found_usertags[] = mysqli_fetch_object($result));
		mysqli_close($conn);

		foreach($found_usertags as $value){
			if($value){
				$permissionstring = $permissionstring . $value->permissionstring;
			}
		}

		return $permissionstring;
	}

	function tag_has_permission($tag, $perm){ //can a usertag with tihs usertag do something based on the tags allowed permissions?
		if($tag == 0){
			return false;
		}
		$tag = get_usertag_by_id($tag);
		$tag_name = $tag->name;

		$permissions_array = array();

		$conn = sql_connect();

		$permissions_query = mysqli_query($conn, "SELECT permissionstring FROM usertags WHERE listorder <= '$tag->listorder'");
		while($permissions_array[] = mysqli_fetch_object($permissions_query));

		$permissions_string = "";

		foreach($permissions_array as $value_perm){
			if(isset($value_perm->permissionstring)){
				$permissions_string = $permissions_string . $value_perm->permissionstring;
			}
		}

		$permissions_array_exploded = explode(";", $permissions_string);
		foreach($permissions_array_exploded as $value){
			$value = str_replace(" ", "", $value);
			if($value == "*"){
				mysqli_close($conn);
				return true;
			}elseif($value == $perm){
				mysqli_close($conn);
				return true;
			}
		}

		mysqli_close($conn);
		return false;
	}

	function can_tag_do($tag, $canDoString){ //can the user with this usertag do something simply because of his tag?
		if($tag == 0){
			return false;
		}
		$currentAccount = get_current_account();
		$tag = get_usertag_by_id($tag);
		$tag_name = $tag->name;

		$permissions_array_exploded = explode(";", $canDoString);

		foreach($permissions_array_exploded as $value){
			$value = str_replace(" ", "", $value);

			if($value == "all"){
				return true;
			}
			if($value == "staff" && isset($currentAccount->id)){
				if($tag->isstaff){
					return true;
				}
			}
			if($value == "registered" && isset($currentAccount->id)){
				return true;
			}
			if($value == "unregistered" && !isset($currentAccount->id)){
				return true;
			}
			if(is_numeric($value) && isset($currentAccount->id)){
				if(intval($value) == $currentAccount->tag){
					return true;
				}
			}
		}
		return false;
	}
?>
