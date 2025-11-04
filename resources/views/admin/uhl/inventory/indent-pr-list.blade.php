<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

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
                                    <a class="nav-link  page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Pending Sample" aria-selected="true"
                                        href="{{ route('v1-department-indent.index') }}" rel="tab">Draft</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Collected Sample" aria-selected="false"
                                        href="{{ route('v1.post-department-indent') }}" rel="tab">Post</a>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                                        aria-controls="Collected Sample" aria-selected="false"
                                        href="{{ route('v1.purchase-order-issue') }}" rel="tab">Received</a>
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
                                                    <div class="col-lg-3 col-md-6 col-12">
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

                                                    <div class="col-md-1"></div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">

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
                                                                        value="" placeholder="yyyy-mm-dd" />
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">To</div>
                                                                    </div>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 date_picker"
                                                                        id="indent_date_to" name="indent_date_to"
                                                                        value="" placeholder="yyyy-mm-dd" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-sm-12">
                                                        <div class="btn-group btn-block" role="group">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="generateSearch(this,'department_indent_search','{{ route('v1.search-department-indent') }}','search_department_indent_search')"><i
                                                                    class="fa fa-search"></i> Search</button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-redo"></i> Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>



                                        <div class="card-body px-0" id="search_department_indent_search">
                                            @include('admin.uhl.inventory.department-indent-pr-table-worklist')

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

<script>
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
    })

    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
