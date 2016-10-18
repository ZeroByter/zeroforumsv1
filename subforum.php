<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/subforums.css" rel="stylesheet">

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

	$subforum = get_forum_by_id($_GET["id"]);
	if(isset(get_forum_by_id($subforum->parent)->name) === false){
		redirectWindow("/forums");
	}
?>

<span id="getid" data-id="<?echo $_GET["id"];?>"></span>
<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space">
                <span id="fillin_latestthreads"></span>
			</td>
			<td id="body_center_space">
				<ol class="breadcrumb">
					<li><a href="/forums">Forums</a></li>
					<?echo ($subforum->id != 0) ? "<li><a href='/viewforum?id=$subforum->parent'>" . get_forum_by_id($subforum->parent)->name . "</a></li>" : "";?>
					<li class="active"><?echo $subforum->name;?></li>
				</ol>
				<div class="well" style="padding-top:0px;">
					<div id="forum_actions">
						<a href="/postthread?parent=<?echo $subforum->id;?>"><button type="button" class="btn btn-success" id="new_thread_btn">Post thread</button></a>
						<button type="button" class="btn btn-info" id="search_btn">Search forum</button>
						<input type="text" class="form-control" style="width:200px;display:inline;">
					</div>
					<span id="fillin_pinnedthreads"></span>
					<span id="fillin_threads"></span>
				</div>
			</td>
		</tr>
	</table>
</div>

<?
	if(!tag_has_permission(get_current_account()->tag, "forums_createthread")){
		echo "<script id='remove_script'>$('#forum_actions').children()[0].remove();$('#remove_script').remove()</script>";
	}
?>

<script src="/jsscripts/subforums.js"></script>
