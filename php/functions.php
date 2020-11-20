<?php 
	
	$link = mysqli_connect("localhost", "root", "root", "z95356dh_data");
	if (mysqli_connect_errno()) {
		printf("Соединение не удалось: %s\n", mysqli_connect_error());
		exit();
	}
	
	if($_POST["add"] == 1){
		mysqli_query($link, "INSERT INTO `Information` (name, price, date) VALUES ('".$_POST["name"]."', '".$_POST["price"]."', '".$_POST["date"]."')");
		
	}
	else{
		mysqli_query($link, "DELETE FROM `Information` WHERE id IN (".$_POST["massids"].")");
		
	}
	mysqli_close($link);
	
	
?>

