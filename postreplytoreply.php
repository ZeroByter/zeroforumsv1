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

	if(isset($_GET["id"])){
		if(get_forum_by_id($_GET["id"])->type != "reply"){
			redirectWindow("/forums");
		}
	}else{
		redirectWindow("/forums");
	}
	$reply = get_forum_by_id($_GET["id"]);
?>

<span id="get_parent_id" style="display:none;"><?phpecho $reply->id;?></span>
<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space" style="display:none;">

			</td>
			<td id="body_center_space">
				<div class="well">
					<h4>Posting reply to reply:</h4>
					<?phpecho filterXSS($reply->posttext)?>
					<form id="submit_form" onsubmit="void(0)">
						<div class="input-group">
							<span class="input-group-addon">Body</span>
							<div class="form-control" id="fillin_zeroeditor"></div>
						</div><br>
						<center>
							<button type="submit" class="btn btn-success" id="post_reply">Post thread</button>
							<button type="button" class="btn btn-default" id="cancel">Cancel</button>
						</center>
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php
	//if(!tag_has_permission(get_current_account()->tag, "forums_createthread")){
	//	redirectWindow("/forums");
	//}
?>

<script>
	$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
		$("#fillin_navbar").html(content)
	})
	$.get("/phpscripts/fillin/zeroeditor", function(html){
		$("#fillin_zeroeditor").html(html)
		$("#fillin_zeroeditor").css("height", "inherit")
		$("#textarea").attr("required", "")
	})

	$("#submit_form").submit(function(){
		$.post("/phpscripts/requests/post", {parent: $("#get_parent_id").data("id"), subject: $("#subject_in").val(), body: getEditorString()}, function(html){
			window.location = "/thread?id=" + html
		})
		return false
	})
	$("#cancel").click(function(){
		window.location = "/subforum?id=" + $("#get_parent_id").data("id")
	})
</script>
