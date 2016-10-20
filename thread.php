<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<script src="/jsscripts/zeroeditor.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/font-awesome.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/thread.css" rel="stylesheet">

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

	$thread = get_forum_by_id($_GET["id"]);
	if($thread->hidden && !tag_has_permission(get_current_usertag(), "forums_threadhideunhide")){
		echo "<script>window.location = '/forums'</script>";
	}
	$parent = get_forum_by_id($thread->parent);
	if(!can_tag_do(get_current_usertag_or_default(), $parent->canview)){
		echo "<script>window.location = '/forums'</script>";
	}
?>

<span id="getid" data-id="<?echo $_GET["id"];?>"></span>
<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_center_space">
				<ol class="breadcrumb">
					<li><a href="/forums">Forums</a></li>
					<?echo ($parent->parent != 0) ? "<li><a href='/viewforum?id=$parent->parent'>" . get_forum_by_id($parent->parent)->name . "</a></li>" : "";?>

					<li><a href="/subforum?id=<?echo $parent->id;?>"><?echo $parent->name;?></a></li>

					<li class="active"><?echo filterXSS($thread->name);?></li>
				</ol>
                <div id="thread_actions">
					<?
						if($thread->locked && tag_has_permission(get_current_usertag(), "forums_replyonlocked")){
							echo "<span class='label label-info'>This thread is locked, but you possess the 'replyonlocked' permission!</span><br><br>";
						}elseif($thread->locked && !tag_has_permission(get_current_usertag(), "forums_replyonlocked")){
							echo "<span class='label label-info'>This thread is locked</span><br><br>";
						}
						if($thread->pinned){
							echo "<span class='label label-info'>This thread is pinned</span><br><br>";
						}
						if($thread->hidden){
							echo "<span class='label label-info'>This thread is hidden, but you possess the 'forums_threadhideunhide' permission!</span><br><br>";
						}
						$lastedited_string = "";
						if($thread->lastedited > $thread->firstposted){
							$editorDisplayName = get_account_display_name($thread->lastediteduser);
							$lastedited_string = " | Last edited on " . timestamp_to_date($thread->lastedited, true) . " by $editorDisplayName";
						}
					?>
                    <button type="button" class="btn btn-success" id="new_reply_btn">Post reply</button>
                    <button type="button" class="btn btn-primary" id="edit_thread_btn">Edit thread</button>
                    <button type="button" class="btn btn-primary" id="lock_thread_btn">Lock thread</button>
                    <button type="button" class="btn btn-primary" id="unlock_thread_btn">Unlock thread</button>
                    <button type="button" class="btn btn-primary" id="pin_thread_btn">Pin thread</button>
                    <button type="button" class="btn btn-primary" id="unpin_thread_btn">Unpin thread</button>
                    <button type="button" class="btn btn-danger" id="delete_thread_btn">Delete thread</button>
					<?
						if(!tag_has_permission(get_current_usertag(), "forums_deletepost")){
							removeHTMLElement("#delete_thread_btn");
						}
					?>
                </div>
				<div class="panel panel-default" style="border-color:#c3c6ff;">
					<div class="panel-heading" style="overflow:auto;background:#dbdcec;">
						<div style="float:left;">
							<?echo filterXSS($thread->name);?>
						</div>
						<div id="thread_replies" style="float:right;">
							<?echo count(get_all_replies($thread->id)) - 1;?> replies
						</div>
					</div>
					<div class="panel-body">
						<div id="thread_poster_div">
							<a href="profile?id=<?echo $thread->poster;?>"><?echo get_account_display_name($thread->poster);?></a><br>
							<?echo get_account_by_id($thread->poster)->posts;?> posts<br>
						</div>
						<div id="thread_body_div" style="float:left;">
							<?echo filterXSS($thread->posttext);?><br>
							<span class='thread_posted_date'>Posted <?echo timestamp_to_date($thread->firstposted, true) . $lastedited_string?></span>
						</div>
					</div>
				</div>
				<span id="fillin_replies"></span>
                <div id="thread_reply" class="panel panel-default">
                    <div class="panel-heading">
                        Post a new reply
                        <button type="button" class="btn btn-default" id="new_reply_close" style="float:right;margin-top:-5px;padding:6px;"><span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                    <div class="panel-body">
                        <div id="fillin_zeroeditor"></div>
                        <button type="button" class="btn btn-default" id="post_reply_btn"><span class="glyphicon glyphicon-ok"></span> Post reply</button>
                    </div>
                </div>
			</td>
		</tr>
	</table>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "forums_createreply") || ($thread->locked && !tag_has_permission(get_current_usertag(), "replyonlocked"))){
		removeHTMLElement("#thread_reply");
		removeHTMLElement("#new_reply_btn");
    }
	if(!tag_has_permission(get_current_usertag(), "forums_threadlockunlock")){
		removeHTMLElement("#lock_thread_btn");
		removeHTMLElement("#unlock_thread_btn");
	}else{
		if($thread->locked){
			hideHTMLElement("#lock_thread_btn");
		}else{
			hideHTMLElement("#unlock_thread_btn");
		}
	}
	if(!tag_has_permission(get_current_usertag(), "forums_threadpinunpin")){
		removeHTMLElement("#pin_thread_btn");
		removeHTMLElement("#unpin_thread_btn");
	}else{
		if($thread->pinned){
			hideHTMLElement("#pin_thread_btn");
		}else{
			hideHTMLElement("#unpin_thread_btn");
		}
	}
	if($thread->poster != get_current_account()->id){
		if(!tag_has_permission(get_current_usertag(), "forums_editothers")){
			removeHTMLElement("#edit_thread_btn");
			removeHTMLElement("#delete_thread_btn");
		}
	}
?>

<script src="/jsscripts/thread.js"></script>
