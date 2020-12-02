<?php 
	
	class ControlBD {
    
   
   
   function add() 
{
	
	$link = mysqli_connect("localhost", "root", "root", "z95356dh_data");
	if (mysqli_connect_errno()) {
		printf("Соединение не удалось: %s\n", mysqli_connect_error());
		exit();
	}
	
	mysqli_query($link, "INSERT INTO `Information` (name, price, date) VALUES ('".$_POST["name"]."', '".$_POST["price"]."', '".$_POST["date"]."')");
	
	mysqli_close($link);

}
function delete() 
{
	$link = mysqli_connect("localhost", "root", "root", "z95356dh_data");
	if (mysqli_connect_errno()) {
		printf("Соединение не удалось: %s\n", mysqli_connect_error());
		exit();
	}
	
    mysqli_query($link, "DELETE FROM `Information` WHERE id IN (".$_POST["massids"].")");
	
	mysqli_close($link);
}
function show() 
{
$link = mysqli_connect("localhost", "root", "root", "z95356dh_data");
	
	/* проверка соединения */
	if (mysqli_connect_errno()) {
		printf("Соединение не удалось: %s\n", mysqli_connect_error());
		exit();
	}
	
	$result_str = "";
	if(isset($_GET["date"])){
		if ($result = mysqli_query($link, "SELECT * FROM `Information` WHERE date >= '".$_GET["date"]."'")) {
			
			/* определение числа рядов в выборке */
			$row_cnt = mysqli_num_rows($result);
			
			
			while ($row = $result->fetch_row()) {
				$result_str = $result_str.$row[0].",".$row[1].",".$row[2].",".$row[3]."!";
			}
			
			/* закрытие выборки */
			mysqli_free_result($result);
		}
		
		}else{
		if ($result = mysqli_query($link, "SELECT * FROM Information ")) {
			
			/* определение числа рядов в выборке */
			$row_cnt = mysqli_num_rows($result);
			
			
			while ($row = $result->fetch_row()) {
				$result_str = $result_str.$row[0].",".$row[1].",".$row[2].",".$row[3]."!";
			}
			
			/* закрытие выборки */
			mysqli_free_result($result);
		}
	}
	
	
	/* закрытие соединения */
	mysqli_close($link);
	$result_str = substr($result_str,0,-1);
	
	return $result_str;
}
}
	$ControlBD = new ControlBD;
	
	if($_POST["option"] == 1){
		$ControlBD->add();
		
	}
	if($_POST["option"] == 2){
		$ControlBD->add();
		
	}
	if($_POST["option"] == 3){
		echo $ControlBD->show();
		
	}
	
	
	
?>

