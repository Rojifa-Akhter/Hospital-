<main id="page-content">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <section class="matrix">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">PO Terms & Condition</h5>
                            <small>Inventory /My Approval</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="form-row">
                                <div class="col-lg-12 col-md-12 col-12 text-right">
                                    <a href="{{route('v1.po-terms-conditions-worklist')}}" class="btn btn-info btn-md"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group m-0">
                                        <label for="po_store" class="col-form-label">Store<span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" id="po_store" name="po_store">
                                            <option value="">Select Store</option>
                                            @if (!empty($main_store_list))
                                                    @foreach ($main_store_list as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}"
                                                            >
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group m-0">
                                        <label for="po_supplier" class="col-form-label">Supplier<span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm select2" id="po_supplier" name="po_supplier">
                                            <option value="">Select Supplier</option>
                                            @if (!empty($supplier_arr))
                                                @foreach ($supplier_arr as $key => $ic)
                                                    <option value="{{ $key }}"
                                                        >
                                                        {{ $ic }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group m-0">
                                        <label for="terms_header" class="col-form-label">Terms Header <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="form-control" id="header_serial" name="header_serial">
                                                    <option value="">Serial </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="terms_header" name="terms_header" value="" placeholder="Terms Header" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group m-0">
                                        <label for="terms_condition" class="col-form-label">Terms & Condition <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="form-control" id="terms_condition_serial" name="terms_condition_serial">
                                                    <option value="">Serial </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <textarea class="form-control form-control-sm" id="terms_condition" name="terms_condition" value="" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group form-row align-items-center text-right">
                                        <label for="item_" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="default_terms_ind" name="default_terms_ind" value="1" />
                                                <label class="form-check-label" for="default_terms_ind">Terms Default</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="isDefault" value="1" />
                                                <label class="form-check-label" for="isDefault">Store Default</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="isStatus" value="1" />
                                                <label class="form-check-label" for="isStatus">Status</label>
                                            </div>
                                            <button type="button" class="btn btn-success uhl_common_btn btn-md" id="add_item_btn">Add item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>SL</th>
                                            <th>Store</th>
                                            <th>Supplier</th>
                                            <th>Header SL</th>
                                            <th>Header</th>
                                            <th>Terms SL</th>
                                            <th>Terms & Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody class="terms_and_condition">


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
                        <div class="card-body text-right">
                                   <button type="button" class="btn btn-secondary uhl_save_btn">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.select2').select2();

    let terms_arr = [];
    let save_terms_arr = [];

    let sl = 1;

    $('body').on('click', '#add_item_btn', function(){

        terms_arr.push({
            'store_no_fk': $('#po_store').val(),
            'store': $('#po_store option:selected').text(),
            'supplier_no_fk': $('#po_supplier').val(),
            'supplier': $('#po_supplier option:selected').text(),
            'header_serial':$('#header_serial').val(),
            'terms_header': $('#terms_header').val(),
            'terms_condition_serial':$('#terms_condition_serial').val(),
            'terms_condition':$('#terms_condition').val(),
            'default': $('#isDefault').prop('checked') == true ? $('#isDefault').val() : 0,
            'terms_default_ind_1': $('#default_terms_ind').prop('checked') == true ? $('#default_terms_ind').val() : 0,
            'status': $('#isStatus').prop('checked') == true ? $('#isStatus').val() : 0
        });

        terms_arr.map((terms) => {
            save_terms_arr.push({
                'store_su_no_fk': terms.store_no_fk,
                'supplier_no_fk': terms.supplier_no_fk,
                'header_sl':terms.header_serial,
                'termscon_header': terms.terms_header,
                'terms_sl':terms.terms_condition_serial,
                'termscon_text1':terms.terms_condition,
                'store_default_ind': terms.default,
                'default_terms_ind': terms.terms_default_ind_1,
                'status': terms.status
            })
            $('.terms_and_condition').append(`
                <tr>
                    <td>${sl++}</td>
                    <td>
                        ${terms.store}
                        <input type="hidden" name="store_su_no_fk[]" value="${terms.store_no_fk}"/>
                    </td>
                    <td>
                        ${terms.supplier}
                        <input type="hidden" name="supplier_no_fk[]" value="${terms.supplier_no_fk}"/>
                    </td>
                    <td>
                        ${terms.header_serial}
                        <input type="hidden" name="header_sl[]" value="${terms.header_serial}"/>
                    </td>
                    <td>
                        ${terms.terms_header}
                        <input type="hidden" name="termscon_header[]" value="${terms.terms_header}"/>
                    </td>
                    <td>
                        ${terms.terms_condition_serial}
                        <input type="hidden" name="terms_sl[]" value="${terms.terms_condition_serial}"/>
                    </td>
                    <td>
                        ${terms.terms_condition}
                        <input type="hidden" name="termscon_text1[]" value="${terms.terms_condition}"/>
                    </td>
                </tr>
            `)
        })

        setTimeout(() => {
            terms_arr = [];
            // $('#po_store').val('');
            // $('#po_store').val('');
            // $('#po_supplier').val('');
            // $('#po_supplier').val('').trigger('change');
            // $('#header_serial').val('');
            // $('#terms_header').val($('#terms_header').val());
            $('#terms_condition_serial').val('');
            $('#terms_condition').val('');

            $('#po_store').focus();


        }, 1000);
    })

    $('body').on('click','.uhl_save_btn', function(){
        console.log('save');
        $.ajax({
            url: "{{route('v1.po-terms-condition-save')}}",
            method: "post",
            data: {
                po_terms: JSON.stringify(save_terms_arr)
            },
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
                //$('.data-table').DataTable().clear().destroy();
            },
            success: function(data) {
                console.log('Success message ', data.title);
                if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }

                    dynamicFunc.afterSaveLoadPage("{{route('v1.po-terms-conditions-worklist')}}")

                $('.terms_and_condition').empty();
            },
            complete: function() {
                $.unblockUI();
            },
            error: function(data) {
                $.unblockUI();
            }
        })
    })

</script>
