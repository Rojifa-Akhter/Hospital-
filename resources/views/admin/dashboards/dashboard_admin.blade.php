<style>

	.card_name{
		font-size: 20px;
		color: #70657b !important;

	}

	.counter-num {
		font-size: 32px;
		font-weight: 500;
		font-family: poppins;
	}

	.card-body{
		position: relative;
		padding: .5rem;
	}

	.card-icon {
		position: absolute;
		width: 65px;
		top: 50%;
		left: 12%;
		transform: translate(-50%, -50%);
		font-size: 40px;
		color: #74697f9e;
		opacity: 0.2;
	}

</style>


<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top shadow-sm">
		<div class="col-md-12">
			<h5 class="mt-2 mb-0">Dashboard</h5>
			<small>Home / Dashboard</small>
		</div>
	</div>
	
	<div class="row">

		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="card-group">
				<div class="card text-center bg-none border-0">
					<div class="card-body pl-0 pr-0 bg-white border shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title mb-0">Physiotherapist</h6>
						<h5 class="card-text">8</h5>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 border-right text-right">
									Male
									<h5>5</h5>
								</div>
								<div class="col-lg-6 text-left">
									Female
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body pl-0 pr-0 bg-white border shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title mb-0">Patients</h6>
						<h5 class="card-text">8</h5>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 border-right text-right">
									Male
									<h5>5</h5>
								</div>
								<div class="col-lg-6 text-left">
									Female
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card text-center border-0 bg-none">
					<div class="card-body border bg-white shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title">Total Appointment</h6>
						<h5 class="card-text">8</h5>
					</div>
					<div class="card-body border bg-white shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title">Today Appointment</h6>
						<h5 class="card-text">8</h5>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 border-right text-right">
									Male
									<h5>5</h5>
								</div>
								<div class="col-lg-6 text-left">
									Female
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="card text-center border-0 bg-none">
					<div class="card-body border bg-white shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title">Total Consultation</h6>
						<h5 class="card-text">8</h5>
					</div>
					<div class="card-body border bg-white shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title">Total Consultation</h6>
						<h5 class="card-text">8</h5>
					</div>
					<div class="card-body border bg-white shadow-sm mr-2 rounded mb-2">
						<h6 class="card-title">Total Consultation</h6>
						<h5 class="card-text">8</h5>
					</div>
				</div>
			</div>

			<div class="card-group">
				<div class="card text-center">
					<div class="card-body pl-0 pr-0">
						<h6 class="card-title">Consulation</h6>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 border-right text-right">
									Total
									<h5>5</h5>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 text-left">
									Today
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card text-center">
					<div class="card-body pl-0 pr-0">
						<h6 class="card-title">Collection</h6>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 border-right text-right">
									Total
									<h5>5</h5>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 text-left">
									Today
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card text-center">
					<div class="card-body pl-0 pr-0">
						<h6 class="card-title">Due</h6>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 border-right text-right">
									Total
									<h5>5</h5>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 text-left">
									Today
									<h5>3</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card text-center">
					<div class="card-body pl-0 pr-0">
						Referal Doctor
						<h5 class="card-text">8</h5>
					</div>
					<div class="card-body pl-0 pr-0 border-top">
						Sales Agent
						<h5 class="card-text">8</h5>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12 pl-0">
			<div class="card mb-4 text-center">
				<div class="card-body">	
					<h6 class="card-title">Head Wise Income</h6>
					<div id="echartBar" style="height: 150px;"></div>
				</div>
			</div>
			<div class="card mb-4 text-center">
				<div class="card-body">
					<h6 class="card-title">Center Wise Income</h6>
					<div id="echartPie" style="height: 150px;"></div>
				</div>
			</div>
			<div class="card card-chart-bottom o-hidden mb-4 text-center">
				<div class="card-body">
					<h6 class="card-title">Financial Flow</h6>
					<p class="mb-4 text-primary text-24">$40250</p>
				</div>
				<div id="echart1" style="height: 150px;"></div>
			</div>
		</div>
	</div>
	
