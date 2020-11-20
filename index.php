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
		<title>Info costs</title>
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<script src="js/react.development.js"></script>
		<script src="js/react-dom.development.js"></script>
		
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/javascript-calendar.css">
		<link rel="stylesheet" href="css/tavo-calendar.css">
		<!-- Don't use this in production: -->
		<script src="js/babel.min.js"></script>
	</head>
	<body>
		
		
		<div id="info_costs" ></div>
		<?php 
			echo "<span id='php_info' style='display:none'>".$result_str."</span>"
		?>
		<script src="js/tavo-calendar.js"></script>
		
		<script type="text/babel">
			
			
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
			class MainTitle extends React.Component {
				
				render() {
					
					return (
				<div className="maintitle"><h1>{this.props.text}</h1></div>
				
				); 
				}
				}
				class MainData extends React.Component {
				
				render() {
				
				return (
				<div className="maindata">
					<h1>{this.props.text}</h1>
					
				</div>
				
				); 
				}
				}
				class PopUpBox extends React.Component {
				
				ChangeEl() {
				document.getElementsByClassName("PopUpBox")[0].style.display="none";};
				
				VerPrice = (event) =>  {
				var nombers = ['0','1','2','3','5','6','7','8','9','.'];
                
				
				if (!nombers.includes(event.key)){
				event.preventDefault();
				}
				}
				
				render() {
				
				return (
				<div className="PopUpBox">
					<form onSubmit={this.ChangeEl}>
						<input className="inp_name" placeholder="Name of item" type="text"  />
						<input className="inp_price" placeholder="Price"  type="text"  onKeyPress={this.VerPrice}/>
					</form>
				</div>
				
				); 
				}
				}
				class ControlBox extends React.Component {
				constructor(props) {
				
				super(props);
				this.state = {
				data: php_info_arr_finale,
				};
				};
				
				addEl = () => {
				if (document.getElementsByClassName("inp_name")[0].value == "" &&  document.getElementsByClassName("inp_price")[0].value == ""){
				document.getElementsByClassName("PopUpBox")[0].style.display="block";}
				else{
				let	name = document.getElementsByClassName("inp_name")[0].value;
				let price = document.getElementsByClassName("inp_price")[0].value;
				var d1 = new Date();
				
				let date = d1.getFullYear()+"-"+(d1.getMonth()+1)+"-"+d1.getDate();
				
				
				
				// Так же как и в GET составляем строку с данными, но уже без пути к файлу 
				const params = "name=" + name+ "&price=" + price + "&date=" + date + "&add=" + 1;
				
				var xhttp = new XMLHttpRequest();
				
				xhttp.open("POST", "php/functions.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send(params);
				
				
				var val =this.state.data;
				
				val.push(["el"+fake_id , document.getElementsByClassName("inp_name")[0].value , document.getElementsByClassName("inp_price")[0].value]);
				fake_id = fake_id + 1;
				this.setState({data: val});
				document.getElementsByClassName("inp_name")[0].value = ""
				document.getElementsByClassName("inp_price")[0].value = ""
				document.getElementsByClassName("PopUpBox")[0].style.display="none";
				}
				
				};
				delEl = () =>  {
				var checks_del=[]
				var checks = document.getElementsByClassName("CheckBox");
				for (var i=0; i < checks.length;i++){
				
				if(checks[i].checked == true){
				checks_del.push(checks[i].dataset.value);
				}
				}
				
				var val =this.state.data;
				var val2 =[]; 
				for (var i=0; i < val.length;i++){
				
				if (!checks_del.includes(val[i][0].toString()) ) {
				val2.push(val[i]);
				}
				}
				
				let	massids = checks_del.join(",");
				
				// Так же как и в GET составляем строку с данными, но уже без пути к файлу 
				const params = "massids=" + massids + "&add=" + 0;
				var xhttp = new XMLHttpRequest();
				xhttp.open("POST", "php/functions.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send(params);
				
				
				
				
				
				this.setState({data: val2});
				};
				
				render() {
				var val=this.state.data;
				var valsum=0;
				for (var i=0; i < val.length;i++){
				
				valsum = valsum + val[i][2];
				}
				var vals = val.map((v) => <div className="checkbox"><input className="CheckBox"  type="checkbox" data-value={v[0]} /><span className="info_cost">{v[1]}</span><span className="value_cost">${v[2]}</span></div>);
					return (
					<div className="ControlBox">
						<div className="listBox">
							<div >
								{vals}
								<div className="sum_costs">Total:</div>
								<div className="sumbox">${valsum}</div>
							</div>
						</div>
						<button onClick={this.addEl} className="addBTN">Add new item</button>
						<PopUpBox />
						<button onClick={this.delEl} className="delBTN">Delete item</button>
					</div>
					
					); 
					}
					}
					
					class TitleFilters extends React.Component {
					
					
					
					render() {
					
					return (
					<div className="titleFilters">
						<h1>{this.props.text}</h1>
					</div>
					
					
					); 
					}
					}
					class Filter extends React.Component {
					
					
					render() {
					
					return (
					<div className="Filter">
						<a href={this.props.link}>{this.props.text}</a>
					</div>
					
					
					); 
					}
					}
					class Links extends React.Component {
					
					
					render() {
					
					return (
					<div className="Filter">
						<a href={this.props.link}>{this.props.text}</a>
					</div>
					
					
					); 
					}
					}
					class Calendar extends React.Component {
					
					
					render() {
					
					return (
					<div id="js_calendar" className="Calendar">
						
						
						
						
					</div>
					
					
					); 
					}
					}
					
					
					
					const app = document.getElementById("info_costs");
					
					var d = new Date();
					var today = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
					var options = {  year: 'numeric', month: 'short', day: 'numeric' };
					var today_title = d.toLocaleDateString('en-GB', options);
					
					d.setDate( d.getDate() - 1 );
					var yesterday = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
					d.setDate( d.getDate() - (d.getDay()-1));
					var week = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
					
					
					ReactDOM.render (
					<div className="box">
						
						<div className="right_box">
							<MainTitle text="My Expenses" />
							<MainData text={today_title} />
							<ControlBox />
							
							
							
							
						</div>
						<div className="left_box">
							<TitleFilters text="Filters:" />
							<Filter text="Today" link={today} />
							<Filter text="Yesterday" link={yesterday} />
							<Filter text="This week" link={week} />
							<Links text="Graphics" link="http://publichtml2/graphics.php" />
							
							
						</div>
					</div>
					,
					app
					);
					
				</script>
				
		</body>
	</html>
