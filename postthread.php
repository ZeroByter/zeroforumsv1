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

	if(isset($_GET["parent"])){
		if(get_forum_by_id($_GET["parent"])->type != "subforum"){
			redirectWindow("/forums");
		}
	}else{
		redirectWindow("/forums");
	}
	$parent = get_forum_by_id($_GET["parent"]);
?>

<span id="get_parent_id" data-id="<?echo $parent->id;?>"></span>
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

					<?echo ($parent->parent != 0) ? "<li><a href='/viewforum?id=$parent->parent'>" . get_forum_by_id($parent->parent)->name . "</a></li>" : "";?>
					<li><a href="/subforum?id=<?echo $parent->id;?>"><?echo $parent->name;?></a></li>
				</ol>
				<div class="well">
					<h4>New thread:</h4>
					<div class="input-group">
						<span class="input-group-addon">Subject</span>
						<input type="text" class="form-control" id="subject_in">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon">Body</span>
						<div class="form-control" id="fillin_zeroeditor">
						</div>
					</div><br>
					<center>
						<button type="button" class="btn btn-success" id="post_thread">Post thread</button>
						<button type="button" class="btn btn-default" id="cancel">Cancel</button>
					</center>
				</div>
			</td>
		</tr>
	</table>
</div>

<?
	if(!tag_has_permission(get_current_account()->tag, "forums_createthread")){
		redirectWindow("/forums");
	}
?>

<script src="/jsscripts/createthread.js"></script>
