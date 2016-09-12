<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/thread.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/accounts.php");
	include("phpscripts/forums.php");
	include("phpscripts/usertags.php");

	if(!$_GET["id"]){
		echo "<script>window.location = '/forums'</script>";
	}

	$thread = get_forum_by_id($_GET["id"]);
	if($thread->hidden && !tag_has_permission(get_current_usertag(), "viewhiddenthread")){
		echo "<script>window.location = '/forums'</script>";
	}
	$parent = get_forum_by_id($thread->parent);
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

					<li class="active"><?echo $thread->name;?></li>
				</ol>
                <div id="thread_actions">
					<?
						if($thread->locked && tag_has_permission(get_current_usertag(), "replyonlocked")){
							echo "<span class='label label-info'>This thread is locked, but you possess the 'replyonlocked' permission!</span><br><br>";
						}elseif($thread->locked && !tag_has_permission(get_current_usertag(), "replyonlocked")){
							echo "<span class='label label-info'>This thread is locked</span><br><br>";
						}
						if($thread->pinned){
							echo "<span class='label label-info'>This thread is pinned</span><br><br>";
						}
						if($thread->hidden){
							echo "<span class='label label-info'>This thread is hidden, but you possess the 'viewhiddenthread' permission!</span><br><br>";
						}
					?>
                    <button type="button" class="btn btn-success" id="new_reply_btn">Post reply</button>
                </div>
				<div class="panel panel-default" style="border-color:#c3c6ff;">
					<div class="panel-heading" style="overflow:auto;background:#dbdcec;">
						<div style="float:left;">
							<?echo $thread->name;?>
						</div>
						<div id="thread_replies" style="float:right;">
							0 replies
						</div>
					</div>
					<div class="panel-body">
						<div id="thread_poster_div">
							<a href="#"><?echo get_account_display_name($thread->poster);?></a><br>
							<?echo get_account_by_id($thread->poster)->posts;?> posts<br>
						</div>
						<div style="float:left;">
							<?echo $thread->posttext;?>
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
                        <textarea name="editor" id="editor"></textarea><br>
                        <button type="button" class="btn btn-default" id="post_reply_btn"><span class="glyphicon glyphicon-ok"></span> Post reply</button>
                    </div>
                </div>
			</td>
		</tr>
	</table>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "createreply") || ($thread->locked && !tag_has_permission(get_current_usertag(), "replyonlocked"))){
        echo "<script id='remove_script'>$('#thread_reply').remove();$('#new_reply_btn').remove();$('#remove_script').remove()</script>";
    }
?>

<script src="/jsscripts/thread.js"></script>
