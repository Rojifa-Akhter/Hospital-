<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <form action="" id="v1-department-indent" method="POST">
        @csrf
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Diet Chart</h5>
                                <small>Diet Chart / Create Diet Chart</small>
                            </div>

                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="text-right">
                                    <a rel="tab" href="{{ route('dietChart.index') }}" class="btn btn-success uhl_common_outline_btn">
                                        <i class="fa fa-plus"></i>&nbsp;Diet Chart List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">

                                        {{-- Name --}}
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="name" class="col-sm-4 col-form-label">Diet Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Diet Chart Name..." />
                                                </div>
                                            </div>

                                        {{-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="serviceunit_no_fk" class="col-sm-4 col-form-label">Name <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" id="serviceunit_no_fk" required>
                                                        <option value="" selected disabled>Select Department</option>
                                                        @if (!empty($departments))
                                                            @foreach ($departments as $row)
                                                                <option value="{{ $row->serviceunit_no_pk }}">
                                                                    {{ $row->serviceunit_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div> --}}
                                        </div>

                                        {{-- Price --}}
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="price" class="col-sm-4 col-form-label">Price</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="price" min="0" id="price" class="form-control form-control-sm"
                                                        id="price" placeholder="Enter Diet Price..." />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">

                                        {{-- Diet Type --}}
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="diet_no_fk" class="col-sm-6 col-form-label">Diet Type <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" id="diet_no_fk" name="diet_no_fk" required>
                                                        <option value="" selected disabled>Select Diet Type</option>
                                                        @if (!empty($diets))
                                                            @foreach ($diets as $diet)
                                                                <option value="{{ $diet->diet_no_pk }}">{{ $diet->diet_name }} ({{ $diet->diet_time }})</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Food --}}
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="food_no_fk" class="col-sm-6 col-form-label">Food <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2" id="food_no_fk" name="food_no_fk[]" multiple required>                                
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-8"></div>
                                        <div class="col-lg-4">
                                            <button type="button"
                                                class="btn btn-success uhl_common_btn btn-md float-right mt-2"
                                                id="add_item_btn">Add item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width: 5%;">Sl.</th>
                                                <th style="width: 20%; text-align: center;">Diet Type</th>
                                                <th style="width: 70%; text-align: center;">Foods</th>
                                                <th style="width: 5%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id='demand_items_list'>
                                            {{-- @if (!empty($requisition_itens))
                                                @foreach ($requisition_itens as $item)
                                                    <tr>
                                                        <td class="sl-td">{{ $loop->iteration }}</td>
                                                        <td>{{ $item->item_name }}
                                                            <input type="hidden" value="{{ $item->item_no_fk }}"
                                                                name="item_id_hidden[]" class="item_id">
                                                            <input type="hidden" value="" name="item_uom[]">
                                                            <input type="hidden" value="{{ $item->uom }}"
                                                                name="uom_no_fk[]">

                                                            <input type="hidden" value="" name="last_pp[]">

                                                            <input type="hidden"
                                                                value="{{ isset($item->urgent_ind) ? $item->urgent_ind : '' }}"
                                                                name="urgent_ind[]">
                                                            <input type="hidden"
                                                                value="{{ isset($item->exact_ind) ? $item->exact_ind : '' }}"
                                                                name="exact_ind[]">
                                                            <input type="hidden" value=""
                                                                name="global_stock[]">
                                                            <input type="hidden" value=""
                                                                name="global_stock_store[]">


                                                        </td>
                                                        <td class="text-left">{{ $item->uom_code }}</td>
                                                        <td class="text-right">
                                                            <input type="text"
                                                                class="form-control form-control-sm tt-input text-right item_quantity"
                                                                value="{{ $item->req_quantity }}"
                                                                name="item_quantity[]">
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td> <input type="text"
                                                                class=" form-control form-control-sm"
                                                                value="{{ $item->item_remarks != '0' ? $item->item_remarks : '' }}"
                                                                name="remarks[]">
                                                        </td>
                                                        <td class="text-left">
                                                            Urgent: {{ $item->urgent_ind == 1 ? 'Y' : 'N' }}
                                                            Exact: {{ $item->exact_ind == 1 ? 'Y' : 'N' }}
                                                        </td>
                                                        <td>
                                                            <input type="text "
                                                                class="date_picker2 form-control form-control-sm"
                                                                value="{{ isset($item->expect_date) ? date('d-m-Y', strtotime($item->expect_date)) : '' }}"
                                                                name="expected_date[]">
                                                        </td>
                                                        <td class="text-left">
                                                            Global: 0<br>
                                                            To Store:0
                                                        </td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-left">
                                                            7 Days: 0 <br>
                                                            30 Days: 0
                                                        </td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-primary"><i
                                                                    class="far fa-edit"></i></button>
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-danger remove-item-btn"
                                                                data-remove_item="{{ $item->inv_requisitiondtl_no_pk }}"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                {{-- Note --}}
                                <div class="form-group form-row">
                                    <label for="note" class="col-sm-1 col-form-label">Note</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control form-control-sm" name="note" id="note" placeholder="Note"
                                            row="3" style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $response_action = route('dietChart.index');
                @endphp
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" id="remove_item_id" value="">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            {{-- <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                >Save</button> --}}

                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="submit">Save</button>
                                        </li>
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


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $('#diet_no_fk').on('change', function(e) {
        let _value = $(this).val();

        var route = '{{ route("dietChart.getFoodsByMealType", ":id") }}';
        route = route.replace(':id', _value);

        if(_value != "") {
            $.ajax({
                data: null,
                url: route,
                type: "GET",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $("#food_no_fk").empty();
                    response.foods.map(food => {
                        console.log(food.food_no_fk, food.food_name);
                        console.log();
                        $("#food_no_fk").append(
                            new Option(food.food_name, food.food_no_fk),
                        );
                    });
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    });

    var currentDate = new Date();
    $('#req_date').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    }).datepicker('setDate', currentDate);




    // $(".date_picker").datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    // });

    // $(".date_picker").on("change", function() {
    //     $(this).focus();
    // });

    // $(".date_picker2").datepicker({
    //     format: 'dd-mm-yyyy',
    //     startDate: new Date(),
    //     autoclose: true
    // });

    // $(".date_picker2").on("change", function() {
    //     $(this).focus();
    // });

    $("body").addClass("sidebar-collapse");
    $('.select2').select2();

    function showHide(value) {
        console.log(value);
        if (value == 'Patient') {
            $('#pat_dev').removeClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').addClass('d-none');
        }
        if (value == 'Event') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').removeClass('d-none');
        }
        if (value == 'Employee') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').removeClass('d-none');
            $('#event_dev').addClass('d-none');
        }
    }

    function generateItemList(item, obj) {
        $.ajax({
            async: true,
            data: {
                generic_no_pk: item.generic_no_pk
            },
            url: "{{ route('v1.generic-wise-item-list') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                //$('.select2').select2('destroy');
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                //console.log(data);
                $('#item_block').html(data);
            },
            complete: function() {
                $('.select2').select2();
                $.unblockUI();
            },
            error: function(data) {

                $.unblockUI();
            }
        });
    }

    function checkGenericHidden() {
        var hdn_generic_val = $('#hdn_generic_id').val() * 1;
        var html =
            '<input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder>';
        if (hdn_generic_val == 0) {
            $('#item_block').html(html);
        }
    }

    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    var _diet_no_fk_list = [];
    var diets = [];
    var foods = [];

    // Add Item
    $(document).on('click', '#add_item_btn', function(e) {
        e.preventDefault();

        let _name = $('#name').val();
        let _price = $('#price').val();

        let _diet_no_fk = $('#diet_no_fk').find(":selected").val();
        let _diet_name = $('#diet_no_fk').find(":selected").text();

        let _food_no_fk = $('#food_no_fk').val();
        let _food_name = [];

        $('#food_no_fk :selected').each(function(i, selected){ 
            _food_name[i] = $(selected).text();
        })
        _food_name = _food_name.join(', ');


        diets.push(_diet_no_fk);
        foods.push(_food_no_fk);


        let _note = $('#note').val();

        console.log("=======================");
        console.log(_name);
        console.log(_price);
        // console.log(_diet_no_fk);
        console.log(_diet_name);
        // console.log(_food_no_fk);
        console.log(_food_name);
        console.log(_note);

        console.log("========================");
        console.log(_name == '');
        console.log(_diet_no_fk == '');
        console.log(_food_no_fk == '');

        // if(_name == '' || _diet_no_fk == '' || _food_no_fk == '') {
        //     alert('Please select all required data.');
        //     return false;
        // }

        // Check duplicate item
        if(_diet_no_fk_list.indexOf(_diet_no_fk) == -1) {
            _diet_no_fk_list.push(_diet_no_fk);
        } else {
            alert('Duplicate items!!');
            return;
        }

        let row = `<tr>
                    <td class='sl-td'>
                        <input type="text" value="${_diet_no_fk}" name="diet_no_fk[]" />    
                        <input type="text" value="${_food_no_fk}" name="food_no_fk[][]" />    
                    </td>
                    <td class='text-left'>${_diet_name}</td>
                    <td class='text-left'>${_food_name}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger remove-item-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr?`;

        if ($("#demand_items_list tr").length > 0) {
            $('#demand_items_list tr:last').after(row);
        } else {
            $('#demand_items_list').append(row);
        }

        $('#diet_no_fk').val('');
        $('#food_no_fk').val('');

        $('.sl-td').each(function(index, element) {
            $(element).text(index + 1);
        });

        e.stopImmediatePropagation(); 
    });

    $("#submit").on('click', function(e) {
        e.preventDefault();

        let _name = $('#name').val();
        let _price = $('#price').val();
        
        let _note = $('#note').val();

        let route = "{{ route('dietChart.store') }}";

        let data = {
            "name": _name,
            "price": _price,
            "note": _note,
            "diets": diets,
            "foods": foods,
        };
        console.log(data);

        $.ajax({
            url: route,
            method: "POST",
            data: data,
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                // $('#details_block').html(response);

                if(response.title === 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);

                    setTimeout(() => {
                        // window.location.href = "{{ route('dietChart.index') }}";
                    }, 3000);
                } else {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(response.msg);
                }
            },
            error:function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // Remove this method
    $(document).on('click', '#add_item_btnX', function(e) {
        e.preventDefault();

        var item_id = $('#item_id_hidden').val();
        var item_name = $('#hdn_item_name').val();
        var item_id_hidden = $('#item_id_hidden').val();
        var item_uom_name = $('#item_uom').val();
        var item_uom_no = $('#uom_no_fk').val();
        var item_quantity = $('#quantity').val();
        var last_pp = $('#last_pp').val();
        var global_stock = $('#global_stock').val();
        var global_stock_store = $('#global_stock_store').val();
        var stock_store = $('#stock_store').val();
        var cons_qty = $('#cons_qty').val();
        var cons_last_month = $('#cons_last_month').val();
        var stock_quantity = $('#stock_quantity').val();
        var generic_stock = $('#generic_stock').val();
        var item_remarks = $('#item_remarks').val();
        var rol = $('#rol').val();
        if ($('#isUrgent').prop('checked') == true) {
            var isUrgent = 'Y';
        } else {
            var isUrgent = 'N';
        }

        if ($('#isExact').prop('checked') == true) {
            var isExact = 'Y';
        } else {
            var isExact = 'N';
        }
        // var isUrgent = $('#isUrgent').prop('checked') ;
        // var isExact = $('#isExact').prop('checked');
        var expected_date = $('#expected_date').val();

        console.log($('#isUrgent').prop('checked'));
        if (item_id == '' || item_name == '' || item_remarks == '') {
            if (item_remarks == '') {
                alert('Remarks cannot be blank.')
            } else {
                alert('Input cannot be blank.')
            }

            e.stopImmediatePropagation();
            return false
        }

        let item_qty = 0
        let rec_ins = true;
        if ($('.item_id').length > 0) {
            Array.from($('.item_id')).forEach((item, i) => {
                if ($(item).val() == item_id) {

                    item_qty = Number($('input[data-item_id="' + $(item).val() + '"]').val());

                    item_qty += Number($('#quantity').val());

                    $('input[data-item_id="' + $(item).val() + '"]').val(item_qty);

                    $('[data-qty_item_id="' + $(item).val() + '"]').text(item_qty);

                    $('#item_id').val('')
                    $('#item_code').val('')
                    $('#item_name').val('')
                    $('#item_id_hidden').val('')
                    $('#item_uom').val('')
                    $('#item_uom_hidden').val('')
                    $('#item_quantity').val('')
                    $('#item_price').val('')
                    $('#purchase_price').val('')
                    $("#item_conversion").val('')
                    $("#item_sales_uom").val('')
                    $('#item_remarks').val('');
                    $('#quantity').val('');
                    $("#expected_date").val('')
                    $('#isUrgent').prop('checked', false);
                    $('#isExact').prop('checked', false);
                    $('#item_name').focus();

                    rec_ins = false;
                }
            })

            if (rec_ins) {

                rec_ins = true;
            } else {

                e.stopImmediatePropagation();
                return false;
            }

            rec_ins = true;
        }

        if (item_qty == 0) {
            item_qty = Number(item_quantity);
        }


        var same_item = false
        $('input[class=same-item-id]').each(function(index, elem) {
            if ($(elem).val() == item_id) {
                same_item = true
                return false
            }
        })
        if (same_item == true) {
            alert('You have already taken this item.')
            $('#item_id').val('')
            $('#item_code').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val('')
            $('#item_price').val('')
            $('#purchase_price').val('')
            $("#item_conversion").val('')
            $("#item_sales_uom").val('')
            $('#item_remarks').val('');
            $('#quantity').val('');
            $("#expected_date").val('')
            $('#isUrgent').prop('checked', false);
            $('#isExact').prop('checked', false);
            e.stopImmediatePropagation();
            return false
        }

        var row = `<tr>
                <td class='sl-td'></td>
                <td>${item_name}
                    <input type="hidden" value="${item_id}" name="item_id_hidden[]" class="item_id">
                    <input type="hidden" value="${item_uom_name}" name="item_uom[]">
                    <input type="hidden" value="${item_uom_no}" name="uom_no_fk[]">
                    <input type="hidden" value="${item_quantity}" data-item_id="${item_id}" name="item_quantity[]" class="item_quantity">
                    <input type="hidden" value="${last_pp}" name="last_pp[]">
                    <input type="hidden" value="${item_remarks}" name="remarks[]">
                    <input type="hidden" value="${isUrgent}" name="urgent_ind[]">
                    <input type="hidden" value="${isExact}" name="exact_ind[]">
                    <input type="hidden" value="${global_stock}" name="global_stock[]">
                    <input type="hidden" value="${global_stock_store}" name="global_stock_store[]">
                    <input type="hidden" value="${expected_date}" name="expected_date[]">

                </td>
                <td>${item_uom_name}</td>
                <td class="text-right"" data-qty_item_id="${item_id}">${item_qty}</td>
                <td>0</td>
                <td>${last_pp}</td>
                <td>${item_remarks}</td>
                <td class="text-left">
                    Urgent: ${isUrgent}
                    Exact: ${isExact}
                </td>
                <td>
                    ${expected_date}
                </td>
                <td class="text-left">
                   Global:  ${global_stock}<br>
                   To Store:${global_stock_store}
                </td>
                <td class="text-center">${stock_store}</td>
                <td class="text-left">
                    7 Days: ${cons_qty} <br>
                    30 Days: ${cons_last_month}
                </td>
                <td class="text-center">${generic_stock}</td>
                <td class="text-center">${stock_quantity}</td>
                <td class="text-center">${rol}</td>
                
                <td class="text-center">
                    <button class="btn btn-sm btn-danger remove-item-btn" ><i
                            class="fas fa-trash-alt"></i></button>
                </td></tr>`;
        // $('#demand_items').append(row)
        if ($("#demand_items_list tr").length > 0) {
            $('#demand_items_list tr:last').after(row);
        } else {
            $('#demand_items_list').append(row);
        }
        // $('#demand_items tr:last').after(row);
        $('#item_id').val('')
        $('#item_name').val('')
        $('#item_code').val('')
        $('#item_id_hidden').val('')
        $('#item_uom').val('')
        $('#item_conversion').val('')
        $('#item_uom_hidden').val('')
        $('#item_quantity').val('')
        $('#item_price').val('')
        $('#purchase_price').val('')
        $("#item_conversion").val('')
        $("#item_sales_uom").val('')
        $("#item_remarks").val('')
        $("#quantity").val('')
        $("#expected_date").val('')
        $('#isUrgent').prop('checked', false);
        $('#isExact').prop('checked', false);
        $('#item_name').focus();

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        e.stopImmediatePropagation();
    });

    $('#item_name').on('focus', function() {
        $('.tt-menu').css({
            'display': 'none'
        });
        $('.tt-menu').removeClass('tt-open');
        $('.tt-menu tt-dataset tt-dataset-0').html('');
        $('.twitter-typeahead > pre').text('');

        $('#item_name').val('');
    })
    var remove_item = [];
    $(document).on('click', '.remove-item-btn', function() {
        var remove_id = $(this).attr('data-remove_item');
        remove_item.push(remove_id);
        $(this).closest('tr').remove();
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        $('#remove_item_id').val(remove_item);
        console.log(remove_item);
        // poItemCalculateTotal1(this);
    })


    function setHiddenValue(element) {

        $('#item_id_hidden').val($('option:selected', element).val());
        $('#hdn_item_name').val($('option:selected', element).attr('data-item_name'));
        $('#uom_no_fk').val($('option:selected', element).attr('data-uom_no_fk'));
        $('#item_uom').val($('option:selected', element).attr('data-item_uom'));
        $("#last_pp").val($('option:selected', element).attr('data-last_pp'));
        $("#global_stock").val($('option:selected', element).attr('data-global_stock'));
        $("#global_stock_store").val($('option:selected', element).attr('data-global_stock_store'));
        $("#stock_store").val($('option:selected', element).attr('data-stock_store'));
        $("#cons_qty").val($('option:selected', element).attr('data-cons_qty'));
        $("#cons_last_month").val($('option:selected', element).attr('data-cons_last_month'));
        $("#stock_quantity").val($('option:selected', element).attr('data-stock_quantity'));
        $("#rol").val($('option:selected', element).attr('data-rol'));
        $("#generic_stock").val($('option:selected', element).attr('data-generic_stock'));
    }
      
    $(document).on('change','#department_to',function(){
        // $('#hdn_department_to').val($(this).val());
        // $(this).prop('disabled',true);
        $('#generic_id').val('');
        $('#hdn_generic_id').val('');
        $('#item_type').val('').trigger('change');
        $('#item_name').val('');
        $('#isUrgent').prop('checked',false);
        $('#isExact').prop('checked',false);
        $('#item_id_hidden').val('');
        $('#hdn_item_name').val('');
        $('#uom_no_fk').val('');
        $('#item_uom').val('');
        $("#last_pp").val('');
        $("#global_stock").val('');
        $("#global_stock_store").val('');
        $("#stock_store").val('');
        $("#cons_qty").val('');
        $("#cons_last_month").val('');
        $("#stock_quantity").val('');
        $("#sub_stock_quantity").val('');
        $("#rol").val('');
        $("#generic_stock").val('');
        $("#Indent_remarks").val('');
        $("#item_remarks").val('');
        $("#quantity").val('');
        $("#expected_date").val('');
        $("#demand_items_list").html('');
    });
</script>
