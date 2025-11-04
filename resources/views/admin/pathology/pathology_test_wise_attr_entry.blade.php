<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Pathology Test wise Attribute Entry</h5>
            <small>Pathology / Pathology Test wise Attribute Entry</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Exam List</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('path.item-wise-attr-report-pdf') }}" method="post" id="exam-list-search">
                        @csrf
                        <div class="col-md-12 m-0 p-0">
                            <div class="form-group">
                                <label for="exam_type" class="col-form-label col-form-label-sm">Item Type</label>
                                <select class="form-control form-control-sm" id="exam_type" name="exam_type">
                                    <option value="">Select Item Type</option>
                                    <option value="LAB">Pathology</option>
                                    {{-- <option value="">Radiology</option> --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exam_id" class="col-form-label col-form-label-sm">Item ID</label>
                                <input type="text" class="form-control custom-form" id="exam_id" name="exam_id" value=""
                                    placeholder="Item ID">
                            </div>

                            <div class="form-group">
                                <label for="exam_name" class="col-form-label col-form-label-sm">Item Name</label>
                                <input type="text" class="form-control custom-form" id="exam_name" name="exam_name"
                                    value="" placeholder="Item Name">
                            </div>

                            <div class="form-group">
                                <label for="exam_sample" class="col-form-label col-form-label-sm">Sample</label>
                                <select class="form-control form-control-sm" id="exam_sample" name="exam_sample">
                                    <option value="">Select Sample</option>
                                    @if (!empty($labs_sample))
                                        @foreach ($labs_sample as $sample)
                                            <option value="{{ $sample->sam_no_pk }}">
                                                {{ $sample->sam_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exam_department" class="col-form-label col-form-label-sm">Department</label>
                                <select class="form-control form-control-sm" id="exam_department"
                                    name="exam_department">
                                    <option value="">Select Department</option>
                                    @if (isset($service_unit))
                                        @foreach ($service_unit as $key => $value)
                                            <option value="{{ $value->serviceunit_no_pk }}">
                                                {{ strtoupper($value->serviceunit_name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exam_template" class="col-form-label col-form-label-sm">Template</label>
                                <select class="form-control form-control-sm" id="exam_template" name="exam_template">
                                    <option value="">Select Template</option>
                                    @if (!empty($labs_template))
                                        @foreach ($labs_template as $template)
                                            <option value="{{ $template->test_temp_no_pk }}">
                                                {{ $template->temp_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="item_template"
                                    class="col-form-label col-form-label-sm d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="all" checked>
                                    <label class="form-check-label" for="inlineRadio1">All</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="active">
                                    <label class="form-check-label" for="inlineRadio2">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio3" value="inactive" disabled>
                                    <label class="form-check-label" for="inlineRadio3">Inactive</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">

                                    <button type="button"
                                        onclick="generateSearch( this, 'exam-list-search', '{{ route('path.pathology-test-wise-attr-entry-exam-list') }}', 'exam_list' )"
                                        class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
                                    <button type="submit" class="btn btn-sm btn-warning" target="_blank"><i
                                            class="fas fa-print"></i> Print</button>
                                    <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div id="exam_list" class="col-md-12 m-0 p-0">
                        @include('admin.pathology.pathology_test_wise_attr_entry_exam_list')
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header">Attribute Setup
                    <!--  <a href="{{ url('path/bc-report-pdf') }}" class="btn btn-sm btn-warning" target="_blank">Print</a> -->
                    <a class="float-right btn btn-warning btn-sm" id="attr_print" target="_blank"
                        style=" text-decoration: none !important;"><i class="fas fa-print"></i> Print Attribute </a>

                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="item_no">Item No.</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control custom-form" id="item_no" name="item_no"
                                        value="" placeholder="Item No." readonly>
                                    <input type="text" class="form-control custom-form" id="item_barcode"
                                        name="item_barcode" value="" placeholder="Barcode" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="item_name" class="col-form-label col-form-label-sm">Item Name</label>
                                <input type="text" class="form-control custom-form" id="item_name" name="item_name"
                                    value="" placeholder="Item Name" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="item_sample" class="col-form-label col-form-label-sm">Sample</label>
                                <input type="text" class="form-control custom-form" id="item_sample" name="item_sample"
                                    value="" placeholder="Sample Name" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="item_department" class="col-form-label col-form-label-sm">Department</label>
                                <input type="text" class="form-control custom-form" id="item_department"
                                    name="item_department" value="" placeholder="Department" readonly>
                            </div>
                        </div>

                        <form action="{{ route('path.store-pathology-test-wise-attr-entry') }}" method="post"
                            id="attribute-setup">
                            <div class="col-md-12">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th class="w-5">SL</th>
                                            <th class="w-5">Attribute Code</th>
                                            <th class="">Attribute</th>
                                            <th class="w-10">Unit</th>
                                            <th class="W-10" colspan="2">A.G</th>
                                            <th class="W-10" colspan="2">RS Input</th>
                                            <th class="w-10">GS</th>
                                            {{-- <th class="">SF</th>
                                            <th class="w-5">HP</th>
                                            <th class="w-5">GI</th>
                                            <th class="w-5">Active</th>
                                            <th class="">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="">
                                                <input type="hidden" id="item_no2" name="item_no" value=""
                                                    placeholder="Item No." required>
                                                <input type="hidden" id="teststruct_no_pk" name="teststruct_no_pk"
                                                    value="" placeholder="">
                                                <input type="text" class="form-control custom-form" id="sl_no"
                                                    name="sl_no" value="" placeholder="" required>
                                            </td>
                                            <td class=""><input type="text"
                                                class="form-control custom-form" id="attr_code" name="attr_code"
                                                value="" placeholder="" required style="width: 170px;"></td>
                                            <td class=""><input type="text"
                                                    class="form-control custom-form" id="attr_attr" name="attr_attr"
                                                    value="" placeholder="" required style="width: 130px;"></td>
                                            <td class=""><input type="text"
                                                    class="form-control custom-form" id="attr_unit" name="attr_unit"
                                                    value="" placeholder=""></td>
                                            <td class="" colspan="2">
                                                <select class="form-control form-control-sm" id="attr_ag"
                                                    name="attr_ag" style="width: 250px;">
                                                    <option value="">Select A.G</option>
                                                    @if (!empty($labs_testAttrGroup))
                                                        @foreach ($labs_testAttrGroup as $attrGroup)
                                                            <option value="{{ $attrGroup->test_group_no_pk }}">
                                                                {{ $attrGroup->attrgroup }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>

                                            <td colspan="2">
                                                <select name="rs_input" id="rs_input"
                                                    class="form-control form-control-sm" onchange="rsvalueFunc(this)">
                                                    <option value="1" onclick="rsvalueFunc(this)">TEXT</option>
                                                    <option value="2" onclick="rsvalueFunc(this)">NUMBER</option>
                                                    <option value="3" onclick="rsvalueFunc(this)">DATE</option>

                                                    <option value="list" id="rsValue"
                                                        disabled="disabled">LIST</option>
                                                    </option>
                                                </select>
                                            </td>





                                            <td class=""><input type="number"
                                                    class="form-control custom-form" id="attr_gs" name="attr_gs"
                                                    value="" placeholder=""></td>
                                            {{-- <td class=""><input type="checkbox" class="attr_checkbox" id="attr_sf" name="attr_sf" value="1" ></td>
								<td class=""><input type="checkbox" class="attr_checkbox" id="attr_hp" name="attr_hp" value="1" ></td>
								<td class=""><input type="checkbox" class="attr_checkbox" id="attr_gi" name="attr_gi" value="1" ></td>
								<td class=""><input type="checkbox" class="attr_checkbox" id="attr_status" name="attr_status" value="1" ></td>
								<td class="">
									<button type="submit" class="btn btn-sm btn-success btn-attr-save">Save</button>
									<button type="reset" class="btn btn-sm btn-danger  btn-attr-clear">Clear</button>
								</td> --}}




                                        <tr>

                                            {{-- <th class="w-5">GS</th> --}}
                                            <th class="">SF</th>
                                            <th class="w-5">HP</th>
                                            <th class="w-5">GI</th>
                                            <th class="w-5">Active</th>
                                            <th class="">Show</th>

                                        </tr>
                                        <tr>


                                            <td class=""><input type="checkbox" class="attr_checkbox"
                                                    id="attr_sf" name="attr_sf" value="1"></td>
                                            <td class=""><input type="checkbox" class="attr_checkbox"
                                                    id="attr_hp" name="attr_hp" value="1"></td>
                                            <td class=""><input type="checkbox" class="attr_checkbox"
                                                    id="attr_gi" name="attr_gi" value="1"></td>
                                            <td class=""><input type="checkbox" class="attr_checkbox"
                                                    id="attr_status" name="attr_status" value="1">





                                                </td>
                                            <td class="">

                                                <input type="checkbox" class="attr_checkbox"
                                                id="show_column" name="show_column" value="1" >


                                                <button type="submit"
                                                    class="btn btn-md ml-5 btn-success btn-attr-save" >Save</button>
                                                <button type="reset"
                                                    class="btn btn-md btn-danger  btn-attr-clear">Clear</button>
                                                <span class="btn btn-primary btn-md open-modal def_value d-none"
                                                    id="attvalId" data-modal="common-modal-md" data-action="#"
                                                    data-title="Add Default Values"><i class="fa fa-plus"></i> Add
                                                    Default Values</span>
                                            </td>

                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="card border-0">
                <div class="card-body p-2">
                    <div class="form-row">
                        <div class="col-md-9">
                            <div class="card mt-0">
                                <div class="card-body p-2" id="attr_list">
                                    @include('admin.pathology.pathology_test_wise_attr_list')
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card mt-0">
                                <div class="card-header d-flex">
                                    <h5 class="col-md-6 text-left">Analyzer</h5>
                                    <h5 class="col-md-6 text-right">Active</h5>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 m-0 p-0" id="attr_analyzer_list">
                                        @include('admin.pathology.pathology_test_wise_attr_analyzer_list')
                                    </div>

                                    <form action="{{ route('path.store-pathology-test-wise-attr-analyzer') }}"
                                        method="post" id="store-analyzer-entry">
                                        <div class="col-md-12 m-0 p-0" id="analyzer_entry_list">
                                            <input type="hidden" id="teststruct_no" name="teststruct_no" value=""
                                                placeholder="" required>
                                            <input type="hidden" id="analyzerattr_no_pk" name="analyzerattr_no_pk"
                                                value="" placeholder="">
                                            <input type="hidden" id="analyzer_name_hidden" name="analyzer_name_hidden"
                                                value="" placeholder="">
                                            <div class="form-group">
                                                <label for="analyzer"
                                                    class="col-form-label col-form-label-sm">Analyzer</label>
                                                <select class="form-control form-control-sm" id="analyzer"
                                                    name="analyzer">
                                                    <option value="">Select Analyzer</option>
                                                    @if (isset($analyzerList))
                                                        @foreach ($analyzerList as $key => $value)
                                                            <option value="{{ $value->item_no_pk }}">
                                                                {{ strtoupper($value->item_name) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="matchine_attribute"
                                                    class="col-form-label col-form-label-sm">Matchine Attribute</label>
                                                <input type="text" class="form-control custom-form"
                                                    id="matchine_attribute" name="matchine_attribute" value=""
                                                    placeholder="Matchine Attribute">
                                            </div>

                                            <div class="form-group">
                                                <label for="panel_attribute"
                                                    class="col-form-label col-form-label-sm">Panel Attribute</label>
                                                <input type="text" class="form-control custom-form"
                                                    id="panel_attribute" name="panel_attribute" value=""
                                                    placeholder="Panel Attribute">
                                            </div>

                                            <div class="form-group">
                                                <label for="unit" class="col-form-label col-form-label-sm">Unit</label>
                                                <input type="text" class="form-control custom-form" id="unit"
                                                    name="unit" value="" placeholder="Unit">
                                            </div>

                                            <div class="form-group">
                                                <label for="normal_result"
                                                    class="col-form-label col-form-label-sm">Normal Result</label>
                                                <textarea class="form-control custom-form" id="normal_result" name="normal_result" value="" placeholder="Normal Result"
                                                    name="" id="" rows="3"></textarea>
                                            </div>
                                            <label for="analyzer_status"
                                                class="col-form-label col-form-label-sm"><input type="checkbox"
                                                    class="analyzer_checkbox mr-2" id="analyzer_status"
                                                    name="analyzer_status" value="1"> Status </label>
                                            <div class="col-md-12 m-0 p-0 text-right">
                                                <button type="submit" class="btn btn-sm btn-success btn-analyser-save">
                                                    Save</button>
                                                <button type="reset"
                                                    class="btn btn-sm btn-danger btn-analyzer-clear">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('path.store-pathology-test-wise-attr-reference-value-entry') }}"
                            method="post" id="store-attr-refval-entry">
                            <div class="col-md-12 m-0 p-0">
                                <div class="col-md-12">
                                    <hr>
                                    <input type="hidden" id="attrrefval_referencevalue_no_pk"
                                        name="attrrefval_referencevalue_no_pk" value="" placeholder="">
                                    <input type="hidden" id="attrrefval_teststruct_no" name="attrrefval_teststruct_no"
                                        value="" placeholder="" required>
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <th class="text-left">Gender <Span class="text-danger">*</Span>
                                            </th>
                                            <th class="text-left">A.G </th>
                                            <th class="text-left w-5">DD</th>
                                            <th class="text-left w-5">MM</th>
                                            <th class="text-left w-5">YY</th>
                                            <th class="text-left">Normal Result </th>
                                            <th class="text-left">CMP</th>
                                        </thead>
                                        <tbody>

                                            <td class="text-left">
                                                <select class="form-control form-control-sm" id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Both">Both</option>
                                                </select>
                                            </td>

                                            <td class="text-left">
                                                <select class="form-control form-control-sm" id="age_group"
                                                    name="age_group">
                                                    <option value="">Select A.G</option>
                                                    @if (!empty($labs_ageGroup))
                                                        @foreach ($labs_ageGroup as $ageGroup)
                                                            <option value="{{ $ageGroup->ref_group_no_pk }}">
                                                                {{ $ageGroup->group_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control custom-form" id="high_age_dd"
                                                    name="high_age_dd" value="" placeholder="">
                                                <input type="text" class="form-control custom-form" id="low_age_dd"
                                                    name="low_age_dd" value="" placeholder="">
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control custom-form" id="high_age_mm"
                                                    name="high_age_mm" value="" placeholder="">
                                                <input type="text" class="form-control custom-form" id="low_age_mm"
                                                    name="low_age_mm" value="" placeholder="">
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="form-control custom-form" id="high_age_yy"
                                                    name="high_age_yy" value="" placeholder="">
                                                <input type="text" class="form-control custom-form" id="low_age_yy"
                                                    name="low_age_yy" value="" placeholder="">
                                            </td>
                                            <td class="text-left">
                                                <textarea class="form-control custom-form" id="age_normal_result" name="normal_result" value=""
                                                    placeholder="Normal Result" id="" rows="3"></textarea>


                                                {{-- <input type="text" class="form-control custom-form" id="age_normal_result" name="normal_result" value="" placeholder=""> --}}
                                            </td>
                                            <td class="text-left"><input type="text"
                                                    class="form-control custom-form" id="com_operator"
                                                    name="com_operator" value="" placeholder=""></td>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="normal_range">Normal
                                            Range</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control custom-form" id="low_result"
                                                name="low_result" value="" placeholder="0">
                                            <input type="text" class="form-control custom-form" id="high_result"
                                                name="high_result" value="" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="critical_range">Critical
                                            Range</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control custom-form"
                                                id="low_critical_result" name="low_critical_result" value=""
                                                placeholder="0">
                                            <input type="text" class="form-control custom-form"
                                                id="high_critical_result" name="high_critical_result" value=""
                                                placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="">Action</label>
                                        <div class="input-group mb-2">
                                            <button type="submit" class="btn btn-sm btn-success w-50">Save</button>
                                            <button type="reset"
                                                class="btn btn-sm btn-danger w-50 btn-attrrefval-clear">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12" id="attr-reference-value-list">
                            @include('admin.pathology.pathology_test_wise_attr_test_referencevalue_list')
                        </div>

                    </div>


                </div>
            </div>



        </div>








    </div>
</div>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(".data-table").DataTable({
        "ordering": false,
        "bPaginate": true,
        "bLengthChange": false,
        "bAutoWidth": true
    });

    openPtaItemAutocomplete('#exam_name', 'item_name', 'LAB', function(item, obj) {
        $('#exam_id').val(item.item_code);
        obj.stopImmediatePropagation();
    });
    openPtaItemAutocomplete('#exam_id', 'item_code', 'LAB', function(item, obj) {
        $('#exam_name').val(item.item_name);
        obj.stopImmediatePropagation();
    });

    $(document).on("click", ".exam_name, .exam_uid", function(e) {

        $("#attribute-setup")[0].reset();
        $("#attribute-setup").find('#teststruct_no_pk').val(0)
        $("#attribute-setup").find('.attr_checkbox').attr('checked', false);
        $("#store-analyzer-entry")[0].reset();
        $("#store-analyzer-entry").find('#analyzerattr_no_pk').val('')
        $("#store-analyzer-entry").find('.analyzer_checkbox').attr('checked', false);
        $("#store-attr-refval-entry")[0].reset();
        $("#store-attr-refval-entry").find('#attrrefval_referencevalue_no_pk').val('')




        var exam_id_hidden = parseInt($(this).siblings('#exam_id_hidden').val());
        var item_name_hidden = $(this).siblings('#item_name_hidden').val();
        var sam_name_hidden = $(this).siblings('#sam_name_hidden').val();
        var su_name_hidden = $(this).siblings('#su_name_hidden').val();
        var url = "{{ url('path/attr-report-pdf', '') }}" + "/" + exam_id_hidden;


        $('#item_no').val(exam_id_hidden)
        $('#item_no2').val(exam_id_hidden)
        $('#item_name').val(item_name_hidden)
        $('#item_sample').val(sam_name_hidden)
        $('#item_department').val(su_name_hidden)
        $('#attr_print').attr("href", url);
        $('.exam_name, .exam_uid').closest('tr').removeClass('bg-navy');
        $(this).closest('tr').addClass('bg-navy');
        reloadAttrList(exam_id_hidden)
        reloadAttrAnalyzerList('')
        reloadAttrRefValList('')

        $('#show_column').attr('checked', true);
    });
    $(document).on("click", ".tr_attrList", function(e) {
        $("#store-analyzer-entry")[0].reset();
        $("#store-analyzer-entry").find('#analyzerattr_no_pk').val('')
        $("#store-analyzer-entry").find('.analyzer_checkbox').attr('checked', false);
        $("#store-attr-refval-entry")[0].reset();
        $("#store-attr-refval-entry").find('#attrrefval_referencevalue_no_pk').val('')


        var exam_id_hidden = parseInt($(this).find('input[name=exam_id_hidden]').val());
        var teststruct_no_pk_hidden = parseInt($(this).find('input[name=teststruct_no_pk_hidden]').val());
        var test_group_no_fk_hidden = parseInt($(this).find('input[name=test_group_no_fk_hidden]').val());
        var sl_no = parseInt($(this).find('.sl').text());
        var attr_code = $(this).find('.attr_code').text();
        var attr = $(this).find('.attr').text();
        var unit = $(this).find('.unit').text();
        var attrgroup = $(this).find('.attrgroup').text();
        var group_seq = parseInt($(this).find('.group_seq').text());
        var show_ind = parseInt($(this).find('td').find('input[name=show_ind]').val())
        var hide_permanent = parseInt($(this).find('td').find('input[name=hide_permanent]').val())
        var graph_ind = parseInt($(this).find('td').find('input[name=graph_ind]').val())
        var status = parseInt($(this).find('td').find('input[name=status]').val())
        var show_ind = parseInt($(this).find('td').find('input[name=show_ind]').val())
console.log(show_ind)

        $('#sl_no').val(sl_no)
        $('#teststruct_no_pk').val(teststruct_no_pk_hidden)
        $('#teststruct_no').val(teststruct_no_pk_hidden)
        $('#attrrefval_teststruct_no').val(teststruct_no_pk_hidden)
        $('#attr_code').val(attr_code)
        $('#attr_attr').val(attr)
        $('#attr_unit').val(unit)
        $('#attr_ag').val(test_group_no_fk_hidden).change()
        $('#attr_gs').val(group_seq)




        // return '<button class="btn btn-primary btn-md open-modal def_value d-none" id="attvalId" data-modal="common-modal-md"' +
        // teststruct_no_pk_hidden + '" data-action="' + value_action +
        //     ' data-title="Add Default Values"><i class="fa fa-plus"></i> Add Default Values</button>';

        if (teststruct_no_pk_hidden != '') {
            $('#rsValue').attr('disabled', false);

        }



        if (show_ind == 1) {
            $('#attr_sf').attr("checked", true)
        }
        if (hide_permanent == 1) {
            $('#attr_hp').attr("checked", true)
        }
        if (graph_ind == 1) {
            $('#attr_gi').attr("checked", true)
        }
        if (status == 1) {
            $('#attr_status').attr("checked", true)
        }
        if (show_ind == 0) {
            $('#show_column').attr("checked", false)
        }

        $('.tr_attrList').removeClass('bg-navy');
        $(this).addClass('bg-navy');

        reloadAttrAnalyzerList(teststruct_no_pk_hidden)
        reloadAttrRefValList(teststruct_no_pk_hidden)


        $('.def_value').addClass('d-none');
    });

    $(document).on("click", ".btn-attr-clear", function() {
        $(this).closest('form').find("input[type=text],input[type=hidden], textarea").val("");
        $(this).closest('form').find('.attr_checkbox').attr('checked', false);
        $("#item_no2").val(parseInt($("#item_no").val()))

    })
    $('#attribute-setup').submit(function(e) {
        e.preventDefault()
        var formAction = $(this).attr("action");
        var formMethod = $(this).attr("method");
        var formData = new FormData(this);

        var item_no = parseInt($("#item_no2").val())
        if (isNaN(item_no)) {
            alert('Please, select a test item.');
            e.stopImmediatePropagation();
            return false;
        }

        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        reloadAttrList(item_no)
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                        $("#attribute-setup")[0].reset();
                        $("#attribute-setup").find('#teststruct_no_pk').val('')
                        $("#attribute-setup").find('.attr_checkbox').attr('checked', false);
                    }
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();
    });


    $(document).on("click", ".tr_analyzerList", function(e) {

        var analyzerattr_no_pk_hidden = parseInt($(this).find('input[name=analyzerattr_no_pk_hidden]').val());
        var machine_attrib_hidden = $(this).find('input[name=machine_attrib_hidden]').val();
        var panel_attrib_hidden = $(this).find('input[name=panel_attrib_hidden]').val();
        var normal_result_hidden = $(this).find('input[name=normal_result_hidden]').val();
        var unit_hidden = $(this).find('input[name=unit_hidden]').val();
        var analyzer_no_hidden = parseInt($(this).find('input[name=analyzer_no_hidden]').val());
        var status = parseInt($(this).find('td').find('input[name=status]').val())

        $('#analyzer').val(analyzer_no_hidden).change()
        $('#analyzerattr_no_pk').val(analyzerattr_no_pk_hidden)
        $('#matchine_attribute').val(machine_attrib_hidden)
        $('#panel_attribute').val(panel_attrib_hidden)
        $('#unit').val(unit_hidden)
        $('#normal_result').val(normal_result_hidden)
        if (status == 1) {
            $('#analyzer_status').attr("checked", true)
        }

        $('.tr_analyzerList').removeClass('bg-navy');
        $(this).addClass('bg-navy');

    });

    $(document).on("change", "#analyzer", function() {
        var analyzer_txt = $("#analyzer  option:selected").text();
        $("#analyzer_name_hidden").val(analyzer_txt)
    })

    $(document).on("click", ".btn-analyzer-clear", function() {
        var teststruct_no = parseInt($("#teststruct_no").val());
        $(this).closest('form').find("input[type=text],input[type=hidden], textarea").val("");
        $(this).closest('form').find('.analyzer_checkbox').attr('checked', false);
        $("#teststruct_no").val(teststruct_no)
    })

    $('#store-analyzer-entry').submit(function(e) {
        e.preventDefault()
        var formAction = $(this).attr("action");
        var formMethod = $(this).attr("method");
        var formData = new FormData(this);

        var teststruct_no = parseInt($("#teststruct_no").val());
        if (isNaN(teststruct_no)) {
            alert('Please, select a test attribute.');
            e.stopImmediatePropagation();
            return false;
        }

        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        reloadAttrAnalyzerList(teststruct_no)
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                        $("#store-analyzer-entry")[0].reset();
                        $("#store-analyzer-entry").find('#analyzerattr_no_pk').val('')
                        $("#store-analyzer-entry").find('.analyzer_checkbox').attr('checked',
                            false);


                    }
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".btn-attrrefval-clear", function() {
        var teststruct_no = parseInt($("#attrrefval_teststruct_no").val());
        $(this).closest('form').find("input[type=text],input[type=hidden], textarea").val("");
        $("#attrrefval_teststruct_no").val(teststruct_no)
    })


    $('#store-attr-refval-entry').submit(function(e) {
        e.preventDefault()
        var formAction = $(this).attr("action");
        var formMethod = $(this).attr("method");
        var formData = new FormData(this);

        var teststruct_no = parseInt($("#attrrefval_teststruct_no").val());
        if (isNaN(teststruct_no)) {
            e.stopImmediatePropagation();
            alert('Please, select a test attribute.');
            return false;
        }

        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        reloadAttrRefValList(teststruct_no);
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                        $("#store-attr-refval-entry")[0].reset();
                        $("#store-attr-refval-entry").find('#attrrefval_referencevalue_no_pk').val(
                            '')


                    }
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".btn-attrRefval-remove", function(e) {
        e.preventDefault()
        var referencevalue_no_pk = parseInt($(this).attr('data-val'))
        var teststruct_no_fk = parseInt($(this).attr('data-teststruct_no_fk'))
        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                type: 'post',
                url: "{{ route('path.pathology-test-wise-attrRefVal-remove') }}",
                data: {
                    referencevalue_no_pk: referencevalue_no_pk
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Delete') {
                        reloadAttrRefValList(teststruct_no_fk);
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    }
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
        }

        e.stopImmediatePropagation();
    })

    // Edit Attribute
    $(document).on("click", ".btn-attrRefval-edit", function(e) {
        e.preventDefault()
        var referencevalue_no_pk = parseInt($(this).attr('data-val'))
        var gender = $(this).closest('tr').find('.gender').text()
        var ref_group_no_fk = $(this).closest('tr').find('td').find('input[name=ref_group_no_fk]').val()
        var normal_result = $(this).closest('tr').find('.normal_result').text()
        var com_operator = $(this).closest('tr').find('.com_operator').text()
        var high_age_dd = $(this).closest('tr').find('td').find('input[name=high_age_dd]').val()
        var low_age_dd = $(this).closest('tr').find('td').find('input[name=low_age_dd]').val()
        var high_age_mm = $(this).closest('tr').find('td').find('input[name=high_age_mm]').val()
        var low_age_mm = $(this).closest('tr').find('td').find('input[name=low_age_mm]').val()
        var high_age_yy = $(this).closest('tr').find('td').find('input[name=high_age_yy]').val()
        var low_age_yy = $(this).closest('tr').find('td').find('input[name=low_age_yy]').val()
        var low_result = $(this).closest('tr').find('td').find('input[name=low_result]').val()
        var high_result = $(this).closest('tr').find('td').find('input[name=high_result]').val()
        var low_critical_result = $(this).closest('tr').find('td').find('input[name=low_critical_result]').val()
        var high_critical_result = $(this).closest('tr').find('td').find('input[name=high_critical_result]')
            .val()

        $('#attrrefval_referencevalue_no_pk').val(referencevalue_no_pk);
        $('#gender').val(gender).change();
        $('#age_group').val(ref_group_no_fk).change();
        $('#high_age_dd').val(high_age_dd);
        $('#low_age_dd').val(low_age_dd);
        $('#high_age_mm').val(high_age_mm);
        $('#low_age_mm').val(low_age_mm);
        $('#high_age_yy').val(high_age_yy);
        $('#low_age_yy').val(low_age_yy);
        $('#age_normal_result').val(normal_result);
        $('#com_operator').val(com_operator);
        $('#low_result').val(low_result);
        $('#high_result').val(high_result);
        $('#low_critical_result').val(low_critical_result);
        $('#high_critical_result').val(high_critical_result);

        e.stopImmediatePropagation();
    })

    function reloadAttrList(exam_id_hidden) {
        var url = "{{ route('path.pathology-test-wise-attr-list') }}";
        $.ajax({
            data: {
                exam_id_hidden: exam_id_hidden
            },
            url: url,
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#attr_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function reloadAttrAnalyzerList(teststruct_no_fk) {
        var url = "{{ route('path.pathology-test-wise-attr-analyzer-list') }}";
        $.ajax({
            data: {
                teststruct_no_pk: teststruct_no_fk
            },
            url: url,
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#attr_analyzer_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function reloadAttrRefValList(teststruct_no_fk) {
        var url = "{{ route('path.pathology-test-wise-attr-reference-value-list') }}";
        $.ajax({
            data: {
                teststruct_no_pk: teststruct_no_fk
            },
            url: url,
            type: "post",
            beforeSend: function() {},
            success: function(data) {
                $("#attr-reference-value-list").html(data);
            },
            complete: function() {}
        });
    }
    // function attrReport(element){
    // 	var url= "{{ route('path.attr-report-pdf') }}";
    // 	var item_no=$('#item_no2').val();
    // 	$.ajax({
    // 		data: {item_no : item_no},
    // 		url:url,
    // 		type: "post",
    // 		beforeSend: function() {
    // 		},
    // 		success: function(data) {
    // 			$("#attr-reference-value-list").html(data);
    // 		},
    // 		complete: function() {
    // 		}
    // 	});
    // }

    // $(document).on('change','#rsValue',function(){
    //     console.log($(this).val())
    // var rs_value = $(this).val();
    // if ($(this).val() == 'list') {
    //     $('.def_value').removeClass('d-none');
    // } else {
    //     $('.def_value').addClass('d-none');
    // }

    // });


    function rsvalueFunc(element) {
        // var rs_value = $(this).val();
        console.log($(element).val())
        if ($(element).val() == 'list') {
            $('.def_value').removeClass('d-none');
        } else {
            $('.def_value').addClass('d-none');
        }

        var teststruct_no_pk_hidden = $('#teststruct_no_pk').val()
        // alert(teststruct_no_pk_hidden)
        console.log(teststruct_no_pk_hidden)

        var value_action = "{{ route('add-attr-value', ':id') }}";
        value_action = value_action.replace(':id', teststruct_no_pk_hidden);

        $("#attvalId").attr("data-action", value_action)
        console.log(value_action)
    }
</script>
