<?
	function sql_connect(){
		$conn = mysqli_connect("your ip", "your user", "your password", "your database");
		return $conn;
	}
?>
