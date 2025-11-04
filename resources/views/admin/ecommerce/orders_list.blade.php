<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section class="order_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Ecommerce Order List</h5>
                <small>Order / Ecommerce Order List</small>
            </div>
        </div>


{{--        Search Option --}}
        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchOrder"  class="btn btn-md btn-success btn-block mt-4">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

{{--        End --}}


        <div class="card"  id="order_list">


                            @include('admin.ecommerce.ecommerce_orders_list_data')

        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            'format':'dd/mm/yyyy'
        });

        $(document).on("click", "#btnSearchOrder", function(e) {
            var formID = $("#searchForm").attr("id");
            var formMethod = $("#searchForm").attr("method");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('ecommerce/orders-list-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#order_list").html(data);

                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });
    });
</script>





