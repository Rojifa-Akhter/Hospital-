<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <div class="float-left">
                <h5 class="mt-2 mb-0">Default Attribute Value Entry</h5>
                <small>Pathology / Default Attribute Value Entry</small>
            </div>
            <div id="top-action"></div>
        </div>
    </div>
    {{-- @include('admin.settings.card_service.create_bank_wise_card_service_form') --}}


    <div class="d-flex justify-content-center">
        <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Attribute Code :
            {{ isset($att_val->teststruct_code) ? $att_val->teststruct_code : '' }}</span>
        <span class="btn btn-outline-primary btn-sm bg-primary ml-2">Attribute Name :
            {{ isset($att_val->attr) ? $att_val->attr : '' }}</span>
    </div>




    <div class="card">
        <form action="{{ route('pathology.store-default-value') }}" method="post" id="bed-charge-create">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $att_val->teststruct_no_pk }}">
            <input type="hidden" name="item_id" id="item_id" value="{{ $att_val->item_no_fk }}">
            <div class="card-body p-2">
                <div class="form-row justify-content-left">
                    <div class="wrapper" id="">
                        <table>
                            <thead>
                                <th class="w-10">Sl No</th>
                                <th class="w-50">Test Result</th>

                                <th>Default</th>
                            </thead>
                            <tbody>
                                <tr id="wrapper_id">
                                    <input type="hidden" class="test_id" name="id" value="{{ $att_val->teststruct_no_pk }}">
                                    <input type="hidden" class="item_id" name="item_id" value="{{ $att_val->item_no_fk }}">
                                    {{-- <input type="hidden" class="sl_no" name="sl_no" value="{{ $att_val->sl_no }}"> --}}
                                    <td><input type="text" class="form-control form-control text-left number_only sl_no"
                                        id="sl_no" name="sl_no[]" value="" placeholder="SL"></td>
                                    <td><input type="text" class="form-control form-control-sm text-left attr_text"
                                            id="test_result" name="test_result[]" value="" placeholder="Enter Test result">
                                    </td>


                                </td>

                                    <td><input type="checkbox" class="attr_checkbox def_chck" id="def_value" name="def_value[]"
                                            value="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-md btn-success mt-4" id="btnDef" onclick="addNewDefaultResult(this)">
                            Add</button>
                    </div>
                </div>
            </div>

            <div class="value_data" id="value_id">
                <table>
                    <tbody>
                        {{-- {{dd($data)}} --}}
                        @if (!empty($data))
                            @foreach ($data as $row)

                                <tr>
                                    <input type="hidden" class="test_id" name="id" value="{{ $row->teststruct_no_fk }}">
                                    <input type="hidden" class="item_id" name="item_id" value="{{ $row->item_no_fk }}">
                                    {{-- <input type="hidden" class="sl_no" name="sl_no" value="{{ $att_val->sl_no }}"> --}}
                                    <td><input type="number" class="form-control form-control-sm text-left number_only sl_no"
                                        id="sl_no" name="sl_no[]" value="{{ $row->sl_no }}" placeholder="SL"></td>
                                    <td><input type="text" class="form-control form-control-sm text-left attr_text"
                                            id="test_result" name="test_result[]" value="{{ $row->test_result }}">

                                    </td>
                                    <td><input type="checkbox" class="attr_checkbox" id="def_value" name="def_value[]"
                                            value="{{ $row->item_no_fk.'`'.  $row->teststruct_no_fk .'`'.$row->test_result.'`'.$row->sl_no }}" {{$row->default_ind == '1' ? 'checked':''}}>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>

            <div>
                @php
                    //  $response_action=url('/room');
                @endphp
                <button class="btn btn-success btn-md mr-2 mb-2 float-right" type="submit"  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage)">Save</button>
                {{-- <span onclick=""  data-action="" class="btn btn-success btn-md mr-2 mb-2 float-right"><i class="fa fa-save"></i>
                    Save</span> --}}
            </div>
        </form>
    </div>



</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>

    $(document).on('keyup','.attr_text',function(){
        var text=$(this).val();
        var test_id=$(this).parent('td').parent('tr').find('.test_id').val();
        var item_id=$(this).parent('td').parent('tr').find('.item_id').val();
        var sl_no=$(this).parent('td').parent('tr').find('.sl_no').val();

        $(this).parent('td').siblings().find('.attr_checkbox').val(item_id+'`'+test_id+'`'+text+'`'+sl_no);
    })

    function addNewDefaultResult(element) {
        var result_data = $("#test_result").val();
        var default_data = $("input[type='checkbox']").val();
        var id = $('#id').val();
        var item_id = $('#item_id').val();
        var sl_no = $('.sl_no').val();



        console.log(item_id+'`'+id+'`'+result_data+'`'+sl_no);
        $("#wrapper_id").clone().prependTo("#value_id");

        // $("#test_result").val('')
        // $("#sl_no").val('')
        $("#item_id").val(item_id)
        $("#id").val(id)

        $("#def_value").val(item_id+'`'+id+'`'+result_data+'`'+sl_no)
        console.log(sl_no)
        $("#test_result").focus()
        $("#wrapper_id").attr('align', 'center');

        $('#btnDef').parent('div').siblings('div').children('table').children('tbody').children('tr').children('td').children('#def_value').prop("checked", false)
        // $(".def_chck").prop("checked", false)
    }




    function storeDefValue(thisElement) {

        console.log('ok')
        var test_result = $("input[name='test_result[]']")
            .map(function() {
                return $(this).val();
            }).get();
        var test_result = $("#test_result").val();
        var test_result_val = $("input[name='def_value[]']")
            .map(function() {
                return $(this).val();
            }).get();
            console.log(test_result_val)

        var test_att_name = $("#id").val();
        var sl_no = $("#sl_no").val();

        console.log(test_result)
        if (confirm("Are you sure?")) {
            var action = $(thisElement).attr("data-action");
            console.log(typeof(test_result))
            $.ajax({
                data: {
                    test_result: test_result,
                    test_result_val: test_result_val,
                    test_att_name: test_att_name,
                    sl_no:sl_no
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {

                    $(thisElement).parents("tr").remove();
                    if (data.title == 'Success') {
                        console.log(data.title);
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    }
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        }
    }
</script>
