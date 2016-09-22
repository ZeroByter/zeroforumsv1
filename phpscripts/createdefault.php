<?
	include("getsql.php");
	include("navigatebar.php");
	include("usertags.php");
	include("accounts.php");
	include("forums.php");
	include("logs.php");

	accounts_create_db();
	forums_create_db();
	navigatebar_create_db();
	usertags_create_db();
	logs_create_db();

	if(!get_default_usertag()){
		set_navbar_title("My website title");
		add_navbar_link("Forums", "/forums", "all", 1, "", false, false);
		add_navbar_link("Admin panel", "/admin/panel", "staff", 2, "", true, false);
		add_usertag("User", "forums_createreply;forums_createthread;", 1, false, false);
		add_usertag("Super Admin", "*;", 2, false, true);
		forums_create_forum("My forum", "My forum's description", 1);
		forums_create_subforum(1, "My first sub-forum!", "My sub-forum's description", 1);
		forums_create_subforum(1, "My second sub-forum!", "My awesome sub-forum's description", 2);
		create_account("admin", "admin", "", 2, "", "This is the default admin profile! If you are the website owner, login with the default admin username and password and change this account asap!");
		echo "created default stuffs!";
	}
?>
