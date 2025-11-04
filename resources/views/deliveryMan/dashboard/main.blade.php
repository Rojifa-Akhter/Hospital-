@extends('deliveryMan.layouts.master')
@section('content')

<div class="page-header shadow-sm" style="background-color: #fff!important;padding: 15px 15px!important; border-radius: 5px!important;">
	<div class="page-leftheader">
		<h4 class="page-title" style="line-height: 1; margin-bottom: 5px;">Hi! Welcome Back</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Delivery Man Dashboard</a></li>
		</ol>
	</div>
	<div class="page-rightheader">
	</div>
</div>

<!-- Row-1 -->
<div class="row">
	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden dash1-card border-0 shadow-sm">
			<div class="card-body">
				<p class="mb-1">Assigned Orders</p>
				<h2 class="mb-1 number-font">{{$delivery_man->assigned_orders}}</h2>
				{{--
				<small class="fs-12 text-muted">Compared to Last Month</small>
				<span class="ratio bg-warning">76%</span>
				<span class="ratio-text text-muted">Goals Reached</span>
				--}}
			</div>
			{{--<div id="spark1"></div>--}}
		</div>
	</div>

	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden dash1-card border-0 shadow-sm">
			<div class="card-body">
				<p class="mb-1">Delivered Orders</p>
				<h2 class="mb-1 number-font">{{$delivery_man->delivered_orders}}</h2>
				{{--
				<small class="fs-12 text-muted">Compared to Last Month</small>
				<span class="ratio bg-info">85%</span>
				<span class="ratio-text text-muted">Goals Reached</span>
				--}}
			</div>
			{{--<div id="spark2"></div>--}}
		</div>
	</div>

	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden dash1-card border-0 shadow-sm">
			<div class="card-body">
				<p class="mb-1">Pending Orders</p>
				<h2 class="mb-1 number-font">{{$delivery_man->pending_orders}}</h2>
				{{--
				<small class="fs-12 text-muted">Compared to Last Month</small>
				<span class="ratio bg-danger">62%</span>
				<span class="ratio-text text-muted">Goals Reached</span>
				--}}
			</div>
			{{--<div id="spark3"></div>--}}
		</div>
	</div>

	<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden dash1-card border-0 shadow-sm">
			<div class="card-body">
				<p class="mb-1">Cancelled Orders</p>
				<h2 class="mb-1 number-font">{{$delivery_man->cancelled_orders}}</h2>
				{{--
				<small class="fs-12 text-muted">Compared to Last Day</small>
				<span class="ratio bg-success">53%</span>
				<span class="ratio-text text-muted">Goals Reached</span>
				--}}
			</div>
			{{--<div id="spark4"></div>--}}
		</div>
	</div>
</div>
<!-- End Row-1 -->

<!-- Row-2 -->
<!-- End Row-2 -->

@endsection