<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <form action="{{ route('employee.store-information') }}" method="post" id="patient-info-create">
        @csrf

        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Employee Detail Information</h5>
                                <small>HRM / Employee Detail Information</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row justify-content-center">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="id_" class="col-form-label">ID</label>
                                            <input type="text" class="form-control form-control-sm" id="employee_id"
                                                name="employee_id" placeholder="" value=""
                                                data-employee-route="{{ route('employee-data') }}" />
                                            <input type="hidden" name="employee_name" id="employee_name"
                                                value="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="col-md-12">
                                <table>
                                    <tr id="0">
                                        <td>
                                            <div class="float-left">
                                                <h5 class="mt-2 mb-0">Whole Sale</h5>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="top-action">


                                                <span class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                                                    id="product_td_action_0" onclick="addNewProduct(this)"
                                                    class="btn btn-md btn-success"> +Add Product </span>
                                            </div>
                                        </td>

                                    </tr>
                                </table>


                            </div>
                            <div class="card-body p-2 0" id="productAdd_0" p_id='0'>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="product_id[]" name="product_id_0"
                                                            placeholder="Enter product name" value="" />

                                                    </td>
                                                    <td id="product_td_0"></td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Colour</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Note</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to">
                                                <tr id="0">
                                                    <td>
                                                        <select
                                                            class="
                                                        form-control font_size_12 m-auto select2"
                                                            name="size[]" id="size_0">
                                                            <option value="0">Select Size</option>

                                                            <option value="">A</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select
                                                            class="
                                                        form-control font_size_12 m-auto select2"
                                                            name="colour[]" id="colour_0">
                                                            <option value="0">Select Colour</option>

                                                            <option value="">A</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="qty[]" id="qty_0" placeholder="Enter qty" />
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="price[]" id="price_0" placeholder="Enter Price" />
                                                    </td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="note[]" id="note_0" placeholder="Enter Note" />
                                                    </td>
                                                    <td>
                                                        <span id="product_td_action_0" onclick="addProductItem(this)"
                                                            class="btn btn-md btn-success"> +Add </span>
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

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            {{-- <button type="button"
                                                class="btn btn-secondary uhl_save_btn"id="">Save</button> --}}

                                            @php
                                                $response_action = route('v1.employee-detail-information');
                                            @endphp
                                            <button class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>

                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger">Cancel</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    // openPatientAutocomplete('#employee_id', 'employee_name');
    openDoctorAutocomplete('#employee_id', 'employee_name', '', '', function(item, obj) {
        patientData(item, obj);
        obj.stopImmediatePropagation();
    });
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    function patientData(empData, patientObj) {
        console.log(empData)
        var emp_id = empData.doctor_id;
        var emr_route = $("#employee_id").attr("data-employee-route");
        window.location = emr_route + "/" + emp_id;
    }

    function addNewProduct(thisElement) {

        var row = $(thisElement).parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').siblings('div#productAdd_0').clone();
        // var row = $(thisElement).parent('div').parent('td').parent('tr').parent('table').parent('div').siblings('div#productAdd_0').clone();
        console.log($(thisElement).parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').siblings('div#productAdd_0').children('div').children('div').children('table').children('thead').children('tr').children('#product_td_0'))


        // console.log(row)
        var oldId = Number($(thisElement).parent('div').parent('td').parent('tr').attr("id"));

        var newId =$(thisElement).parent('div').parent('td').parent('tr').length + 1;
        $(thisElement).parent('div').parent('td').parent('tr').clone().attr('id', newId);
        console.log(oldId + '______________nazmul'+newId);
        $(thisElement).parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').append(row)
        $(thisElement).parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').siblings('div#productAdd_0').children('div').children('div').children('table').children('thead').children('tr').children('#product_td_'+newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );


    }

    function addProductItem(thisElement) {


        var row = $(thisElement).parents("tr").clone();
        console.log(row)
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        row.attr('id', newId);
        row.find('#size_' + oldId).attr('id', 'size_' + newId).val($(thisElement).parents('tbody').find(
            '#size_' + oldId).val());
        row.find('#colour_' + oldId).attr('id', 'colour_' + newId).val($(thisElement).parents('tbody').find(
            '#colour_' + oldId).val());
        $(thisElement).parents('tbody').find('#size_' + oldId).val('Select');
        $(thisElement).parents('tbody').find('#size_' + oldId).val('');

        $(thisElement).parents('tbody').find('#colour_' + oldId).val('Select');
        $(thisElement).parents('tbody').find('#colour_' + oldId).val('');

        $(thisElement).parents('tbody').find('#qty_' + oldId).val('');
        $(thisElement).parents('tbody').find('#price_' + oldId).val('');
        $(thisElement).parents('tbody').find('#note_' + oldId).val('');


        row.find('#product_td_action_' + oldId).attr('id', 'product_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);
        $('#product_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }


    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }

    function removeTableOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }
</script>
