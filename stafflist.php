<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/stafflist.css" rel="stylesheet">

<?php
	include("phpscripts/getsql.php");
	include("phpscripts/essentials.php");
	include("phpscripts/accounts.php");
	include("phpscripts/usertags.php");
	include("phpscripts/checkwarnings.php");
	include("phpscripts/forums.php");
?>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space" style="display:none;">

			</td>
			<td id="body_center_space">
				<?php
					foreach(get_all_staff_usertags("DESC") as $value){
						if($value){
							$staff_accounts_string = "";
							$staff_list_id_string = "staff_list_div";
							$all_accounts = get_all_accounts_by_usertag($value->id);
							if(count($all_accounts) > 1){
								foreach($all_accounts as $value2){
									if($value2){
										$staff_display_name = get_account_display_name($value2->id);
										$staff_accounts_string = $staff_accounts_string . "<div class='staff_account_div' data-id='$value2->id'>$staff_display_name</div>";
									}
								}
							}else{
								$staff_accounts_string = "<span class='label label-default'>There is no staff in this usertag</span>";
								$staff_list_id_string = "empty_staff_main_div";
							}
							echo "
								<div class='panel panel-default' id='staff_main_div'>
									<div class='panel-heading'><u><i>$value->name</i></u></div>
									<div class='panel-body' id='$staff_list_id_string'>
										$staff_accounts_string
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

	$(".staff_account_div").click(function(){
		window.location = "profile?id=" + $(this).data("id")
	})
</script>
