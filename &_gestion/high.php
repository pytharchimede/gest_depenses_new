<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Column chart with data from MySQL using Highcharts</title>
		<script type="text/javascript" src="js_me/jquery_1.7.1_jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			var options = {
	            chart: {
	                renderTo: 'contain_1',
	                type: 'column',
	                marginRight: 130,
	                marginBottom: 25
	            },
	            title: {
	                text: '',
	                x: -20 //center
	            },
	            subtitle: {
	                text: '',
	                x: -20
	            },
	            xAxis: {
	                categories: []
	            },
	            yAxis: {
	                title: {
	                    text: ''
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                formatter: function() {
	                        return '<b>'+ this.series.name +'</b><br/>'+
	                        this.x +': '+ this.y;
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: 10,
	                y: 50,
	                borderWidth: 0
	            },
	            series: []
	        }
	        
	        $.getJSON("data_high.php", function(json) {
				options.xAxis.categories = json[0]['data'];
	        	options.series[0] = json[1];
		        chart = new Highcharts.Chart(options);
	        });
	    });
		</script>
	    <script src="js_me/highcharts.js"></script>
        <script src="js_me/exporting.js"></script>
	</head>
	<body>
		<div id="contain_1" style="min-width: 1000px; height: 450px; border:1px solid #DDDDDD; background:#FFFFFF"></div>
	</body>
</html>