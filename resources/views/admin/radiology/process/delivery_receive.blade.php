<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="row justify-content-center">
    <div class="col-md-12 mt-2">
        @include('admin.radiology.process.delivery_receive_search_panel')
    </div>
</div>
<div class="row">
    <div class="col-md-12 d-none" id="pat_bill_info">
        @include('admin.components.patient_bill_info')
    </div>
</div>



<div class="col-md-12" id="receive_search_data">
    @include('admin.radiology.process.delivery_receive_list')
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
