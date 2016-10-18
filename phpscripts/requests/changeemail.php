<?
    include("../getsql.php");
    include("../accounts.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["newemail"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $account = get_current_account();
        if($username == $account->username && hash("sha256", "$password:$account->salt") == $account->password){
            change_user_email($account->id, $_POST["newemail"]);
            echo "success";
        }else{
            echo "error:incorrect login information!";
        }
    }else{
        echo "error:no information supplied!";
    }
?>
