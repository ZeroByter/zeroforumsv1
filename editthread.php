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

	if(!$_GET["id"]){
		echo "<script>window.location = '/forums'</script>";
	}

	$thread = get_forum_by_id($_GET["id"]);
	if($thread->hidden && !tag_has_permission(get_current_usertag(), "forums_viewhiddenthread")){
		echo "<script>window.location = '/forums'</script>";
	}
	$parent = get_forum_by_id($thread->parent);
?>

<span id="getid" data-id="<?echo $_GET["id"];?>"></span>
<span id="getbody" style="display:none;"><?echo $thread->posttext;?></span>
<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_center_space">
				<ol class="breadcrumb">
					<li><a href="/forums">Forums</a></li>
					<?echo ($parent->parent != 0) ? "<li><a href='/viewforum?id=$parent->parent'>" . get_forum_by_id($parent->parent)->name . "</a></li>" : "";?>

					<li><a href="/subforum?id=<?echo $parent->id;?>"><?echo $parent->name;?></a></li>

					<li class="active"><?echo $thread->name;?></li>
				</ol>
				<div class="panel panel-default" style="border-color:#c3c6ff;">
					<div class="panel-body">
						<div class="input-group" style="margin:0 auto;width:98.5%;">
							<span class="input-group-addon">Subject</span>
							<input type="text" class="form-control" id="subject_in" value="<?echo $thread->name;?>">
						</div>
						<div id="thread_body_div">
							<div id="fillin_zeroeditor"></div>
						</div>
						<center>
							<button type="button" class="btn btn-success" id="edit_thread_btn">Edit thread</button>
							<a href="/thread?id=<?echo $thread->id;?>"><button type="button" class="btn btn-default" id="cancel_btn">Cancel</button></a>
						</center>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<?
	if($thread->poster != get_current_account()->id){
		if(!tag_has_permission(get_current_usertag(), "forums_editothers")){
			redirectWindow("/forums");
		}
	}
?>

<script src="/jsscripts/editthread.js"></script>
