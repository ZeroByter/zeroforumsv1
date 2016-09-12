<?
    include("../getsql.php");
    include("../accounts.php");
    include("../logs.php");

    create_log(get_current_account()->username . " logged out");

    account_logout();

    header("Location: " . $_GET["next"]);
?>
