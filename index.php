<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<script src="/jsscripts/zeroeditor.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/index.css" rel="stylesheet">

<?
	include("phpscripts/getsql.php");
	include("phpscripts/essentials.php");
	include("phpscripts/accounts.php");
	include("phpscripts/usertags.php");
	include("phpscripts/checkwarnings.php");
	include("phpscripts/forums.php");
	include("phpscripts/newsposts.php");
	$lastAccount = get_last_joined_account();

	//file_put_contents("google.com.png", file_get_contents("http://assets.barcroftmedia.com.s3-website-eu-west-1.amazonaws.com/assets/images/recent-images-11.jpg"));
    //file_put_contents("../test.txt", "testing");
    //expiremented with file saving on server! could be very useful for implementing user avatars!
    //file_put_contents("test.txt", file_get_contents("readme.md"));

    if(!file_exists("user_avatars")){
        mkdir("user_avatars");
        //var_dump(1);
    }
?>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space">
				<span id="fillin_selfprofile"></span>
				<div class="panel panel-primary">
					<div class="panel-heading">Most recent user</div>
					<div class="panel-body">
						<div><a href="profile?id=<?echo $lastAccount->id?>"><?echo get_account_display_name($lastAccount->id);?></div>
						<div style="float:right;"><?echo get_human_time($lastAccount->joined) . " ago"?></div>
					</div>
				</div>
			</td>
			<td id="body_center_space">
				<div id="body_news_fixer_div">
					<?
						foreach(newsposts_get_all_posts() as $value){
							if($value){
								if(can_tag_do(get_current_usertag_or_default(), $value->canview)){
									$poster = get_account_by_id($value->poster);
									$posterDisplayName = get_account_display_name($value->poster);
									echo "
										<div class='news_post_main_div'>
											<div class='news_post_title_div'>
												<h4>$value->posttitle</h4>
												<a href='profile?id=$value->poster'>$posterDisplayName</a> posted ".timestamp_to_date($value->releasedate, true)."
											</div>
											<div class='news_post_body_div'>
												".filterXSS($value->posttext)."
											</div>
										</div>
									";
								}
							}
						}
					?>
				</div>
			</td>
			<td id="body_right_space" style="display:none;">

			</td>
		</tr>
	</table>
</div>

<script>
	$(".news_post_body_div").each(function(i,v){
		$(v).html(filter_bbcode($(v).html()))
	})
	$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
		$("#fillin_navbar").html(content)
	})
	$.get("/phpscripts/fillin/getselfprofile", {callerurl: window.location.pathname}, function(content){
		$("#fillin_selfprofile").html(content)
	})
</script>
