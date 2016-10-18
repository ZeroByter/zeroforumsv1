<?
    include("../getsql.php");
    include("../usertags.php");
    include("../accounts.php");
    include("../logs.php");

    @$username = $_POST["username"];
    @$password = $_POST["password"];
    @$displayname = $_POST["displayname"];
    @$email = $_POST["email"];

    if(isset($username) && isset($password)){
        if(get_account_by_username($username) == NULL){
            $id = create_account($username, $password, $displayname, get_default_usertag()->id, $email);
            account_login($id);
            create_log("$username registered and logged into a new account");
            echo "success";
        }else{
            echo "error:Username already taken!";
        }
    }else{
        echo "error:Username or password not found!";
    }
?>
