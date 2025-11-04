<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="salary_upload">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Salary Excel Data Upload</h5>
                                <small>HRM / Salary Excel Data Upload</small>
                            </div>
                            <div class="col-md-3 text-right">
                                <button type="button" class="btn btn-primary" id="download-btn">
                                Download Sample Excel for upload</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" id="reorder_level_of_service_item_form">
                                @include('admin.hrm.salary_data_upload.salary_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(document).ready(function() {
        $('#download-btn').click(function() {
            const data = [
                ["card_no", "add_arrear", "ded_food_bill", "ded_pf", "ded_adv", "ded_med_bill", "ded_salary", "ded_lwp", "ded_emb", "ded_others"],
                ["11102", "2000", "4000", "5000", "3000", "2500", "3000", "3500", "3500", "2500"],
            ];
            const csvContent = data.map(row => row.join(",")).join("\n");
            const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
            const link = $('<a></a>');
            const url = URL.createObjectURL(blob);
            link.attr('href', url);
            link.attr('download', 'SampleData.csv');
            $('body').append(link);
            link[0].click();
            link.remove();
            URL.revokeObjectURL(url);
        });
    });
    openDoctorAutocomplete("#card_no", 'card_hidn'); 
  
</script>
