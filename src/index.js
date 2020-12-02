import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import MainTitle from './MainTitle';
import MainData from './MainData';
import PopUpBox from './PopUpBox';
import TitleFilters from './TitleFilters';
import Filter from './Filter';
import Links from './Links';
import reportWebVitals from './reportWebVitals';

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

var fake_id=0;
var php_info = "4,r,1,2010,11,19!4,r,1,2010,11,19!4,r,1,2010,11,19!4,r,1,2010,11,19!4,r,1,2010,11,19";
var d1 = new Date();

let date = d1.getFullYear()+"-"+(d1.getMonth()+1)+"-"+d1.getDate();
var params = "name=";
if(getParameterByName('date') != null){
	params = "date=" + date + "&option=" + 3;
}else{
    params = "option=" + 3;
}

// Так же как и в GET составляем строку с данными, но уже без пути к файлу 


var xhttp = new XMLHttpRequest();
xhttp.open("POST", "http://localhost:3000/functions.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.onreadystatechange = function() {//Вызывает функцию при смене состояния.
    if(xhttp.readyState == XMLHttpRequest.DONE && xhttp.status == 200) {
	alert(this.responseText);
        php_info = this.responseText ;
	}
}

xhttp.send(params);


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
			const params = "name=" + name+ "&price=" + price + "&date=" + date + "&option=" + 1;
			
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
		const params = "massids=" + massids + "&option=" + 2;
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








const app = document.getElementById("root");

var d = new Date();
var today = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
var options = {  year: 'numeric', month: 'short', day: 'numeric' };
var today_title = d.toLocaleDateString('en-GB', options);

d.setDate( d.getDate() - 1 );
var yesterday = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
d.setDate( d.getDate() - (d.getDay()-1));
var week = "http://z95356dh.beget.tech?date="+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();



ReactDOM.render(
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

document.getElementById('root')
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
/*<React.StrictMode>
<App />
</React.StrictMode>,*/