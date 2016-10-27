<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/subforums.css" rel="stylesheet">

<?php
	include("phpscripts/getsql.php");
	include("phpscripts/accounts.php");
	include("phpscripts/forums.php");
	include("phpscripts/usertags.php");
	include("phpscripts/essentials.php");
	include("phpscripts/checkwarnings.php");

	if(isset($_GET["parent"])){
		if(get_forum_by_id($_GET["parent"])->type != "subforum"){
			redirectWindow("/forums");
		}
	}else{
		redirectWindow("/forums");
	}
	$parent = get_forum_by_id($_GET["parent"]);
?>

<span id="get_parent_id" data-id="<?phpecho $parent->id;?>"></span>
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

					<?phpecho ($parent->parent != 0) ? "<li><a href='/viewforum?id=$parent->parent'>" . get_forum_by_id($parent->parent)->name . "</a></li>" : "";?>
					<li><a href="/subforum?id=<?phpecho $parent->id;?>"><?phpecho $parent->name;?></a></li>
				</ol>
				<div class="well">
					<h4>New thread:</h4>
					<form id="submit_form" onsubmit="void(0)">
						<div class="input-group">
							<span class="input-group-addon">Subject</span>
							<input required type="text" class="form-control" id="subject_in">
						</div><br>
						<div class="input-group">
							<span class="input-group-addon">Body</span>
							<div class="form-control" id="fillin_zeroeditor"></div>
						</div><br>
						<center>
							<button type="submit" class="btn btn-success" id="post_thread">Post thread</button>
							<button type="button" class="btn btn-default" id="cancel">Cancel</button>
						</center>
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php
	if(!tag_has_permission(get_current_account()->tag, "forums_createthread")){
		redirectWindow("/forums");
	}
?>

<script src="/jsscripts/createthread.js"></script>