</div>
<script src="{{asset('js/echart/echarts.min.js')}}"></script>
<script src="{{asset('js/echart/echart.options.min.js')}}"></script>
<script>
	"use strict";

	function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

	function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

	$(document).ready(function () {
		var echartElemBar = document.getElementById('echartBar');

		if (echartElemBar) {
			var echartBar = echarts.init(echartElemBar);
			echartBar.setOption({
				legend: {
					borderRadius: 0,
					orient: 'horizontal',
					x: 'right',
					data: ['Online', 'Offline']
				},
				grid: {
					left: '8px',
					right: '8px',
					bottom: '0',
					containLabel: true
				},
				tooltip: {
					show: true,
					backgroundColor: 'rgba(0, 0, 0, .8)'
				},
				xAxis: [{
					type: 'category',
					data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
					axisTick: {
						alignWithLabel: true
					},
					splitLine: {
						show: false
					},
					axisLine: {
						show: true
					}
				}],
				yAxis: [{
					type: 'value',
					axisLabel: {
						formatter: '${value}'
					},
					min: 0,
					max: 100000,
					interval: 25000,
					axisLine: {
						show: false
					},
					splitLine: {
						show: true,
						interval: 'auto'
					}
				}],
				series: [{
					name: 'Online',
					data: [35000, 69000, 22500, 60000, 50000, 50000, 30000, 80000, 70000, 60000, 20000, 30005],
					label: {
						show: false,
						color: '#0168c1'
					},
					type: 'bar',
					barGap: 0,
					color: '#bcbbdd',
					smooth: true,
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowOffsetY: -2,
							shadowColor: 'rgba(0, 0, 0, 0.3)'
						}
					}
				}, {
					name: 'Offline',
					data: [45000, 82000, 35000, 93000, 71000, 89000, 49000, 91000, 80200, 86000, 35000, 40050],
					label: {
						show: false,
						color: '#639'
					},
					type: 'bar',
					color: '#7569b3',
					smooth: true,
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowOffsetY: -2,
							shadowColor: 'rgba(0, 0, 0, 0.3)'
						}
					}
				}]
			});
			$(window).on('resize', function () {
				setTimeout(function () {
					echartBar.resize();
				}, 500);
			});
		} 


		var echartElemPie = document.getElementById('echartPie');

		if (echartElemPie) {
			var echartPie = echarts.init(echartElemPie);
			echartPie.setOption({
				color: ['#62549c', '#7566b5', '#7d6cbb', '#8877bd', '#9181bd', '#6957af'],
				tooltip: {
					show: true,
					backgroundColor: 'rgba(0, 0, 0, .8)'
				},
				series: [{
					name: 'Sales by Country',
					type: 'pie',
					radius: '60%',
					center: ['50%', '50%'],
					data: [{
						value: 535,
						name: 'USA'
					}, {
						value: 310,
						name: 'Brazil'
					}, {
						value: 234,
						name: 'France'
					}, {
						value: 155,
						name: 'BD'
					}, {
						value: 130,
						name: 'UK'
					}, {
						value: 348,
						name: 'India'
					}],
					itemStyle: {
						emphasis: {
							shadowBlur: 10,
							shadowOffsetX: 0,
							shadowColor: 'rgba(0, 0, 0, 0.5)'
						}
					}
				}]
			});
			$(window).on('resize', function () {
				setTimeout(function () {
					echartPie.resize();
				}, 500);
			});
		} 


		var echartElem1 = document.getElementById('echart1');

		if (echartElem1) {
			var echart1 = echarts.init(echartElem1);
			echart1.setOption(_objectSpread({}, echartOptions.lineFullWidth, {}, {
				series: [_objectSpread({
					data: [30, 40, 20, 50, 40, 80, 90]
				}, echartOptions.smoothLine, {
					markArea: {
						label: {
							show: true
						}
					},
					areaStyle: {
						color: 'rgba(102, 51, 153, .2)',
						origin: 'start'
					},
					lineStyle: {
						color: '#663399'
					},
					itemStyle: {
						color: '#663399'
					}
				})]
			}));
			$(window).on('resize', function () {
				setTimeout(function () {
					echart1.resize();
				}, 500);
			});
		} 


		var echartElem2 = document.getElementById('echart2');

		if (echartElem2) {
			var echart2 = echarts.init(echartElem2);
			echart2.setOption(_objectSpread({}, echartOptions.lineFullWidth, {}, {
				series: [_objectSpread({
					data: [30, 10, 40, 10, 40, 20, 90]
				}, echartOptions.smoothLine, {
					markArea: {
						label: {
							show: true
						}
					},
					areaStyle: {
						color: 'rgba(255, 193, 7, 0.2)',
						origin: 'start'
					},
					lineStyle: {
						color: '#FFC107'
					},
					itemStyle: {
						color: '#FFC107'
					}
				})]
			}));
			$(window).on('resize', function () {
				setTimeout(function () {
					echart2.resize();
				}, 500);
			});
		} 


		var echartElem3 = document.getElementById('echart3');

		if (echartElem3) {
			var echart3 = echarts.init(echartElem3);
			echart3.setOption(_objectSpread({}, echartOptions.lineNoAxis, {}, {
				series: [{
					data: [40, 80, 20, 90, 30, 80, 40, 90, 20, 80, 30, 45, 50, 110, 90, 145, 120, 135, 120, 140],
					lineStyle: _objectSpread({
						color: 'rgba(102, 51, 153, 0.8)',
						width: 3
					}, echartOptions.lineShadow),
					label: {
						show: true,
						color: '#212121'
					},
					type: 'line',
					smooth: true,
					itemStyle: {
						borderColor: 'rgba(102, 51, 153, 1)'
					}
				}]
			}));
			$(window).on('resize', function () {
				setTimeout(function () {
					echart3.resize();
				}, 500);
			});
		}
	});
</script>
