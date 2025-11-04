<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Indent Worklist</h5>
                            <small>Inventory / Indent Worklist</small>
                        </div>
                        <div class="col-lg-5 col-md-5 col-12">
                            <div class="text-right">
                                <a rel="tab" href="{{ route('v1-department-indent.create') }}"
                                    class="btn btn-success uhl_common_outline_btn"><i
                                        class="fa fa-plus"></i>&nbsp;Create New Indent</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <div class="card">
                        <div class="card-header">

                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">

                                    <!-- <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Pending Sample" aria-selected="true"
                                        href="{{ route('v1-department-indent.index') }}" rel="tab">Indnet Info</a> -->
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Collected Sample" aria-selected="false"
                                        href="{{ route('v1.post-department-indent') }}" rel="tab">Post</a>
                                </li> -->
                                {{-- <li class="nav-item" role="presentation">
                                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Collected Sample" aria-selected="false"
                                        href="{{ route('v1-item-receive.index') }}" rel="tab">Received</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body p-2">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-draft" role="tabpanel"
                                    aria-labelledby="pills-draft-tab">
                                    <div class="card">
                                        <div class="card-body">

                                            <form action="{{ route('v1.search-department-indent') }}" method="post"
                                                id="department_indent_search">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no"
                                                                class="col-sm-4 col-form-label">From Store</label>
                                                            <div class="col-sm-8">
                                                               <select name="from_store" id="from_store" class="form-control select2">
                                                                    <option value="">select</option>
                                                                    @if (!empty($sub_store_list))
                                                                        @foreach ($sub_store_list as $item)
                                                                            <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                               </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no"
                                                                class="col-sm-4 col-form-label">Indent
                                                                No</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id="requsion_no" name="requsion_no"
                                                                    placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="requsion_no"
                                                                class="col-sm-4 col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control form-control-sm"
                                                                    id="save_option" name="save_option">
                                                                    <option value="">Select</option>
                                                                    <option value="DRAFT">DRAFT</option>
                                                                    <option value="POST">POST</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-md-1"></div> --}}

                                                    <div class="col-lg-3 col-md-3 col-sm-12">

                                                        <div class="form-group form-row">
                                                            <label class="col-form-label col-form-label-sm col-sm-3"
                                                                for="indent_date_from">Indent Date</label>

                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">From</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date_picker"
                                                                        id="indent_date_from" name="indent_date_from"
                                                                        value='{{date("d-m-Y", strtotime("-10 day"))}}' placeholder="dd-mm-yyyy"
                                                                        required />
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date_picker"
                                                                        id="indent_date_to" name="indent_date_to"
                                                                        value="{{date('d-m-Y')}}" placeholder="dd-mm-yyyy"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-sm-12">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-success" id="indent_search"
                                                                onclick="generateSearch(this,'department_indent_search','{{ route('v1.search-department-indent') }}','search_department_indent_search')"><i
                                                                    class="fa fa-search"></i> Search</button>
                                                            <button type="reset" id="resetbtn"
                                                                class="btn btn-info"><i class="fa fa-redo"></i>
                                                                Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="card-body px-0" id="search_department_indent_search">
                                            @include('admin.uhl.inventory.department-indent-table-worklist')

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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script>
     $('.select2').select2();
    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    })

    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
    $(':required').keyup(function() {
        $(this).removeClass('error');
    });
    
    function cancelIndent(element) {
        let indentId = $(element).attr('data-indentId');
        let indentType = $(element).attr('data-type');
        let urlDelete = "{{ route('v2.delete-indent-before-approval') }}"
        if (confirm('Are You Sure?')) {
            $.ajax({
                url: urlDelete,
                type: 'POST', 
                data: {
                    indentId: indentId, 
                    indentType: indentType, 

                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    console.log('Success:', response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error:', error);
                    console.log('Response:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!' + grnId,
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    generateSearch($('#indent_search'),'department_indent_search','{{ route('v1.search-department-indent') }}','search_department_indent_search')
                    $.unblockUI();
                }
            });
        }

    }
</script>
