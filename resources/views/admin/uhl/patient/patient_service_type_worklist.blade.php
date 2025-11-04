<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Patient Service Type Work List</h5>
                        <small>Patient / Patient Service Type</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL#</th>
                                                <th class="text-center">Request Date</th>
                                                <th class="text-left">Service Type</th>
                                                <th class="text-left">Consultant Name</th>
                                                <th class="text-left">Department</th>
                                                <th class="text-left">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="discardAssetList">
                                            @if (!empty($data))
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->appoint_date)) }}</td>
                                                        <td class="text-left">{{ $item->service_type }}</td>
                                                        <td class="text-left">{{ isset($item->doctor_name) ? $item->doctor_name : '' }}</td>
                                                        <td class="text-left">{{ isset($item->dept) ? $item->dept : '' }}</td>
                                                        <td class="text-left">{{ $item->remarks }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        // $("body").addClass("sidebar-collapse");
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });


</script>
