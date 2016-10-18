<?
    include("../getsql.php");
    include("../accounts.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["show_email"]) && isset($_POST["use_displayname"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $account = get_current_account();
        if($username == $account->username && hash("sha256", "$password:$account->salt") == $account->password){
            $show_email = ($_POST["show_email"] === "true") ? true : false;
            $use_displayname = ($_POST["use_displayname"] === "true") ? true : false;
            change_user_privacy($account->id, $show_email, $use_displayname);
            echo "success";
        }else{
            echo "error:incorrect login information!";
        }
    }else{
        echo "error:no information supplied!";
    }
?>
