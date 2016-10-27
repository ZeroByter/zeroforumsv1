<?php
	function sql_connect(){
		$conn = mysqli_connect("localhost", "main_use", "WQV5bc5uCGfM7DdW", "zeroforums");
		return $conn;
	}
?>
