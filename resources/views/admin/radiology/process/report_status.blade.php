<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="tab-pane fade show active" id="pending-sample" role="tabpanel" aria-labelledby="received-by-challan-tab">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.radiology.process.report_status_search_panel')
        </div>
    </div>
    <div id="status_list">
         @include('admin.radiology.process.report_status_list')
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $('#PathselectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });
    $('#RadselectAll').click(function(e){
        var table= $(e.target).closest('table');
        $('td input:checkbox',table).prop('checked',this.checked);
    });



    $('.select2').select2();
    openInvoiceAutocomplete("#prescription_id");
    openPatientAutocomplete('#patient_id');
    openAdmissionAutocomplete('#admission_no');


    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format':'dd/mm/yyyy'
        });
    });
</script>
