<?php
    include("../getsql.php");
    include("../accounts.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["displayname"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $account = get_current_account();
        if($username == $account->username && hash("sha256", "$password:$account->salt") == $account->password){
            change_user_displayname($account->id, $_POST["displayname"]);
            echo "success";
        }else{
            echo "error:incorrect login information!";
        }
    }else{
        echo "error:no information supplied!";
    }
?>
