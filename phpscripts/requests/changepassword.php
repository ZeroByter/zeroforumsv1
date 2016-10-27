<?php
    include("../getsql.php");
    include("../accounts.php");
    include("../logs.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["newpassword"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $account = get_current_account();
        if($username == $account->username && hash("sha256", "$password:$account->salt") == $account->password){
            create_log(get_current_account()->username . " edited his own password");
            change_user_password($account->id, $_POST["newpassword"]);
            echo "success";
        }else{
            echo "error:incorrect login information!";
        }
    }else{
        echo "error:no information supplied!";
    }
?>
