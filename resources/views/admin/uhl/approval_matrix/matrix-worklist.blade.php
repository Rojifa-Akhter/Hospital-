


<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Approval Matrix</h5>
                <small>Settings / Approval Matrix Worklist</small>
            </div>
        </div>
    </div>
    {{-- <div class="card mt-2" style="width: 100%; margin: auto">
        <div class="card-header ">
            <h5> Search</h5>
        </div>
        <div class="card-body ">
            <div class="form-row mt-2 mb-4">
                <div class="col-md-12">
                    <form method="post"  id="frmSearch" action="">
                        @csrf
                        <div class=" justify-content-center  form-row">
                            <input type="hidden" name="id" value="">
                            <div class="col-md-2">
                                <label for="supplier_name"
                                    class=" col-form-label col-form-label-sm ">Test</label>
                                    <select class="form-control form-control-sm" id="po_store" name="po_store">
                                        <option value="">Select Test</option>
                                        @if (!empty($main_store_list))
                                                @foreach ($main_store_list as $store)
                                                    <option value="{{ $store->serviceunit_no_pk }}"
                                                        >
                                                        {{ $store->serviceunit_name }}</option>
                                                @endforeach
                                        @endif
                                    </select>
                            </div>
                            <div class="col-md-2">
                                <label for="store_name" class="col-form-label col-form-label-sm">Test</label>
                                        <select class="form-control form-control-sm select2" id="po_supplier" name="po_supplier">
                                            <option value="">Select Test</option>
                                            @if (!empty($supplier_arr))
                                                @foreach ($supplier_arr as $key => $ic)
                                                    <option value="{{ $key }}">
                                                        {{ $ic }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                            </div>

                            <div class="col-lg-2 col-md-6 text-center mt-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                    id="poTermsConditions"> <i class="fas fa-search"></i>
                                        Search</button> 

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-fluid">
        <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p> Approval Matrix Worklist</p>
                    <a href="{{route('v1.approval.matrix.create')}}" class="btn btn-primary btn-md"> Create New</a>
                </div>

            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="po_terms_container">
                            @include('admin.uhl.approval_matrix.table-matrix-worklist')
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $('.select2').select2();
    $(document).on("click", "#poTermsConditions", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('v1/po-terms-conditions-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#po_terms_container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

</script>






