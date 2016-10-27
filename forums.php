<script src="/jsscripts/jquery.js"></script>
<script src="/jsscripts/bootstrap.js"></script>
<link href="/stylesheets/bootstrap.css" rel="stylesheet">
<link href="/stylesheets/base.css" rel="stylesheet">
<link href="/stylesheets/forums.css" rel="stylesheet">

<?php
	include("phpscripts/getsql.php");
	include("phpscripts/accounts.php");
	include("phpscripts/forums.php");
	include("phpscripts/essentials.php");
	include("phpscripts/checkwarnings.php");
?>

<div id="main_body">
	<span id="fillin_navbar"></span>
	<table id="main_body_table">
		<tr>
			<td id="body_left_space">
				<span id="fillin_latestthreads"></span>
			</td>
			<td id="body_center_space">
				<ol class="breadcrumb">
					<li class="active">Forums</li>
				</ol>
				<span id="fillin_forums"></span>
			</td>
		</tr>
	</table>
</div>

<script src="/jsscripts/forums.js"></script>
