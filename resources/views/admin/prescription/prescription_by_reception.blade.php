<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Prescription List</h5>
            <small>Prescription / Prescription list</small>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="" id="prsc_by_reception-search" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="invoice_id">Voucher No</label>
                                <input type="text" class="form-control form-control-sm m-0" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                                <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="patient_id">Patient ID </label>
                                <input type="text" class="form-control form-control-sm m-0" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                                <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="referral_doctor">Doctor </label>
                                <input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >
                                <input type="text" class="form-control form-control-sm m-0" id="first_referral" name="first_referral" placeholder="Doctor Code">
                                </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="prescription_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="prescription_date_from" name="prescription_date_from" value="" placeholder="dd-mm-yyyy" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="prescription_date_to" name="prescription_date_to" value="" placeholder="dd-mm-yyyy" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" onclick="generateSearch( this, 'prsc_by_reception-search', 'pta-list' )" class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i> Search</button>
                                    <button type="reset" class="btn btn-info btn-md mt-4"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" id="">
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive" id = "pta-list">
                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Receptionist name</th>
                                    <th class="text-center">Invoice No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone No</th>
                                    <th class="text-center">Doctor</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-left">22/05/2021</td>
                                            <td class="text-left">Super Admin</td>
{{--                                            <td class="text-left">{{ $pr_by_receptionist->prescription_uid}}</td>--}}
                                            <td class="text-left">2583 </td>
                                            <td class="text-left"> AIR CHIEF MARSHAL (AIR CHF MSHL) Nazmul Biswas [POSTED] </td>
                                            <td class="text-left"> 01712344567 </td>
                                            <td class="text-left"> sohel </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success open-modal" data-modal="common-modal-md" data-title="Prescription view" data-action="" ><i class="fa fa-eye"></i></button>
                                                <a href="{{ route('blank-prescription-form', 2583) }}" class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank" data-id=""  title="Print Prescription"> <i class="fa fa-print"></i> </a>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<<script>
    $(document).ready( function () {
        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral','hdn_first_referral_id');

        $('.data-table').DataTable({
            "bLengthChange": false,
            "bAutoWidth": false,
            "bPaginate": false,
            "ordering": false
        });
    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(".date_picker").datepicker("setDate", new Date());

    // openPatientAutocomplete('#service_no', 'service_number', function(item, obj){
    //     $('#patient_name').val(item.patient_name_rank);
    //     $('#mobile_no').val(item.phone_mobile);
    //
    //     obj.stopImmediatePropagation();
    // });
</script>

