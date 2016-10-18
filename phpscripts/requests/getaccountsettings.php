<?
    include("../getsql.php");
    include("../accounts.php");

    if(isset($_GET["username"]) && isset($_GET["password"])){
        $username = $_GET["username"];
        $password = $_GET["password"];
        $account = get_current_account();
        if($username == $account->username && hash("sha256", "$password:$account->salt") == $account->password){
            echo json_encode(array(
                "correct" => true,
                "displayname" => $account->displayname,
                "email" => $account->email,
                "show_email" => $account->privacy_show_email,
                "use_displayname" => $account->privacy_use_displayname,
            ));
        }else{
            echo json_encode(array(
                "correct" => false,
                "displayname" => "",
                "email" => "",
                "show_email" => "",
                "use_displayname" => "",
            ));
            return;
        }
    }else{
        echo "error:no information supplied!";
    }
?>
