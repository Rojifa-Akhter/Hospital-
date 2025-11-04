<style>
    .receive_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .receive_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .received_patient_table>thead>tr>th {
        font-size: 15px !important;
    }

    .received_patient_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .position-center {
        /* margin-bottom: -30px  */
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Cafeteria Patient List</h5>
                            <small>IPD / Food Station</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search Form --}}
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- Form Row --}}
                            <div class="row justify-content-center border-bottom mb-3 pt-2 pb-2">
                                <form id="cafe_search_form" class="col-12">
                                    <div class="form-row">

                                        <div class="col-md-3">
                                            <label class="col-form-label col-form-label-sm">To Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="admission_date_to" name="admission_date_to"
                                                value="{{ date('d-m-Y') }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="col-form-label col-form-label-sm">Food Category</label>
                                            <select class="form-control form-control-sm select2" id="food_station"
                                                name="food_station" onchange="getDate()">
                                                <option value="">Select Category</option>
                                                @if (!empty($cafeteria))
                                                    @foreach ($cafeteria as $key => $caf)
                                                        <option value="{{ $key }}">{{ $caf }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="col-md-2 d-flex align-items-end">
                                            <button style="margin-right: 10px;" type="button" id="cafe_save" onclick="saveCafe()" class="btn btn-success">Save</button>
                                            {{-- <button type="button" id="cafe_print" onclick="printCafe()" class="btn btn-secondary">Print</button> --}}

                                        </div>
                                        
                                    </div>
                                </form>

                            </div>

                            {{-- Tab Content --}}
                            <div class="tab-content p-0" id="myTabContent">

                                {{-- Received Patient --}}
                                <div class="tab-pane fade show active" id="received_patient" role="tabpanel"
                                    aria-labelledby="received-patient">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover received_patient_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-center" style="width:5%">Bed No</th>
                                                            <th class="text-left" style="width:10%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:8%">IP Date</th>
                                                            <th class="text-center" style="width:4%">IP No</th>
                                                            <th class="text-left" style="width:15%">Consultant</th>
                                                            <th class="text-left" style="width:13%">Department</th>
                                                            <th class="text-left" style="width:9%">Bed Category</th>
                                                            <th class="text-center" style="width:15%">Diet Type</th>
                                                            <th class="text-center" style="width:5%">
                                                                <input type="checkbox" id="select_all">
                                                            </th>
                                                            <th class="text-center" style="width:10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="13" class="text-center">No Data
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> {{-- End Tab Content --}}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    // $(document).ready(function() {
    //     getCafePatient();
    // })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });


    function getDate() {
        let to_date = $('#admission_date_to').val();
        let food_category = $('#food_station').val();

        $.ajax({
            url: "{{ route('ipd.cafe-patient-list-v2') }}",
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                meal_date_to: to_date || null,
                food_category: food_category || null
            },
            beforeSend: function() {
                $('.received_patient_table tbody').html(
                    '<tr><td colspan="10" class="text-center">Loading...</td></tr>'
                );
            },
            success: function(response) {
                console.log(response)
                if (response.length > 0) {
                    setCafePatient(response);
                } else {
                    emptyTable();
                }
            },
            error: function(err) {
                console.log(err);
                emptyTable();
            }
        });
    }

    function emptyTable() {
        $('.received_patient_table tbody').empty();
        $('.received_patient_table tbody').append(`
                <tr>
                    <td colspan="13" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }


    function setCafePatient(data) {
        var table = $('.received_patient_table');


        // Initialize DataTable
        if ($.fn.DataTable.isDataTable(table)) {
            table.DataTable().destroy();
        }
        // Clear existing rows
        table.find('tbody').empty();
        // table.DataTable({
        //     searching: true,
        //     pageLength: 15
        // });
        data.forEach(function(item, index) {
            var admission_date = '';
            if (item.admission_date) {
                var date = new Date(item.admission_date);
                admission_date = ("0" + date.getDate()).slice(-2) + '/' +
                    ("0" + (date.getMonth() + 1)).slice(-2) + '/' +
                    date.getFullYear();
            }
            let mealCompleted = '';
            let patient_checkbox = '';
            let remarks = '';
            if (item.category != null) {
                mealCompleted = 'bg-info';
                patient_checkbox = '';
                remarks = item.remarks ? item.remarks : '';
            }else{

                patient_checkbox=`<input type="checkbox" class="patient_checkbox" value="${item.admission_uid}">`;
                remarks = `<textarea class="form-control form-control-sm patient_remarks" placeholder="Remarks">${item.remarks ?? ''}</textarea>`;
            }
            //for print button
            let button_group = '';
            
            if (item.cafe_complementary_no_pk) {
                let food_url = "{{ route('ipd.cafe-print', [':id']) }}";
                food_url = food_url.replace(':id', item.cafe_complementary_no_pk);
                button_group += `<a href="${food_url}" target="_blank" class="btn btn-sm btn-warning mx-1" title="Food Print">
                                    <i class="fas fa-utensils"></i>
                                </a>`;
            } else {
                button_group += `<button class="btn btn-sm btn-warning mx-1" disabled title="Print not available">
                                    <i class="fas fa-utensils"></i>
                                </button>`;
            }

            var row = `
                <tr class="${mealCompleted}">
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${item.bed_name}</td>
                    <td>${item.patient_name}</td>
                    <td class="text-center">${item.patient_no_fk}</td>
                    <td class="text-center">${admission_date}</td>
                    <td class="text-center">${item.admission_uid}</td>
                    <td>${item.primary_doctor_name}</td>
                    <td>${item.doc_dept}</td>
                    <td>${item.ward_name}</td>
                    <td>${remarks}</td>
                    <td class="text-center">
                        ${patient_checkbox}
                    </td>
                    <td class="text-center">${button_group}</td>
                </tr>
            `;
            table.find('tbody').append(row);
        });


    }

    //for save
    function saveCafe() {
        let selectedPatients = [];
        let to_date = $('#admission_date_to').val();
        let food_category = $('#food_station').val(); 
        
        $('.patient_checkbox:checked').each(function() {
            let admissionId = $(this).val();
            let remark = $(this).closest('tr').find('.patient_remarks').val();
            selectedPatients.push({
                admission_id : admissionId,
                remarks : remark
            });
        });

        if (!food_category) { alert('Please select a category'); return; }
        if (selectedPatients.length === 0) { alert('Please select at least one patient'); return; }

        $.ajax({
            url: "{{ route('ipd.cafe-patient-save') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                patients: selectedPatients,
                meal_date: to_date,
                category: food_category
            },
            beforeSend: function() {
                $('#cafe_save').prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                alert(response.message);
                $('#cafe_save').prop('disabled', false).text('Save');
                getDate(); 
            },
            error: function(err) {
                console.log(err);
                alert('Something went wrong!');
                $('#cafe_save').prop('disabled', false).text('Save');
            }
        });
    }

    $(document).on('change', '#select_all', function() {
        const isChecked = $(this).is(':checked');
        $('.patient_checkbox').prop('checked', isChecked);
    });




</script>
