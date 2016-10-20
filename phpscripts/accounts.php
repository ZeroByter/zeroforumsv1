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
			bio varchar(200) NOT NULL,
			posts int(6) NOT NULL,
			bannedtime int(6) NOT NULL,
			unbantime int(6) NOT NULL,
			bannedmsg varchar(128) NOT NULL,
			bannedby int(6) NOT NULL,
			warnings text NOT NULL,
			iplist text NOT NULL,
			privacy_show_email boolean NOT NULL,
			privacy_use_displayname boolean NOT NULL,
			PRIMARY KEY(id), UNIQUE id (id), KEY id_2 (id))");
		mysqli_close($conn);
	}

	function get_all_accounts(){
        $conn = sql_connect();
		$result = mysqli_query($conn, "SELECT * FROM accounts");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		foreach($array as $value){
			if($value){
				confirm_ban($value->id);
			}
		}

		return $array;
    }

	function get_all_accounts_by_usertag($usertag){
        $conn = sql_connect();
		$usertag = mysqli_real_escape_string($conn, $usertag);
		$result = mysqli_query($conn, "SELECT * FROM accounts WHERE tag='$usertag'");
		mysqli_close($conn);

		while($array[] = mysqli_fetch_object($result));

		foreach($array as $value){
			if($value){
				confirm_ban($value->id);
			}
		}

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
		$result = mysqli_query($conn, "SELECT privacy_use_displayname,username,displayname FROM accounts WHERE id='$id'");
		mysqli_close($conn);
		$object = mysqli_fetch_object($result);

		if($object->privacy_use_displayname){
			if($object->displayname != ""){
				return htmlspecialchars($object->displayname);
			}else{
				return htmlspecialchars($object->username);
			}
		}else{
			return htmlspecialchars($object->username);
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

	function account_login($id){
		$account = get_account_by_id($id);
		add_user_iplist($id);
		setcookie("sessionid", $account->sessionid, 0, "/");
	}

	function account_logout(){
		setcookie("sessionid", "", -1, "/");
	}

	function is_account_logged_in(){

	}

	function generate_sessionid(){
		return bin2hex(openssl_random_pseudo_bytes(32));
	}

	function create_account($username, $password, $displayname, $tag, $email="", $bio="Welcome to my profile!"){
		$conn = sql_connect();
		$sessionid = generate_sessionid();
		$salt = hash("sha256", generate_sessionid());
		$username = mysqli_real_escape_string($conn, htmlspecialchars($username));
		$displayname = mysqli_real_escape_string($conn, htmlspecialchars($displayname));
		$password = mysqli_real_escape_string($conn, hash("sha256", "$password:$salt"));
		$tag = mysqli_real_escape_string($conn, $tag);
		$email = mysqli_real_escape_string($conn, htmlspecialchars($email));
		$bio = mysqli_real_escape_string($conn, htmlspecialchars($bio));
		$time = time();
		mysqli_query($conn, "INSERT INTO accounts(username, password, displayname, tag, email, bio, sessionid, salt, lastactive, joined, privacy_use_displayname) VALUES ('$username', '$password', '$displayname', '$tag', '$email', '$bio', '$sessionid', '$salt', '$time', '$time', '1')");
		$lastid = mysqli_insert_id($conn);
		mysqli_close($conn);
		return $lastid;
	}

	function assign_usertag($userid, $usertagid){
		$conn = sql_connect();
		$userid = mysqli_real_escape_string($conn, $userid);
		$usertagid = mysqli_real_escape_string($conn, $usertagid);
		mysqli_query($conn, "UPDATE accounts SET tag='$usertagid' WHERE id='$userid'");
		mysqli_close($conn);
	}

	function add_user_posts($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$time = time();
		mysqli_query($conn, "UPDATE accounts SET posts=posts+1,lastactive='$time' WHERE id='$id'");
		mysqli_close($conn);
	}

	function get_user_warnings($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT warnings FROM accounts WHERE id='$id'");
		mysqli_close($conn);
		$warningsArray = json_decode(mysqli_fetch_object($result)->warnings);

		if(gettype($warningsArray) == "NULL"){
			return array();
		}else{
			return $warningsArray;
		}
	}

	function add_user_warning($id, $reason){
		$warningsArray = get_user_warnings($id);

		array_push($warningsArray, array(
			"warnedby" => get_current_account()->id,
			"time" => time(),
			"message" => $reason,
		));

		$warningsArray = json_encode($warningsArray);

		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$reason = mysqli_real_escape_string($conn, htmlspecialchars($reason));
		mysqli_query($conn, "UPDATE accounts SET warnings='$warningsArray' WHERE id='$id'");
		mysqli_close($conn);
	}

	function okay_warnings($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_query($conn, "UPDATE accounts SET warnings='[]' WHERE id='$id'");
		mysqli_close($conn);
	}

	function unban_user($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_query($conn, "UPDATE accounts SET bannedtime='0',unbantime='0',bannedmsg='',bannedby='0' WHERE id='$id'");
		mysqli_close($conn);
	}

	function issue_user_ban($id, $reason, $time){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$reason = mysqli_real_escape_string($conn, htmlspecialchars($reason));
		$time = mysqli_real_escape_string($conn, htmlspecialchars($time));
		$currTime = time();
		$unbanTime = $currTime + $time;
		$currAccount = get_current_account()->id;
		mysqli_query($conn, "UPDATE accounts SET bannedtime='$currTime',unbantime='$unbanTime',bannedmsg='$reason',bannedby='$currAccount' WHERE id='$id'");
		mysqli_close($conn);
	}

	function confirm_ban($id){
		$account = get_account_by_id($id);
		if($account->bannedby != 0){
			if($account->unbantime < time()){
				$conn = sql_connect();
				mysqli_query($conn, "UPDATE accounts SET bannedtime='0',unbantime='0',bannedmsg='',bannedby='0' WHERE id='$account->id'");
				mysqli_close($conn);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function change_bio($text){
		$conn = sql_connect();
		$text = mysqli_real_escape_string($conn, htmlspecialchars($text));
		$currAccount = get_current_account();
		mysqli_query($conn, "UPDATE accounts SET bio='$text' WHERE id='$currAccount->id'");
		mysqli_close($conn);
	}

	function get_user_iplist($id){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$result = mysqli_query($conn, "SELECT iplist FROM accounts WHERE id='$id'");
		mysqli_close($conn);
		$iplistArray = json_decode(mysqli_fetch_object($result)->iplist);

		if(gettype($iplistArray) == "NULL"){
			return array();
		}else{
			return $iplistArray;
		}
	}

	function does_list_contain_ip($list, $ip){
		foreach($ip as $value){
			foreach($list as $value2){
				if($value2->ip == $value->ip){
					return true;
				}
			}
		}
		return false;
		/*foreach($list as $value){
			if($value->ip == $ip){
				return true;
			}
		}
		return false;*/
	}

	function get_all_same_ip_accounts($id, $exempid=0){
		$returnlist = array();
		$iplist = get_user_iplist($id);
		foreach(get_all_accounts() as $value){
			if($value){
				if($exempid > 0){
					if($exempid == $value->id){
						continue;
					}
				}
				if(does_list_contain_ip(get_user_iplist($value->id), $iplist)){
					$returnlist[] = $value;
				}
			}
		}
		return $returnlist;
	}

	function add_user_iplist($id){
		$iplistArray = get_user_iplist($id);
		$isAlreadyStored = false;

		foreach($iplistArray as $key=>$value){
			if($value->ip == $_SERVER['REMOTE_ADDR']){
				$isAlreadyStored = true;
				$value->lastseen = time();
			}
		}

		if($isAlreadyStored == false){
			array_push($iplistArray, array(
				"ip" => $_SERVER['REMOTE_ADDR'],
				"firstseen" => time(),
				"lastseen" => time(),
			));
		}

		$iplistArray = json_encode($iplistArray);

		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		mysqli_query($conn, "UPDATE accounts SET iplist='$iplistArray' WHERE id='$id'");
		mysqli_close($conn);
	}

	function change_user_displayname($id, $displayname){
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$displayname = mysqli_real_escape_string($conn, htmlspecialchars($displayname));
		mysqli_query($conn, "UPDATE accounts SET displayname='$displayname' WHERE id='$id'");
		mysqli_close($conn);
	}

	function change_user_password($id, $password){
		$account = get_account_by_id($id);
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$password = mysqli_real_escape_string($conn, hash("sha256", "$password:$account->salt"));
		mysqli_query($conn, "UPDATE accounts SET password='$password' WHERE id='$id'");
		mysqli_close($conn);
	}

	function change_user_email($id, $email){
		$account = get_account_by_id($id);
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$email = mysqli_real_escape_string($conn, htmlspecialchars($email));
		mysqli_query($conn, "UPDATE accounts SET email='$email' WHERE id='$id'");
		mysqli_close($conn);
	}

	function change_user_privacy($id, $show_email, $use_displayname){
		$account = get_account_by_id($id);
		$conn = sql_connect();
		$id = mysqli_real_escape_string($conn, $id);
		$show_email = mysqli_real_escape_string($conn, $show_email);
		$use_displayname = mysqli_real_escape_string($conn, $use_displayname);
		mysqli_query($conn, "UPDATE accounts SET privacy_show_email='$show_email',privacy_use_displayname='$use_displayname' WHERE id='$id'");
		mysqli_close($conn);
	}
?>
