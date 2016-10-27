<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">

<?php
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
	.rule_category_list{
		margin: 10px 0px;
	}
</style>

<?php
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

			echo "
				<div class='rule_category_main_div'>
					<div class='rule_category_name_div'><i>$value->text</i></div>
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
