<?
    include("../getsql.php");
    include("../accounts.php");
    include("../logs.php");

    $conn = sql_connect();
    @$username = mysqli_real_escape_string($conn, $_POST["username"]);
    @$password = mysqli_real_escape_string($conn, $_POST["password"]);
    mysqli_close($conn);

    if(isset($username) && isset($password)){
        $account = null;
        if(get_account_by_username($username)){
            $account = get_account_by_username($username);
        }elseif(get_account_by_email($username)){
            $account = get_account_by_username($username);
        }else{
            echo "error:No account found by that username!";
        }

        if($account != null){
            if(hash("sha256", "$password:$account->salt") == $account->password){
                account_login($username);
                echo "success";
                create_log("$username logged in");
            }else{
                echo "error:Wrong password!";
                create_log($_SERVER["REMOTE_ADDR"] . " attempted to login in with username: $username, password: $password");
            }
        }else{
            create_log($_SERVER["REMOTE_ADDR"] . " attempted to login in with a non-existant account: username: $username, password: $password");
        }
    }else{
        echo "error:No username and password found!";
    }
?>
