<?
    include("../getsql.php");
    include("../accounts.php");
    include("../usertags.php");
    include("../forums.php");
    include("../logs.php");

    if(isset($_POST["text"])){
        $currAccount = get_current_account();
        $old_bio = $currAccount->bio;
        change_bio($_POST["text"]);
        create_log("$currAccount->username changed his bio from '$old_bio' to '".get_current_account()->bio."'");
    }else{
        echo "error:missing text";
    }
?>
