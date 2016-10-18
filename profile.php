<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<script src="/jsscripts/zeroeditor.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/profile.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/essentials.php");
	include("phpscripts/accounts.php");
	include("phpscripts/usertags.php");
	include("phpscripts/checkwarnings.php");
	include("phpscripts/forums.php");

	if(!$_GET["id"]){
		redirectWindow("/");
	}
	@$account = get_account_by_id($_GET["id"]);
	if(!$account){
		redirectWindow("/");
	}else{
		$displayName = get_account_display_name($account->id);
		$usertag = get_usertag_by_id($account->tag);
	}
?>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space" style="display:none;">

			</td>
			<td id="body_center_space">
				<div id="profile_body_div">
					<div class="panel panel-default" style="border-color:#cccccc;">
						<div class="panel-body">
							<div style="float:right;">
								<h5><?echo $usertag->name;?></h5>
							</div>
							<div style="float:left;">
								<h2><?echo filterXSS($displayName)?></h2>
								<h4 style="margin-top:6px;" id="bio_text"><?echo filterXSS($account->bio)?></h4>
								<input type="text" class="form-control" id="bio_input" value="<?echo $account->bio?>" style="display:none;">
							</div>
						</div>
					</div>
					<div class="panel panel-default" style="border-color:#cccccc;">
						<div class="panel-body" style="padding-bottom:6px;">
							<h5>
								<p>Joined on: <?echo timestamp_to_date($account->joined);?></p>
								<p>Last seen: <?echo get_human_time($account->lastactive) . " ago";?></p>
								<p>Posts: <?echo filterXSS($account->posts);?></p>
								<p><?echo ($account->email === "" || $account->privacy_show_email == false) ? "" : "Email: " . filterXSS($account->email);?></p>
							</h5>
						</div>
					</div>
					<div class="panel panel-default" style="border-color:#cccccc;">
						<div class="panel-body" id="activity_container_div">
							<center><h4><?echo (count(get_all_posts_by_poster($account->id)) - 1 === 0) ? "No forums activity" : "Forums activity";?></h4></center>
							<?
								foreach(get_all_posts_by_poster($account->id) as $value){
									if($value){
										//if(!can_tag_do(get_current_usertag_or_default(), $value->canview)){
							            //    continue;
							            //}
										//get canview permissions of subforum and continue if viewer cant see

										$charLimit = 60;
										$text = filterXSS(substr($value->posttext, 0, $charLimit));
										if(strlen($value->posttext) >= $charLimit){
											$text = "$text...";
										}

										if($value->type == "thread"){
											$title = filterXSS($value->name);
											$subforum = get_forum_by_id($value->parent);
											$forum = get_forum_by_id($subforum->parent);
											$id = $value->id;
										}
										if($value->type == "reply"){
											$thread = get_forum_by_id($value->parent);
											$title = filterXSS($thread->name);
											$subforum = get_forum_by_id($thread->parent);
											$forum = get_forum_by_id($subforum->parent);
											$id = $thread->id;
										}

										echo "
											<div class='activity_main_div' data-id='$id'>
												<div class='activity_title_div'>
													$title
												</div>
												<div class='activity_location_div'>
													<i>$forum->name / $subforum->name</i>
												</div>
												<div class='activity_text'>
													$text
												</div>
											</div>
										";
									}
								}
							?>
						</div>
					</div>
				</div>
			</td>
			<?
				$punishment_view_display = "none"; //none or table-cell
				if($account->unbantime > 0){
					$punishment_view_display = "table-cell";
				}
				if(count(get_user_warnings($account->id)) != 0){
					$punishment_view_display = "table-cell";
				}
			?>
			<td id="body_right_space" style="display:<?echo $punishment_view_display?>;">
				todo: view only if user is banned
			</td>
		</tr>
	</table>
</div>

<script>
	$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
		$("#fillin_navbar").html(content)
	})
	$(".activity_main_div").click(function(){
		window.location = "/thread?id=" + $(this).data("id")
	})
	$(".activity_text").each(function(i,v){
		$(v).html(remove_bbcode($(v).html()))
	})

	$("#bio_text").click(function(){
		$(this).css("display", "none")
		$("#bio_input").css("display", "block")
		$("#bio_input").focus()
	})
	$("#bio_input").keydown(function(e){
		if(e.keyCode == 13){
			$("#bio_text").css("display", "block")
			$("#bio_input").css("display", "none")
			$.post("/phpscripts/requests/changebio", {text: $("#bio_input").val()}, function(html){
				console.log(html)
				$("#bio_text").html($("#bio_input").val())
			})
		}
	})
</script>
