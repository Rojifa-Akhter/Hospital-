$(function () {
	'use strict';
	$.plot('#flotBar1', [{
		data: [
			[10, 30],
			[20, 70],
			[30, 50],
			[40, 60],
			[50, 70],
			[60, 60],
			[70, 90],
			[80, 50]
		]
	}], {
		series: {
			bars: {
				show: true,
				lineWidth: 0,
				fillColor: '#fb1c52',
				barWidth: 5
			},
			highlightColor: '#705ec8'
		},
		grid: {
			borderWidth: 1,
			borderColor: 'rgba(67, 87, 133, .09)',
			hoverable: true
		},
		yaxis: {
			tickColor: 'rgba(67, 87, 133, .09)',
			font: {
				color: '#8e9cad',
				size: 10
			}
		},
		xaxis: {
			tickColor: 'rgba(67, 87, 133, .09)',
			font: {
				color: '#8e9cad',
				size: 10
			}
		}
	});
	
	/**************** PIE CHART *******************/
	var piedata = [{
		label: 'Medicine - 50',
		data: [
			[1, 50]
		],
		color: '#fb1c52'
	}, {
		label: 'Cardiology - 28',
		data: [
			[1, 28]
		],
		color: '#705ec8'
	}, {
		label: 'Gynaecology - 17',
		data: [
			[1, 17]
		],
		color: '#2dce89'
	}, {
		label: 'ENT - 10',
		data: [
			[1, 10]
		],
		color: '#ff5b51'
	}];
	var piedataGender = [{
		label: 'Male',
		data: [
			[1, 50]
		],
		color: 'cornflowerblue'
	}, {
		label: 'Female',
		data: [
			[1, 28]
		],
		color: 'darkcyan'
	}];




	$.plot('#flotPie1', piedata, {
		series: {
			pie: {
				show: true,
				radius: 1,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: labelFormatter,
					threshold: 0.1
				}
			}
		},
		grid: {
			hoverable: false,
			clickable: true
		}
	});

	$.plot('#flotPie2', piedataGender, {
		series: {
			pie: {
				show: true,
				radius: 1,
				innerRadius: 0.4,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: labelFormatter,
					threshold: 0.1
				}
			}
		},
		grid: {
			hoverable: false,
			clickable: true
		}
	});

	function labelFormatter(label, series) {
		return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
	}
});