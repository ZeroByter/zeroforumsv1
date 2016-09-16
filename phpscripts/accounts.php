<?
	function accounts_create_db(){
		$conn = sql_connect();
		mysqli_query($conn, "CREATE TABLE IF NOT EXISTS accounts(
			id int(6) NOT NULL auto_increment,
			lastactive int(8) NOT NULL,
			joined int(8) NOT NULL,
			sessionid varchar(64) NOT NULL,
			username varchar(64) NOT NULL,
			displayname varchar(64) NOT NULL,
			password varchar(64) NOT NULL,
			salt varchar(64) NOT NULL,
			tag int(6) NOT NULL,
			email varchar(128) NOT NULL,
			bio varchar(128) NOT NULL,
			posts int(6) NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
	}

	function get_all_accounts(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM accounts");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

	function get_all_accounts_by_usertag($usertag){
        $conn = sql_connect();
		$usertag = mysqli_real_escape_string($conn, $usertag);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE tag='$usertag'");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		return $array;
    }

	function get_account_by_id($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE id='$id'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_account_by_username($username){
		$conn = sql_connect();
		$username = mysqli_real_escape_string($conn, $username);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE username='$username'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_account_by_email($email){
		$conn = sql_connect();
		$email = mysqli_real_escape_string($conn, $email);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE email='$email'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_account_by_sessionid($sessionid){
		$conn = sql_connect();
		$sessionid = mysqli_real_escape_string($conn, $sessionid);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE sessionid='$sessionid'");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_current_account(){
		if(isset($_COOKIE["sessionid"])){
			return get_account_by_sessionid($_COOKIE["sessionid"]);
		}
	}

	function get_current_usertag(){
		if(isset(get_current_account()->id)){
			return get_current_account()->tag;
		}else{
			return null;
		}
	}

	function get_current_usertag_or_default(){
		if(isset(get_current_account()->id)){
			return get_current_account()->tag;
		}else{
			return get_default_usertag()->id;
		}
	}

	function get_last_joined_account(){
		$conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM accounts ORDER BY joined DESC");
		mysqli_close($conn);

		return mysqli_fetch_object($result);
	}

	function get_account_display_name($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT username,displayname FROM accounts WHERE id='$id'");
		mysqli_close($conn);
		$object = mysqli_fetch_object($result);

		if($object->displayname != ""){
			return $object->displayname;
		}else{
			return $object->username;
		}
	}

	function get_account_tag($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT tag FROM accounts WHERE id='$id'");
		mysqli_close($conn);
		$object = mysqli_fetch_object($result);

		if($object->tag){
			return $object->tag;
		}else{
			return get_default_usertag();
		}
	}

	function account_login($username){
		$account = get_account_by_username($username);
		setcookie("sessionid", $account->sessionid, 0, "/");
	}

	function account_logout(){
		setcookie("sessionid", "", -1, "/");
	}

	function generate_sessionid(){
		return bin2hex(openssl_random_pseudo_bytes(32));
	}

	function create_account($username, $password, $displayname, $tag, $email="", $bio="Welcome to my profile!"){
		$conn = sql_connect();
		$sessionid = generate_sessionid();
		$salt = hash("sha256", generate_sessionid());
		$username = mysqli_real_escape_string($conn, $username);
		$displayname = mysqli_real_escape_string($conn, $displayname);
		$password = hash("sha256", $password);
		$password = mysqli_real_escape_string($conn, "$password:$salt");
		$tag = mysqli_real_escape_string($conn, $tag);
		$email = mysqli_real_escape_string($conn, $email);
		$bio = mysqli_real_escape_string($conn, $bio);
		$time = time();
		mysqli_query($conn, "INSERT INTO accounts(username, password, displayname, tag, email, bio, sessionid, salt, lastactive, joined) VALUES ('$username', '$password', '$displayname', '$tag', '$email', '$bio', '$sessionid', '$salt', '$time', '$time')");
		mysqli_close($conn);
	}

	function assign_usertag($userid, $usertagid){
		$conn = sql_connect();
		$userid = mysqli_real_escape_string($conn, $userid);
		$usertagid = mysqli_real_escape_string($conn, $usertagid);
		mysqli_query($conn, "UPDATE accounts SET tag='$usertagid' WHERE id='$userid'");
		mysqli_close($conn);
	}

	function issue_user_ban($id, $reason, $time){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$reason = mysqli_real_escape_string($conn, $reason);
		$time = mysqli_real_escape_string($conn, $time);
		$currTime = time();
		$unbanTime = $currTime + $time;
		$currAccount = get_current_account()->id;
		mysqli_query($conn, "UPDATE accounts SET bannedtime='$currTime',unbantime='$unbanTime',bannedmsg='$reason',bannedby='$currAccount' WHERE id='$id'");
		mysqli_close($conn);
	}
?>
