<main id="page-content">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

    <section class="matrix">
        <form action="{{ route('v1.po-terms-condition-update') }}" id="create-approval-matrix" method="post">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12">
                            <h5 class="mt-2 mb-0">Edit PO Terms & Conditions</h5>
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
                                                            @if ($store->serviceunit_no_pk == $terms_conditions->store_su_no_fk) selected @endif>
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
                                                    <option value="{{ $key }}" @if ($key == $terms_conditions->supplier_no_fk) selected @endif
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
                                                    <option value="1" @if ($terms_conditions->header_sl == 1) selected @endif>1</option>
                                                    <option value="2" @if ($terms_conditions->header_sl == 2) selected @endif>2</option>
                                                    <option value="3" @if ($terms_conditions->header_sl == 3) selected @endif>3</option>
                                                    <option value="4" @if ($terms_conditions->header_sl == 4) selected @endif>4</option>
                                                    <option value="5" @if ($terms_conditions->header_sl == 5) selected @endif>5</option>
                                                    <option value="6" @if ($terms_conditions->header_sl == 6) selected @endif>6</option>
                                                    <option value="7" @if ($terms_conditions->header_sl == 7) selected @endif>7</option>
                                                    <option value="8" @if ($terms_conditions->header_sl == 8) selected @endif>8</option>
                                                    <option value="9" @if ($terms_conditions->header_sl == 9) selected @endif>9</option>
                                                    <option value="10" @if ($terms_conditions->header_sl == 10) selected @endif>10</option>
                                                    <option value="11" @if ($terms_conditions->header_sl == 11) selected @endif>11</option>
                                                    <option value="12" @if ($terms_conditions->header_sl == 12) selected @endif>12</option>
                                                    <option value="13" @if ($terms_conditions->header_sl == 13) selected @endif>13</option>
                                                    <option value="14" @if ($terms_conditions->header_sl == 14) selected @endif>14</option>
                                                    <option value="15" @if ($terms_conditions->header_sl == 15) selected @endif>15</option>
                                                    <option value="16" @if ($terms_conditions->header_sl == 16) selected @endif>16</option>
                                                    <option value="17" @if ($terms_conditions->header_sl == 17) selected @endif>17</option>
                                                    <option value="18" @if ($terms_conditions->header_sl == 18) selected @endif>18</option>
                                                    <option value="19" @if ($terms_conditions->header_sl == 19) selected @endif>19</option>
                                                    <option value="20" @if ($terms_conditions->header_sl == 20) selected @endif>20</option>
                                                </select>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="terms_header" name="terms_header" value="{{ $terms_conditions->termscon_header ?: ""}}" placeholder="Terms Header" />
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
                                                    <option value="1" @if ($terms_conditions->terms_sl == 1) selected @endif>1</option>
                                                    <option value="2" @if ($terms_conditions->terms_sl == 2) selected @endif>2</option>
                                                    <option value="3" @if ($terms_conditions->terms_sl == 3) selected @endif>3</option>
                                                    <option value="4" @if ($terms_conditions->terms_sl == 4) selected @endif>4</option>
                                                    <option value="5" @if ($terms_conditions->terms_sl == 5) selected @endif>5</option>
                                                    <option value="6" @if ($terms_conditions->terms_sl == 6) selected @endif>6</option>
                                                    <option value="7" @if ($terms_conditions->terms_sl == 7) selected @endif>7</option>
                                                    <option value="8" @if ($terms_conditions->terms_sl == 8) selected @endif>8</option>
                                                    <option value="9" @if ($terms_conditions->terms_sl == 9) selected @endif>9</option>
                                                    <option value="10" @if ($terms_conditions->terms_sl == 10) selected @endif>10</option>
                                                    <option value="11" @if ($terms_conditions->terms_sl == 11) selected @endif>11</option>
                                                    <option value="12" @if ($terms_conditions->terms_sl == 12) selected @endif>12</option>
                                                    <option value="13" @if ($terms_conditions->terms_sl == 13) selected @endif>13</option>
                                                    <option value="14" @if ($terms_conditions->terms_sl == 14) selected @endif>14</option>
                                                    <option value="15" @if ($terms_conditions->terms_sl == 15) selected @endif>15</option>
                                                    <option value="16" @if ($terms_conditions->terms_sl == 16) selected @endif>16</option>
                                                    <option value="17" @if ($terms_conditions->terms_sl == 17) selected @endif>17</option>
                                                    <option value="18" @if ($terms_conditions->terms_sl == 18) selected @endif>18</option>
                                                    <option value="19" @if ($terms_conditions->terms_sl == 19) selected @endif>19</option>
                                                    <option value="20" @if ($terms_conditions->terms_sl == 20) selected @endif>20</option>
                                                </select>
                                            </div>
                                            <textarea class="form-control form-control-sm" id="terms_condition" name="terms_condition" rows="2">{{ $terms_conditions->termscon_text1 ?: ""}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group form-row align-items-center text-right">
                                        <label for="item_" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="default_terms_ind" name="default_terms_ind" value="1"  {{ $terms_conditions->default_terms_ind == 1 ? "checked" : "" }} />
                                                <label class="form-check-label" for="default_terms_ind">Terms Default</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="isDefault" name="isDefault" value="1"  {{ $terms_conditions->store_default_ind == 1 ? "checked" : "" }} />
                                                <label class="form-check-label" for="isDefault">Is Default</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="isStatus" name="isStatus" value="1" {{ $terms_conditions->status == 1 ? "checked" : "" }}/>
                                                <label class="form-check-label" for="isStatus">Status</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="po_id" value="{{ $terms_conditions->termscon_no_pk ?:''}}">
                                @php
                                $response_action = route('v1.po-terms-conditions-worklist');
                            @endphp
                            <div class="col-lg-12 col-md-12 col-12 text-right mt-4">
                                <button type="button" class="btn btn-secondary uhl_save_btn"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Update</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
