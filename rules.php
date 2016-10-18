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
	include("phpscripts/rules.php");
?>

<style>
	.rule_category_main_div{
		margin-left: 20px;
	}
	.rule_category_name_div{
		font-size: 22px;
	}
	.rule_category_name_date{
		font-size: 14px;
	}
	.rule_category_list{
		margin: 10px 0px;
	}
</style>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space" style="display:none;">

			</td>
			<td id="body_center_space">
				<?
					if(count(get_all_rule_categories()) - 1 === 0){
						echo "<center><span class='label label-danger'>There are no rules!</span></center>";
					}

					foreach(get_all_rule_categories() as $value){
						if($value){
							$rules_string = "";
							foreach(get_all_rules_in_category($value->id) as $value2){
								if($value2){
									$rules_string = $rules_string . "<li>$value2->text</li>";
								}
							}
							$displayName = get_account_display_name($value->poster);

							echo "
								<div class='rule_category_main_div'>
									<div class='rule_category_name_div'>
										<i>$value->text</i><br>
										<span class='rule_category_name_date'>enacted by $displayName on the ".timestamp_to_date($value->postdate, true)."</span>
									</div>
									<div class='rule_category_list'>
										<ol>
											$rules_string
										</ol>
									</div>
								</div>
							";
						}
					}
				?>
			</td>
			<td id="body_right_space" style="display:none;">

			</td>
		</tr>
	</table>
</div>

<script>
	$.get("/phpscripts/fillin/gethtmlnavbar", {url: window.location.pathname}, function(content){
		$("#fillin_navbar").html(content)
	})
</script>
