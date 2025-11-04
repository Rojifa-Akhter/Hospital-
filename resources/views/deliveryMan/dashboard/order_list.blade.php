@extends('deliveryMan.layouts.master')
@section('content')
    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <style>
        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid transparent;
            vertical-align: middle !important;
            text-transform:none;

        }

        table.dataTable.no-footer {
            border-bottom: 0;
        }

        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

    </style>

    <section id="order_list">
        <div class="container-fluid">
            {{-- <div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Assigned Order List</h5>
				<small>Settings / Delivery / Assigned Order List</small>
			</div>
		</div> --}}

            <div class="page-header shadow-sm"
                style="background-color: #fff!important;padding: 15px 15px!important; border-radius: 5px!important;">
                <div class="page-leftheader">
                    <h4 class="page-title" style="line-height: 1; margin-bottom: 5px;">Assigned Order List</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fa fa-cog fs-14"></i> Settings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Assigned Order List</a></li>
                    </ol>
                </div>
                <div class="page-rightheader">
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="page-title">Assigned Order List</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="datatable"
                                class="table table-bordered table-hover table-striped data-table-order-list mb-0">
                                <thead class="">
                                    <tr>
                                        <th class="text-center">Sl#</th>
                                        <th class="text-center">Order Id</th>
                                        <th class="text-left">Customer Name</th>
                                        <th class="text-left">Customer Mobile</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-left">Address</th>
                                        <th class="text-center">Delivery Date</th>
                                        <th class="text-center" style="width: 100px;">Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (!empty($order_list))
                                        @foreach ($order_list as $data)
                                            <tr id="rowId{{ $data->ecom_delivery_no }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ ucfirst(strtolower($data->order_no)) }}</td>
                                                <td class="text-left">{{ ucfirst(strtolower($data->customer_name)) }}
                                                </td>
                                                <td class="text-left">{{ $data->phone_mobile }}</td>
                                                <td class="text-right">{{number_format($data->tot_amount,2)}}</td>

                                                <td class="text-center">
                                                    {{ date('d/m/Y', strtotime($data->order_date)) }}
                                                </td>
                                                <td class="text-left">{{ ucfirst(strtolower($data->address_name)) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ date('d/m/Y', strtotime($data->delivery_date)) }}</td>
                                                <td class="text-center">
                                                    <button type="button" data-toggle="modal" class="btn btn-success"
                                                        data-target-id="{{ $data->order_no }}"
                                                        data-target="#item_details_modal" title="Item Details">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <button class="btn btn-info " data-toggle="modal"
                                                        data-target="#item_picked_modal"
                                                        data-target-id="{{ $data->order_no }}"
                                                        id="deliveryId_{{ $data->ecom_delivery_no }}"
                                                        value="{{ $data->ecom_delivery_no }}" onclick="setServiceId(this)">
                                                        <i class="fas fa-truck-pickup" ></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Item details Modal -->

            <div class="modal fade" id="item_details_modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="datatable"
                                class="table table-bordered table-hover table-striped data-table-for-modal mb-0">
                                <thead class="">
                                    <tr>
                                        <th style="text-transform:none;" class="text-left" scope="col">Product Name</th>
                                        <th style="text-transform:none;" class="text-left" scope="col">Quantity</th>
                                        <th style="text-transform:none;" class="text-left" width="20%" scope="col">Unit Price</th>
                                        <th style="text-transform:none;" class="text-left" width="20%" scope="col">Total Price</th>

                                    </tr>
                                </thead>
                                <tbody id="orderWiseProduct">
                                    <tr>
                                        <td id=""></td>
                                        <td id=""></td>
                                        <td id=""></td>
                                        <td id=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="item_picked_modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Picked Items</h5>
                            <button  type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('pick-delivery') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="ecom_service_id" name="ecom_service_id" value="">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-4 text-right">
                                        <label for="" class="mb-0">Select Store</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" value="" id="ecom_service">
                                        <select class="form-control keep_me col-md-8" id="service_point"
                                            name="service_point">
                                            <option value="">Select One</option>
                                            @if (!empty($service_point))
                                                @foreach ($service_point as $value)
                                                    @if ($value->default_ind == 1)
                                                        <option selected value="{{ $value->serviceunit_no_pk }}">
                                                            {{ $value->serviceunit_name }}</option>
                                                    @else
                                                        <option value="{{ $value->serviceunit_no_pk }}">
                                                            {{ $value->serviceunit_name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <table id="" class="table table-bordered table-hover  mb-0">
                                    <thead class="">
                                        <tr>
                                            <th class=" text-left" scope="col">Product Name</th>
                                            <th class=" text-center" scope="col">Quantity</th>
                                            <th class=" text-center" scope="col">Price</th>
                                            <th class=" text-center" scope="col">Batch Number</th>
                                            <th class=" text-center" scope="col">Expiry Date</th>


                                        </tr>
                                    </thead>
                                    <tbody id="orderWiseProductWithBatch">
                                        <tr>
                                            <td id=""></td>
                                            <td id=""></td>
                                            <td id=""></td>
                                            <td id=""></td>
                                            <td id=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary " >Picked</button>
                                <button  type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
    </script>
    <script>
        $(document).ready(function() {
            var datatable = $('.data-table-order-list').DataTable();

        });
        function setServiceId(element){
            var ecom = $(element).val();
            $("#ecom_service_id").val(ecom);
            console.log($(this).val());
        }
     $("#item_details_modal").on("hide.bs.modal", function(e) {
            // var id = $(e.relatedTarget).data('target-id');
            // var url = "{{ route('delivery-item-info', ':id') }}";
            // var url_rep = url.replace(':id', id);
            // $.get(url_rep, function(data) {
            // });
                $("#orderWiseProduct").html('');


        });


        $("#item_details_modal").on("show.bs.modal", function(e) {
            
            var id = $(e.relatedTarget).data('target-id');
            var url = "{{ route('delivery-item-info', ':id') }}";
            var url_rep = url.replace(':id', id);
            $.get(url_rep, function(data) {
                $("#orderWiseProduct").html(data);
            });

        });
        $("#item_picked_modal").on("shown.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');

            var service_point = $("#service_point").val();
            var url = "{{ route('delivery-item-batch', [':id', ':service_point']) }}";
            url = url.replace(':id', id);
            url = url.replace(':service_point', service_point);
            //console.log('url ',url)
            $.get(url, function(data) {
                $("#orderWiseProductWithBatch").html(data);
            });

        });
        $(document).on('click', '.item_details_class', function() {

            var id = $(this).val();
            var url = "{{ route('delivery-item-info', ':id') }}";
            var url_rep = url.replace(':id', id);
            $.ajax({
                url: url_rep,
                type: 'get',

            });


        });


        $(document).on('click', '.delivery_class', function() {

            var id = $(this).val();
            $('#rowId' + id).fadeOut();

            var url = "";
            var url_rep = url.replace(':id', id);
            $.ajax({
                url: url_rep,
                type: 'get',

            });


        });
    </script>
@endsection
