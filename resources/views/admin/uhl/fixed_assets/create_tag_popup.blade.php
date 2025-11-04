 <!-- Modal -->

 <form action="{{ route('v1.save-generate-tag') }}" method="post" id="tagSave">
     @csrf
     <div class="form-row">
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="asset_id" class="col-sm-4 col-form-label">Asset Id</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="asset_id" name="asset_id"
                         value="{{ !empty($asset_receive_data) ? $asset_receive_data->item_no_fk : '' }}" readonly />
                     <input type="hidden" value="{{ $asset_receive_data->itemreceivedtl_no_pk }}" name="grnDtlNo">
                     <input type="hidden" value="{{ $asset_receive_data->store_su_no_fk }}" name="store_id">
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="asset_descrip" class="col-sm-4 col-form-label">Asset Description</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="asset_descrip" name="asset_descrip"
                         value="{{ !empty($asset_receive_data) ? $asset_receive_data->item_name : '' }}" readonly />
                 </div>
             </div>
         </div>
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="asset_location" class="col-sm-4 col-form-label">Location</label>
                 <div class="col-sm-8">
                     <select class="form-control form-control-sm select2" id="asset_location" name="asset_location">
                         <option value="">select Location</option>
                         @if (!empty($location))
                             @foreach ($location as $value)
                                 <option value="{{ $value->room_no_pk }}">{{ $value->room_name }}</option>
                             @endforeach
                         @endif
                     </select>
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <input type="hidden" class="form-control form-control-sm" id="last_store_su_no_fk"
                     name="last_store_su_no_fk" value="" />

                 <input type="hidden" class="form-control form-control-sm" id="last_room_no_fk" name="last_room_no_fk"
                     value="" />

                 <label for="item_model_number" class="col-sm-4 col-form-label">Model No.</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="item_model_number"
                         name="item_model_number" value="" placeholder="Item Model Number" />
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="country_of_origin" class="col-sm-4 col-form-label">Country</label>
                 <div class="col-sm-8">
                     <select class="form-control form-control-sm select2" id="country_of_origin"
                         name="country_of_origin">
                         <option value="">Select Country</option>
                         <option value="Bangladesh">Bangladesh</option>
                         <option value="India">India</option>
                         <option value="Pakistan">Pakistan</option>
                         <option value="Nepal">Nepal</option>
                         <option value="Srilanka">Srilanka</option>
                         <option value="Japan">Japan</option>
                         <option value="England">England</option>
                         <option value="USA">USA</option>
                     </select>
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="item_serial_number" class="col-sm-4 col-form-label">Item Serial No.</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="item_serial_number"
                         name="item_serial_number" value="" placeholder="Item Serial Number" />
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="depreciation_residual_val_pct" class="col-sm-4 col-form-label">Depreciation Residual Value
                     %</label>
                 <div class="col-sm-8">
                     <input type="number" class="form-control form-control-sm" id="depreciation_residual_val_pct"
                         name="depreciation_residual_val_pct" value=""
                         placeholder="Depreciation Residual Value Percentage" />
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="depreciation_residual_val_amt" class="col-sm-4 col-form-label">Depreciation Residual
                     Value
                     Ammount</label>
                 <div class="col-sm-8">
                     <input type="number" class="form-control form-control-sm" id="depreciation_residual_val_amt"
                         name="depreciation_residual_val_amt" value=""
                         placeholder="Depreciation Residual Value Ammount" />
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="usage_status" class="col-sm-4 col-form-label">Usage Status</label>
                 <div class="col-sm-8">
                     <select class="form-control form-control-sm select2" id="usage_status" name="usage_status">
                         <option value="Using">Using</option>
                     </select>
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="current_qty" class="col-sm-4 col-form-label">Current Qty</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="current_qty" name="current_qty"
                         value="{{ !empty($asset_receive_data) ? $asset_receive_data->grn_qty - $asset_receive_data->tag_qty : '' }}"
                         onkeyup="setQty(this)" />
                     <input type="hidden" value="{{ $asset_receive_data->grn_qty - $asset_receive_data->tag_qty }}"
                         id="hdn_current_qty">
                 </div>
             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="existing_qty" class="col-sm-4 col-form-label">Existing Qty</label>
                 <div class="col-sm-8">
                     <input type="text" class="form-control form-control-sm" id="existing_qty"
                         name="existing_qty" value="{{ $asset_receive_data->tag_qty }}" readonly />
                 </div>
             </div>
         </div>

         <div class="col-12 text-center my-2">
             <button type="button" class="btn btn-md btn-success uhl_common_btn" id="generate_tag">Generate
                 Tag</button>
         </div>


     </div>

     <div class="form-row">
         <div class="col-md-6">
             <div class="table-responsive">
                 <table class="table table-bordered table-hover table-striped">
                     <h5 class="table__heading">Existing</h5>
                     <thead class="global-uhl-table-bg">
                         <tr>
                             <th>Sl No</th>
                             <th>Tag Number</th>
                             <th></th>

                         </tr>
                     </thead>
                     <tbody>
                         @if (!empty($existing_data))
                             @foreach ($existing_data as $value)
                                 <tr>
                                     <td>{{ $loop->iteration }}</td>
                                     <td>{{ $value->asset_tag_uid }}</td>
                                     <td><a href="{{ route('v1.print-generate-tag', $value->ast_register_no_pk) }}"
                                             class="" target="_blank" title="Print"><i
                                                 class="fas fa-print"></i></a></td>
                                 </tr>
                             @endforeach
                         @endif

                     </tbody>
                 </table>
             </div>
         </div>
         <div class="col-md-6">
             <div class="table-responsive">
                 <table class="table table-bordered table-hover table-striped">
                     <h5 class="table__heading">Current</h5>
                     <thead class="global-uhl-table-bg">
                         <tr>
                             <th>Sl No</th>
                             <th>Tag Number</th>
                             <th></th>

                         </tr>
                     </thead>
                     <tbody id="current_tag">

                     </tbody>
                 </table>
             </div>
         </div>
     </div>
     @php
         $redirect_url = route('v1.asset-received');
         
     @endphp
     <button type="submit" class="btn btn-primary uhl_save_btn"
         onclick="btnSaveUpdate(this,'','','','', assetsSearchFunc,'{{ $redirect_url }}')">Save </button>
     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
 </form>

 <script>
     $("body").addClass("sidebar-collapse");
     $('.select2').select2();
     $('.date_picker').datepicker({
         todayHighlight: true,
         clearBtn: true,
         autoclose: true,
         format: 'dd-mm-yyyy'
     });

     function setQty(element) {
         var hdn_current_qty = parseFloat($('#hdn_current_qty').val());
         var qty = parseFloat($(element).val());
         console.log(qty, hdn_current_qty);
         if (qty > hdn_current_qty) {
             alert('Invalid Qty');
             $(element).val('');
             return;
         }
     }
 </script>
