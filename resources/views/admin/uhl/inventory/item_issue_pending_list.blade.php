<main id="page-content">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />    
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0"> Issue List</h5>
                            <small>Inventory/ Store /  Issue List</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">                   
                        <div class="card">                           
                            <div class="card-body">
                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-item" role="tabpanel"
                                        aria-labelledby="pills-item-tab">
                                        <div class="card">
                                            <form action="{{ route('pending-issue-item-pdf') }}" method="post" id="indent_issue_list" target="_blank">
                                                @csrf
                                                <div class="card-body p-2">
                                                    <div class="form-row">
                                                        <div class="col-lg-2 col-md-2 col-12">
                                                           
                                                                <label for="requsion_no"
                                                                    class=" col-form-label">Indent No</label>
                                                                <div class="">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="requsion_no" name="requsion_no"
                                                                        placeholder="" />
                                                                </div>
                                                           
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-12">
                                                          
                                                                <label for="issue_no"
                                                                    class="col-form-label">Issue No</label>
                                                                <div class="">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="issue_no" name="issue_no"
                                                                        placeholder="" />
                                                                </div>
                                                            
                                                        </div>

                                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                                           
                                                                <label class="col-form-label col-form-label-sm "
                                                                    for="indent_date_from">Indent Date</label>

                                                                <div class="">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">From</div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 date_picker"
                                                                            id="indent_date_from"
                                                                            name="indent_date_from" value=""
                                                                            placeholder="dd/mm/yyyy" autocomplete="off" />
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">To</div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm m-0 date_picker"
                                                                            id="indent_date_to" name="indent_date_to"
                                                                            value="" placeholder="dd/mm/yyyy" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                          
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-12">
                                                            
                                                                <label for="sub_store"
                                                                    class="col-form-label">From Store</label>
                                                                <div class="">
                                                                    <select class="form-control  select2" id="sub_store" name="sub_store">
                                                                        <option value="">select</option>
                                                                        @if(!empty($sub_stores_list))
                                                                            @foreach($sub_stores_list as $value)
                                                                                <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                         
                                                        </div>

                                                        <div class="col-md-2 col-sm-12 mt-3">
                                                            <div class="btn-group btn-block" role="group">
                                                                <button type="button"
                                                                    class="btn btn-success search_indent"><i
                                                                        class="fa fa-search"></i> Search</button>
                                                                {{-- <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-file-pdf"></i></button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card">
                                            <div class="card-body px-0 search_indent_pending_list">
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>                  
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(".date_picker").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    })
    $('.select2').select2({});
    $("body").addClass("sidebar-collapse");

    

    $('.search_indent').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-issued-pending-list') }}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                issue_no: $('#issue_no').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val(),
                sub_store: $('#sub_store').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_indent_pending_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
