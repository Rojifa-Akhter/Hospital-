<style>
    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Upload";
    }

    .custom-file-label::after {
        background-color: #01bfff;
        border-left: 1px solid #01bfff;
        color: #fff;
        font-weight: 500;
        padding: 0.2rem 1rem !important;
        font-size: 13px !important;
        line-height: 23px;
    }

    .upload_label {
        background: #f5f8fa;
        color: #213b61;

    }
    .card-footer{
        background-color: white;
    }

</style>
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Ticket Entry Form</h5>
            <small>IPD / Business Office</small>
        </div>
    </div>

    @include('support-team.create_form')

    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>

    <script type="text/javascript">
        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    </script>
