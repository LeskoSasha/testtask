<?php 
	function add() 
{
	$link = mysqli_connect("localhost", "z95356dh_data", "Eh3BUpyu", "z95356dh_data");

/* проверка соединения */
if (mysqli_connect_errno()) {
    printf("Соединение не удалось: %s\n", mysqli_connect_error());
    exit();
}
mysqli_query($link, "INSERT INTO `Information` (name, price, date) VALUES ('".$_POST["name"]."', '".$_POST["price"]."', '".$_POST["date"]."')")

/* закрытие соединения */
mysqli_close($link);

}
function del() 
{
	$link = mysqli_connect("localhost", "z95356dh_data", "Eh3BUpyu", "z95356dh_data");

/* проверка соединения */
if (mysqli_connect_errno()) {
    printf("Соединение не удалось: %s\n", mysqli_connect_error());
    exit();
}

mysqli_query($link, "DELETE FROM `Information` WHERE id IN (".$_POST["massids"].")")

/* закрытие соединения */
mysqli_close($link);

}
	
	if(isset($_POST["name"])){
	add();
	echo "added";
		}
		else{
		del() ;
		echo "delled";
			}


	?>

