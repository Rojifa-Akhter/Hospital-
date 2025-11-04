// $(function(e){
//   'use strict'


//   var jsonfile = {
//     "jsonarray": @php echo $echart_chart @endphp
// };

// alert(jsonfile)
// var serial = jsonfile.jsonarray.map(function(e) {
//     return e.sale_hour;
// });

// 	/* E-chart */
// 	var chartdata = [
// 		{
// 			name: 'Total Units Sold',
// 			type: 'line',
// 			smooth:true,
// 			data: [8, 5, 15, 10, 10, 8, 9, 12, 5, 15, 10, 10, 8, 16],
// 			itemStyle: {
// 				normal: { barBorderRadius: [50 ,50, 0 ,0],
// 						color: new echarts.graphic.LinearGradient(
// 							0, 0, 0, 1,
// 							[
// 								{offset: 0, color: '#fd6f82'},
// 								{offset: 1, color: '#fb1c52'}
// 							]
// 						)
// 				}
// 			},
// 		},
// 		{
// 			name: 'Total Sales',
// 			symbolSize:20,
// 			barWidth: 20,
// 			type: 'bar',
// 			data: [13, 17, 19, 22, 17, 11, 19, 20, 17, 19, 25, 17, 11, 19],
// 			itemStyle: {
// 				normal: { barBorderRadius: [50 ,50, 0 ,0],
// 						color: new echarts.graphic.LinearGradient(
// 							0, 0, 0, 1,
// 							[
// 								{offset: 0, color: '#705ec8'},
// 								{offset: 1, color: '#20c2fa'}

// 							]
// 						)
// 				}
// 			},
// 		}
// 	];





// 	var chart = document.getElementById('echart1');
// 	var barChart = echarts.init(chart);
// 	var option = {
// 		grid: {
// 		  top: '6',
// 		  right: '0',
// 		  bottom: '17',
// 		  left: '25',
// 		},
// 		xAxis: {
// 		//   data: [sale_hour],
// 		  data: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
// 		  axisLine: {
// 			lineStyle: {
// 			  color: 'rgba(67, 87, 133, .09)'
// 			}
// 		  },
// 		  axisLabel: {
// 			fontSize: 10,
// 			color: '#8e9cad'
// 		  }
// 		},
// 		tooltip: {
// 			show: true,
// 			showContent: true,
// 			alwaysShowContent: true,
// 			triggerOn: 'mousemove',
// 			trigger: 'axis',
// 			axisPointer:
// 			{
// 				label: {
// 					show: false,
// 				}
// 			}

// 		},
// 		yAxis: {
// 		  splitLine: {
// 			lineStyle: {
// 			  color: 'rgba(67, 87, 133, .09)'
// 			}
// 		  },
// 		  axisLine: {
// 			lineStyle: {
// 			  color: 'rgba(67, 87, 133, .09)'
// 			}
// 		  },
// 		  axisLabel: {
// 			fontSize: 10,
// 			color: '#8e9cad'
// 		  }
// 		},
// 		series: chartdata,
// 		color:[ '#ef6430', '#2205bf']
// 	};
// 	barChart.setOption(option);
// 	/* E-chart */

//  });
