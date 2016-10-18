<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<script src="/jsscripts/zeroeditor.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/editthread.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/accounts.php");
	include("phpscripts/forums.php");
	include("phpscripts/usertags.php");
	include("phpscripts/essentials.php");
	include("phpscripts/checkwarnings.php");

	if(!$_GET["id"]){
		echo "<script>window.location = '/forums'</script>";
	}

	$reply = get_forum_by_id($_GET["id"]);
	if($reply->hidden && !tag_has_permission(get_current_usertag(), "forums_threadhideunhide")){
		echo "<script>window.location = '/forums'</script>";
	}
	$parent = get_forum_by_id($reply->parent);
?>

<span id="getid" data-id="<?echo $_GET["id"];?>" data-parentid="<?echo $parent->id;?>"></span>
<span id="getbody" style="display:none;"><?echo $reply->posttext;?></span>
<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_center_space">
				<div class="panel panel-default" style="border-color:#c3c6ff;">
					<div class="panel-body">
						<div id="thread_body_div">
							<div id="fillin_zeroeditor"></div>
						</div>
						<center>
							<button type="button" class="btn btn-success" id="edit_reply_btn">Edit reply</button>
							<a href="/thread?id=<?echo $parent->id;?>"><button type="button" class="btn btn-default" id="cancel_btn">Cancel</button></a>
						</center>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<?
	if($reply->poster != get_current_account()->id){
		if(!tag_has_permission(get_current_usertag(), "forums_editothers")){
			redirectWindow("/forums");
		}
	}
?>

<script src="/jsscripts/editreply.js"></script>
