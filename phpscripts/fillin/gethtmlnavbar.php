<?
	include("../getsql.php");
	include("../accounts.php");
	include("../usertags.php");
	include("../navigatebar.php");
?>

<nav id="nav_bar" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_navbar_collapse" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/"><?echo get_navbar_title()->text;?></a>
		</div>

		<div class="collapse navbar-collapse" id="main_navbar_collapse">
			<ul class="nav navbar-nav">
				<?
                    $usertag = get_default_usertag()->id;
					if(isset(get_current_account()->id)){
						$usertag = get_current_account()->tag;
					}

					foreach(get_navbar_links() as $value){
						if($value && isset($_GET["url"])){
							$classStr = ($_GET["url"] == $value->link) ? "active" : "";
							$canview = can_tag_do(get_current_usertag_or_default(), $value->canview);

							if($canview){
								if($value->link == "/admin/panel"){
									echo "<li class='$classStr'><a href='javascript:void(0)' class='navbar_newwindow' data-link='$value->link' data-width='800' data-height='600'>$value->text</a></li>";
								}else{
									echo "<li class='$classStr'><a href='$value->link'>$value->text</a></li>";
								}
							}
						}
					}
				?>
			</ul>
		</div>
	</div>
</nav>

<script>
	$(".navbar_newwindow").click(function(){
		var w = $(this).data("width")
		var h = $(this).data("height")

		var width = window.innerWidth
		var height = window.innerHeight
		var left = ((width / 2) - (w / 2))
		var top = ((height / 2) - (h / 2))

		var newWindow = window.open($(this).data("link"), "_blank", "width=" + w + ",height=" + h + ",top=" + top + ",left=" + left);
		newWindow.focus()
	})
</script>
