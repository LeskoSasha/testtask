<?php 
	
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
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Graphics</title>
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		
		
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/javascript-calendar.css">
		<link rel="stylesheet" href="css/tavo-calendar.css">
		<link rel="stylesheet" href="css/Chart.min.css">
		<!-- Don't use this in production: -->
		
	</head>
	<body>
		
		<div className="maindata">
			<h1>Graphic costs one by one</h1>
			
		</div>
		<canvas id="myChart"></canvas>
		<div className="maindata">
			<h1>Graphic costs (summary prepeare costs)</h1>
			
		</div>
		<canvas id="myChart2"></canvas>
		<?php 
			echo "<span id='php_info' style='display:none'>".$result_str."</span>"
		?>
		<script src="js/tavo-calendar.js"></script>
		<script src="js/Chart.min.js"></script>
		
		<script type="text/javascript">
			
			
			var fake_id=0;
			var php_info = document.getElementById("php_info").innerHTML;
			
			var php_info_arr=[];
			php_info_arr = php_info.split("!");
			var php_info_arr_el=[];
			var php_info_arr_finale=[];
			for (var i=0; i < php_info_arr.length  ;i++){
				php_info_arr_el = php_info_arr[i].split(",");
				php_info_arr_el[0] = parseFloat(php_info_arr_el[0]);
				php_info_arr_el[2] = parseFloat(php_info_arr_el[2]);
				php_info_arr_finale.push(php_info_arr_el);
			}
			document.getElementById("php_info").remove();
			var php_info_arr_finale_date_info=[];
			var php_info_arr_finale_price=[];
			for (var i = 0 ; i<php_info_arr_finale.length; i++)
			{
				//alert(php_info_arr_finale[i][1]);
				//alert(php_info_arr_finale[i][2]);
				//alert(php_info_arr_finale[i][3]);
				
				php_info_arr_finale_date_info.push(php_info_arr_finale[i][1] + " - " + php_info_arr_finale[i][3]);
				php_info_arr_finale_price.push(php_info_arr_finale[i][2]);
			}
			
			
			let ctx = document.getElementById('myChart').getContext('2d');
			let chart = new Chart(ctx, {
				// Тип графика
				type: 'bar',
				
				// Создание графиков
				data: {
					// Точки графиков
					labels: php_info_arr_finale_date_info,
					// График
					datasets: [{
						label: 'Costs one by one', // Название
						backgroundColor: 'rgb(255, 99, 132)', // Цвет закраски
						borderColor: 'rgb(255, 99, 132)', // Цвет линии
						data: php_info_arr_finale_price // Данные каждой точки графика
					}]
				},
				
				// Настройки графиков
				options: {}
			});
			
			var php_info_arr_finale_sum=php_info_arr_finale;
			
			for (var i = 1 ; i<php_info_arr_finale_sum.length; i++)
			{
				
				php_info_arr_finale_sum[i][2] = php_info_arr_finale[i-1][2] + php_info_arr_finale[i][2];
			}
			
			php_info_arr_finale_date_info=[];
			php_info_arr_finale_price=[];
			for (var i = 0 ; i<php_info_arr_finale_sum.length; i++)
			{
				//alert(php_info_arr_finale[i][1]);
				//alert(php_info_arr_finale[i][2]);
				//alert(php_info_arr_finale[i][3]);
				
				php_info_arr_finale_date_info.push(php_info_arr_finale_sum[i][1] + " - " + php_info_arr_finale_sum[i][3]);
				php_info_arr_finale_price.push(php_info_arr_finale_sum[i][2]);
			}
			
			
			let ctx1 = document.getElementById('myChart2').getContext('2d');
			let chart1 = new Chart(ctx1, {
				// Тип графика
				type: 'line',
				
				// Создание графиков
				data: {
					// Точки графиков
					labels: php_info_arr_finale_date_info,
					// График
					datasets: [{
						label: 'Costs sum ', // Название
						backgroundColor: 'rgb(255, 99, 132)', // Цвет закраски
						borderColor: 'rgb(255, 99, 132)', // Цвет линии
						data: php_info_arr_finale_price // Данные каждой точки графика
					}]
				},
				
				// Настройки графиков
				options: {}
			});
		</script>
		
	</body>
</html>
