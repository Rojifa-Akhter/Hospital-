<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .upload-signature {
        cursor: pointer;
        color: #595757;
        border: 1px dashed #97dad4;
    }
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .year-close{
        font-size: 13px
    }
    .journal_posting_table>thead>tr>th{
        font-size: 12px !important;
        white-space: nowrap;
    }
    .disabled-style{
        border:1px dotted black;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden;
        width: 220px;
    }
    .w-200{
        width:200px;
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <form action="#" id="journalPostingV1" class="journalPostingV1" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-8 col-12">    
                                <h5 class="mt-2 mb-0"> Voucher Entry</h5>
                                <small>Accounts / Voucher Entry</small>                 
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="row align-items-center my-0">
                                    <div class="col-6"><b class="year-close">Last Closing Year <span class="float-right">:</span></b></div>
                                    <div class="col-6">
                                        <span class="year-close text-right">
                                        @php 
                                            $last_fiscal_year = collect($fiscal_year->getData()->data)->sortByDesc('fisacal_year')->where('status',1)->where('current_fiscal_year_ind','!=',1)->take(1)->values();
                                            // @dd($last_fiscal_year);
                                                if(isset($last_fiscal_year[0]->end_date)){
                                                    $last_fiscal_year = date("d M, Y", strtotime($last_fiscal_year[0]->end_date));
                                                }
                                                else{
                                                    $last_fiscal_year = "";
                                                }
                                            @endphp
                                            {{$last_fiscal_year != '' ? $last_fiscal_year  : 'Not Defined'}}
                                        </span>
                                    </div>
                                </div>
                           
                                <div class="row align-items-center my-0">
                                    <div class="col-6"><b class="year-close">Last Closing Month <span class="float-right">:</span></b></div>
                                    <div class="col-6"><span class="text-right year-close">
                                        @php                             
                                            $curr_fiscal_month = collect($fiscal_month->getData()->data)->sortByDesc('end_date')->where('status',1)->take(1)->values();
                                        
                                            if(isset($curr_fiscal_month[0]->end_date)){
                                                $curr_fiscal_month = date("d M, Y", strtotime($curr_fiscal_month[0]->end_date));
                                            }
                                            else{
                                                $curr_fiscal_month = "";
                                            }
                                        @endphp

                                        {{$curr_fiscal_month != '' ? $curr_fiscal_month  : 'Not Defined'}}  
                                    
                                    </span></div>
                                </div>    

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="doc_date" class="col-sm-4 col-form-label">Doc. Date<span class=text-danger>*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm doc_date" id="doc_date" name="doc_date" placeholder="Enter Doc. Date" value="" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="cost-center-code" class="col-sm-4 col-form-label">Posting 
                                                Date<span class=text-danger>*</span></label>
                                                <?php $hospital_code_pd = DB::table('WSEC_HOSPITAL')->first()->hospital_code;?>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm post_date <?= $hospital_code_pd !== 'KPJ' ? 'disabled-style' : '' ?>" id="post_date" name="post_date" placeholder="Enter Post. Date" value="" autocomplete="off" <?= $hospital_code_pd !== 'KPJ' ? 'disabled' : '' ?>/>
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="attachment1" class="col-sm-4 col-form-label">Attachment-1</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="attachment1" name="attachment1" placeholder="Enter file name" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    <input type="file" id="file1" name="file1" class="upload-signature form-control py-2" />
                                                </div>
                                            </div>
                                        </div>	
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="total_dr" class="col-sm-4 col-form-label">Total Dr.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="total_dr" name="total_dr" placeholder="" value="0" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="journal_type" class="col-sm-4 col-form-label">
                                                Voucher Type
                                            <span class=text-danger>*</span></label>
                                            <div class="col-sm-8">

                                            
                                                @php 
                                                    $voucher_types = $voucher_type->getData()->data;
                                                    $today = date("Y-m-d H:i:s");
                                                    $soft_closing = false;
                                                    $hard_closing = false;
                                                    $fiscal_month_closing = collect($fiscal_month->getData()->data)->where('closing_type','!=',0)->where('status',1);

                                                    foreach ($fiscal_month_closing as $key2 => $item2) {                                                           

                                                    if($today >= $item2->start_date && $today <= $item2->end_date){            
                                                         if($item2->closing_type == 1){
                                                            $soft_closing = true;
                                                            $voucher_types = collect($voucher_types)->whereNotIn('voucher_type_name',['CASH PAYMENT','BANK PAYMENT']);
                                                         } 
                                                         elseif($item2->closing_type == 2){
                                                            $hard_closing = true;
                                                            $voucher_types = [];
                                                         }
                                                    }
                                                    }
                                                @endphp




                                                <select class="form-control form-control-sm" id="journal_type" name="journal_type" onchange="changeJournalType()">
                                                    <option value="" disabled selected>Select One</option>
                                                    @foreach ($voucher_types as $item)
                                                       
                                                        @if($item->status == 1)
                                                            <option value="{{$item->voucher_type_no_pk}}" data-type="{{$item->voucher_type_name}}">{{$item->voucher_type_code}} - {{$item->voucher_type_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="attachment2" class="col-sm-4 col-form-label">Attachment-2</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="attachment2" name="attachment2" placeholder="Enter file name" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    <input type="file" id="file2" name="file2" class="upload-signature form-control py-2" />
                                                </div>
                                            </div>
                                        </div>	
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="total_cr" class="col-sm-4 col-form-label">Total Cr.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="total_cr" name="total_cr" placeholder="" value="0" readonly/>
                                                <span id="dr_cr_warning" style="color:red;font-size:12px"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="voucher_no" class="col-sm-4 col-form-label">                                               
                                                Voucher No.                                                                                                                                    
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="voucher_no" name="voucher_no" placeholder="voucher no" value="" readonly/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="attachment3" class="col-sm-4 col-form-label">Attachment-3</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="attachment3" name="attachment3" placeholder="Enter file name" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                            <div class="col-sm-8">
                                                <div>
                                                    <input type="file" id="file3" name="file3" class="upload-signature form-control py-2" />
                                                </div>
                                            </div>
                                        </div>	
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="currency" class="col-sm-4 col-form-label">Currency</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="currency" name="currency" onchange="changeCurrency(this.value)">
                                                    @foreach ($currency as $key => $item)                                                   
                                                        @if($item['status'] == 1)
                                                            <option value="{{$item['curr_pk']}}" data-rate="{{$item['curr_rate']}}" {{$item['curr_pk'] == 1 ? 'selected' : ''}}>{{$item['curr_name']}}</option>
                                                        @endif
                                                    @endforeach                     
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="curr_rate" class="col-sm-4 col-form-label">Currency Rate</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control form-control-sm" id="curr_rate" name="curr_rate" placeholder="" value="1" oninput="calculateLocalPrice()"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-2 col-form-label">Notes</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="notes" rows="2" name="notes"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover journal_posting_table">
                                        <thead class="global-uhl-table-bg">
                                            <tr id="tblhead0" >
                                                <th class="text-center" style="width: 15%">General Ledger (GL)<span class="text-danger">*</span></th>
                                                <th class="text-center" style="width: 10%">Sub Ledger Type</th>
                                                <th class="text-center" style="width: 7%">Sub Ledger</th>
                                                <th class="text-center" style="width: 7%">Dr/Cr<span class="text-danger">*</span> </th> 
                                                {{-- <th class="text-center" style="width: 3%">Currency</th>
                                                <th class="text-center" style="width: 5%">Curr. Rate</th> --}}
                                                <th class="text-center" style="width: 9%">Amt. in Doc. Curr<span class="text-danger">*</span></th>
                                                <th class="text-center" style="width: 9%">Amt. in Loc. Curr</th>
                                                <th class="text-center" style="width: 5%">Cost Center</th>
                                                <th class="text-center" style="width: 17%">Narration</th>
                                                <th class="text-center" style="width: 8%">Cheq. Date</th>
                                                <th class="text-center" style="width: 8%">Cheq. No</th>
                                                <th class="text-center" style="width: 5%"></th>                                
                                            </tr>

                                        </thead>
                                        <tbody>
                                        <tr id="tbl0">
                                            <td>
                                                <select class="custom-select form-control form-control-sm required select2" id="general_ledger0" name="general_ledger[]" onchange="checkCostCenter(this.value,0)">
                                                    <option value="" disabled selected>Select One</option>
                                                    @foreach ($general_ledger->getData()->data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->account_no_pk}}" data-cost="{{$item->cost_center_ind}}" class="{{$item->cost_center_ind}}" data-sub="{{$item->sub_ledger_ind}}" data-dr_cr="{{$item->default_dr_cr}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm" id="sub_ledger_type0" name="sub_ledger_type[]" onchange="fetchSubLedger(this.value,0)">
                                                    <option value="0"  selected>Select One</option>
                                                    @foreach ($sub_ledger_type->getData()->data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->acct_subledger_typeno_pk}}" data-code="{{$item->subledgertype_code}}">{{$item->subledgertype_code}} - {{$item->subledgertype_name}}</option>
                                                        @endif
                                                    @endforeach

                                    
                                                </select>

                                            </td>
                                            <td>
                                                <div id="sub_ledger_name_select0"> 
                                                    <select class="form-control form-control-sm select2" id="sub_ledger_name0" name="sub_ledger_name[]" onchange="checkEligibility(0,'ledger')">
                                                        <option value="0" selected>Select One</option>
                                                    </select>
                                                </div>
                                                    <input type="hidden" class="form-control form-control-sm w-200" name="sub_ledger_name_input[]" id="sub_ledger_name_input0" value="" placeholder="admission, name, code" list="patients0" oninput="suggestPatient(0)" autocomplete="off">
                                                    <input type="hidden" class="form-control form-control-sm" name="opd_ipd_ind[]" id="opd_ipd_ind0" value="">
                                                <datalist id="patients0">
                    
                                                </datalist>

                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm" id="dr_cr_type0" name="dr_cr_type[]" onchange="PriceUpdate()">
                                                    <option value="" selected disabled>select One</option>
                                                    <option value="dr">Dr.</option>
                                                    <option value="cr">Cr.</option>
                                                </select>

                                            </td>

                                            {{-- <td>
                                                <select class="form-control form-control-sm" id="currency0" name="currency[]" onchange="changeCurrency(this.value,0)">
                                                    @foreach ($currency as $key => $item)                                                   
                                                        @if($item['status'] == 1)
                                                            <option value="{{$item['curr_pk']}}" data-rate="{{$item['curr_rate']}}" {{$item['curr_pk'] == 1 ? 'selected' : ''}}>{{$item['curr_name']}}</option>
                                                        @endif
                                                    @endforeach                     
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" class="form-control form-control-sm" id="curr_rate0" name="curr_rate[]" placeholder="" value="1" oninput="calculateLocalPrice(0)" readonly/>
                                            </td> --}}
                                            <td>
                                                <input type="number" step="0.01" class="form-control form-control-sm" id="amt_curr0" name="amt_curr[]" placeholder="" value="0" oninput="calculateLocalPrice()"/>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="amt_local_curr0" name="amt_local_curr[]" placeholder="" value="0" oninput="PriceUpdate()" readonly/>

                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm select2" id="cost_center0" name="cost_center[]" onchange="checkEligibility(0,'cost')">
                                                    <option value="0" selected>Select One</option>
                                                    @foreach ($cost_center->getData()->data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->costcenter_no_pk}}">{{$item->costcenter_code}} - {{$item->costcenter_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="naration0" name="naration[]" placeholder="" value="" onclick="openModal('naration0')"/>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm date_picker" id="cheque_date0" name="cheque_date[]" placeholder="" value="" autocomplete="off"/>

                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="cheque_no0" name="cheque_no[]" placeholder="" value="" />

                                            </td>
                                            <td>
                                                <span class="btn btn-primary first_add_button" id="add_journal_posting"><i class="fas fa-plus-circle"></i></span>
                                            </td>
                                        </tr>

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
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button"  class="btn btn-secondary uhl_save_btn" id="journalSaveButton" onclick="savejournalPostingV1()">Save</button>
                                        </li>
                                        <li class="list-inline-item"><button type="reset" class="btn btn-secondary">Reset</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

  <!-- Button trigger modal -->
  <input type="hidden" id="narrationEditModal" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
   
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Narration</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-12">
                    <textarea class="form-control" id="narrationModal" rows="4" name="narrationModal" placeholder="Narration write here .." onkeyup="openModal('')"></textarea>
                </div>
           </div>
        </div>
      </div>
    </div>
  </div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<?php $fiscal_year = collect($fiscal_year->getData()->data)->where('current_fiscal_year_ind',1)->where('status',1)?>
<?php $fiscal_months_list = $fiscal_month->getData()->data;?>
<?php $fiscal_month = collect($fiscal_month->getData()->data)->sortByDesc('end_date')->where('status',1)->take(1)->values()?>
<?php $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;?>
<?php $vouchers = $voucher_type->getData()->data;?>

<?php 


    // foreach ($fiscal_year  as $key => $item) {
    //     foreach ($fiscal_month as $key2 => $item2) {                        
    //        if($item2->start_date >= $item->start_date && $item2->end_date <= $item->end_date){            
    //             $newDateTimestamp = strtotime($item2->end_date . " +1 day");
    //             $newDate = date("Y-m-d H:i:s", $newDateTimestamp);
    //         $fiscal_year[$key]->start_date = $newDate;
    //        }
    //     }
    // }

    
?>

<?php
$cost_option = '';
$cost_option .= '<option value="0" selected>Select one</option>';
foreach ($cost_center->getData()->data as $key => $item) {
    if ($item->status == 1) {
        $display_name = htmlspecialchars($item->costcenter_name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $display_code = htmlspecialchars($item->costcenter_code, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $option_value = htmlspecialchars($item->costcenter_no_pk, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $cost_option .= '<option value="' . $option_value . '">' . $display_code . '-' . $display_name . '</option>';
    }
}
?>

<script>
    $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).on('keydown', function(event) {
        if (event.keyCode === 115 ) {
            $("#journalSaveButton").click();
        }
    });

    $(function(){
        var currentDate = new Date();
        $('.post_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);

        //Posting Date Field Disabled//
        var fiscal_year = '<?php echo json_encode($fiscal_year); ?>';
        var fiscal_month = '<?php echo json_encode($fiscal_month); ?>';
        var disabledDateRanges = [];
        var newRange = {};
        var fiscal_year_array = JSON.parse(fiscal_year);
        var fiscal_month_array = JSON.parse(fiscal_month);
        var mergedArray = [...fiscal_year_array];
        mergedArray.forEach(function(year) {
            if(year.status == 1){
                var fromDate = new Date(year.start_date);
                var toDate = new Date(year.end_date);
                newRange = {from: fromDate, to: toDate};
                disabledDateRanges.push(newRange);
            }          
        });

        function disableSpecificDates(date) {
            for (var i = 0; i < disabledDateRanges.length; i++) {
            var fromDate = new Date(disabledDateRanges[i].from);
            var toDate = new Date(disabledDateRanges[i].to);
                if (date >= fromDate && date <= toDate) {
                    return [true];
                }
            }
            return [false];
        }

        //Close Posting Date Field Disabled//

        $('.doc_date').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,

        });
        // $('#doc_date').datepicker('setDate', currentDate);

        if(mergedArray.length > 0){
            var start_date = mergedArray[0].start_date;
                start_date  = start_date.split(' ')[0];
                start_date = start_date.split('-');
                start_date = start_date[2] + '/' + start_date[1] + '/' + start_date[0];
            $('#doc_date').datepicker('setStartDate', start_date);
            $('#doc_date').datepicker('setEndDate', currentDate);  
        }
        else{
            $('#doc_date').prop('readonly',true);
            $('#doc_date').datepicker('setStartDate', currentDate.getDate() - 30);  
            $('#doc_date').datepicker('setEndDate', currentDate.getDate() - 30);  
        }
        

        $('#cheque_date0').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
        });

        // doc date eligibility check
        $(".doc_date").on("change", function() {
          
            var inputDate = $(this).val();
                if(inputDate != ""){
                    inputDate =  moment(inputDate, "DD/MM/YYYY").format("MM/DD/YYYY");
                }
             
            var date_ind = true;
            mergedArray.forEach(function(year) {
                if (year.status == 1) {
                    var startDate = new Date(year.start_date);
                    var endDate = new Date(year.end_date);
                    var inputDateObject = new Date(inputDate);
                    if (inputDateObject >= startDate && inputDateObject <= endDate) {
                        date_ind = false;
                    }
                }
            });
            if(date_ind && inputDate != ""){
                
                alert("Not available this date");
                $(this).val("");
                $('.post_date').val("");
                return false;
            }
    
            $('#post_date').val($('#doc_date').val());

            /* voucher type eligible test*/
                var voucher_types = '<?php echo json_encode($vouchers); ?>';
                voucher_types = JSON.parse(voucher_types);

                var fiscal_month_data = '<?php echo json_encode($fiscal_months_list); ?>';
                fiscal_month_data = JSON.parse(fiscal_month_data);

                var today = $('#doc_date').val();
                    today =  moment(today, "DD/MM/YYYY").format("MM/DD/YYYY");
               
                // var parsedDate = $.datepicker.parseDate("dd/mm/yyyy", today);
                // console.log('today',parsedDate);
                
                // today = $.datepicker.formatDate("yyyy-mm-dd", parsedDate);

                var parsedDate = today.split('/');
                    parsedDate = new Date(parsedDate[2], parsedDate[0] - 1, parsedDate[1]);

                // Format the parsed date to yyyy-mm-dd format
                today = parsedDate.getFullYear() + '-' + ('0' + (parsedDate.getMonth() + 1)).slice(-2) + '-' + ('0' + parsedDate.getDate()).slice(-2);

                today = new Date(today);
                today.setHours(0);
                today.setMinutes(0);
                today.setSeconds(0);
                fiscal_month_data.forEach(element => {
                if((element.status == 1) && (element.closing_type ==  1 || element.closing_type ==  2) ){                    
                    var start_date = new Date(element.start_date);
                    var end_date = new Date(element.end_date);
                    if (today >= start_date && today <= end_date) {
                            if (element.closing_type == 1) {
                                voucher_types = voucher_types.filter(function(type) {
                                    return !(['CASH PAYMENT', 'BANK PAYMENT'].includes(type.voucher_type_name));
                                });
                            } else if (element.closing_type == 2) {
                                voucher_types = [];
                            }
                        }
                }
                })

                var options = `<option value="" selected disabled>Select One</option>`;
                voucher_types.forEach(item => {
                    if(item.status == 1){
                        options+=`<option value="${item.voucher_type_no_pk}" data-type="${item.voucher_type_name}">${item.voucher_type_code}-${item.voucher_type_name}</option>`;
                    }
                })
                $('#journal_type').html(options);
            /* voucher type eligible test*/

        });  
    })
    /*add row*/
    $(document).ready(function(){
       
        var count=0;     
        $('#add_journal_posting').on('click', function(){
            count+=1;
            var tbl = `<tr class="journal-row" id="tbl${count}">
                        <td>
                            <select class="form-control form-control-sm select2 required" id="general_ledger${count}" name="general_ledger[]" onchange="checkCostCenter(this.value,${count})">
                                <option value="" disabled selected>Select One</option>
                                @foreach ($general_ledger->getData()->data as $item)
                                    @if($item->status == 1)
                                        <option value="{{$item->account_no_pk}}" data-cost="{{$item->cost_center_ind}}" data-sub="{{$item->sub_ledger_ind}}" data-dr_cr="{{$item->default_dr_cr}}">{{$item->account_code}} - {{$item->account_name}}</option>
                                    @endif
                                @endforeach
                            </select>

                        </td>
                        <td>
                            <select class="form-control form-control-sm" id="sub_ledger_type${count}" name="sub_ledger_type[]" onchange="fetchSubLedger(this.value,${count})">
                                <option value="0" selected>Select One</option>
                                @foreach ($sub_ledger_type->getData()->data as $item)
                                    @if($item->status == 1)
                                        <option value="{{$item->acct_subledger_typeno_pk}}" data-code="{{$item->subledgertype_code}}">{{$item->subledgertype_code}} - {{$item->subledgertype_name}}</option>
                                    @endif
                                @endforeach
                            </select>

                        </td>
                        <td>
                            <div id="sub_ledger_name_select${count}">
                                <select class="form-control form-control-sm" id="sub_ledger_name${count}" name="sub_ledger_name[]" onchange="checkEligibility(${count},'ledger')">
                                    <option value="0" selected>Select One</option>

                                </select>
                            </div>
                            <input type="hidden" class="form-control form-control-sm w-200" id="sub_ledger_name_input${count}" name="sub_ledger_name_input[]" value="" placeholder="admission, name, code" list="patients${count}" oninput="suggestPatient(${count})" autocomplete="off">
                            <input type="hidden" class="form-control form-control-sm" name="opd_ipd_ind[]" id="opd_ipd_ind${count}" value="">
                            <datalist id="patients${count}">
                                
                            </datalist>
                        </td>
                        <td>
                            <select class="form-control form-control-sm" id="dr_cr_type${count}" name="dr_cr_type[]" onchange="PriceUpdate()">
                                <option value="" selected disabled>select One</option>
                                <option value="dr">Dr.</option>
                                <option value="cr">Cr.</option>
                            </select>

                        </td>
                       
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="amt_curr${count}" name="amt_curr[]" placeholder="" value="0" oninput="calculateLocalPrice()"/>

                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="amt_local_curr${count}" name="amt_local_curr[]" placeholder="" value="0" oninput="PriceUpdate()" readonly/>

                        </td>
                        <td>
                            <select class="form-control form-control-sm" id="cost_center${count}" name="cost_center[]" onchange="checkEligibility(${count},'cost')">
                                <option value="0" selected>Select One</option>
                                @foreach ($cost_center->getData()->data as $item)
                                    @if($item->status == 1)
                                        <option value="{{$item->costcenter_no_pk}}">{{$item->costcenter_code}} - {{$item->costcenter_name}}</option>
                                    @endif
                                @endforeach
                            </select>

                        </td>

                        <td>
                            <input type="text" class="form-control form-control-sm" id="naration${count}" name="naration[]" placeholder="" value="" onclick="openModal('naration${count}')"/>

                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm date_picker" id="cheque_date${count}" name="cheque_date[]" placeholder="" value="" autocomplete="off"/>

                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="cheque_no${count}" name="cheque_no[]" placeholder="" value="" />

                        </td>
                        <td>
                            <span class="btn btn-warning remove_row"><i class="fas fa-trash" style="color:red"></i></span>
                        </td>
                     </tr>`;

                     

            $('.journal_posting_table tbody').append(tbl);

             //initialize cheque date        
            $('#cheque_date'+count).datepicker({
                    todayHighlight: true,
                    clearBtn: true,
                    autoclose: true,
                    format: 'dd/mm/yyyy',
            });

            //initialize validation
            
            $('#general_ledger'+count).rules('add', {required: true});
            $('#dr_cr_type'+count).rules('add', {required: true});
            $('#amt_curr'+count).rules('add', {required: true});
            $('#general_ledger'+count).select2({});
            $('#sub_ledger_name'+count).select2({});
            $('#cost_center'+count).select2({});

            // $('#general_ledger'+count).valid();              
            // $('#dr_cr_type'+count).valid();
            // $('#0'+count).valid();
            $.validator.messages.required = 'Required Field';
            $('#journalPostingV1').validate();
            changeJournalType();
        })

        /*remove row*/
        $(document).on("click", ".remove_row", function(){
                    if(confirm("Are you sure?")){
                        var id = $(this).closest('.journal-row').attr('id');
                         $("#"+id).remove();
                         PriceUpdate();
                    }
                    
                })
        })

        //initialize extention to jquery validate
        $.validator.addMethod("extension", function( value, element, param ) {
            param = typeof param === "string" ? param.replace( /,/g, "|" ) : "png|jpe?g|gif";
            return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
        }, $.validator.format( "Please enter a value with a valid extension." ) );

        //validate form
        $("#journalPostingV1").validate({
        rules:{
                doc_date:{
                    required:true,
                    dateFormat: true
                },
                post_date:{
                    required:true,
                    dateFormat: true
                },
                journal_type:{
                    required:true
                },
                'general_ledger[]':{
                    required:true,
                },
                'dr_cr_type[]':{
                    required:true,
                },
                currency:{
                    required:true,
                },
                curr_rate:{
                    required:true,
                },
                'amt_curr[]':{
                    required:true,
                },
                file1:{
                    extension: "jpg|jpeg|png|pdf",
                },
                file2:{
                    extension: "jpg|jpeg|png|pdf",
                },
                file3:{
                    extension: "jpg|jpeg|png|pdf",
                },
                total_dr:{
                    required:true, 
                },
                total_cr:{
                    required:true, 
                }
            },
            messages:{
                doc_date:{
                    required:'Document Date Required'
                },
                post_date:{
                    required: 'Post Date Required'
                },
                journal_type:{
                    required:'Journal Type Required'
                },
                'general_ledger[]':{
                    required:'Required Field',
                },
                'dr_cr_type[]':{
                    required:'Required',
                },               
                currency:{
                    required:'Currency Required',
                },
                curr_rate:{
                    required:'Currency Rate Required',
                },
                'amt_curr[]':{
                    required:'Required',
                },
                file1:{
                    extension: "Only pdf, jpg, jpeg, png file are Allowed",
                },
                file2:{
                    extension: "Only pdf, jpg, jpeg, png file are Allowed",
                },
                file3:{
                    extension: "Only pdf, jpg, jpeg, png file are Allowed",
                },
                total_cr:{
                    required:"Total Cr. Amount Required", 
                },
                total_dr:{
                    required:"Total Dr. Amount Required", 
                }
            }
        })

    /*cost center disabled*/

    function checkCostCenter(id,seq){
        
        var cost_center_ind = $('#general_ledger'+seq+' option:selected').data('cost');
        if(cost_center_ind == 1){
            var cost_options = '<?php echo json_encode($cost_option); ?>';
            $('#cost_center'+seq).html(cost_options);
            $('#cost_center'+seq).css({'border':'1px solid hsl(174deg 59% 45% / 50%)'});
          }
          else{
            $('#cost_center'+seq).css({'border':'dotted 1px black'});
            $('#cost_center'+seq).html("<option value='0' selected>Select One</option>");
        }

        /* default dr cr */
        var default_dr_cr = $('#general_ledger'+seq+' option:selected').data('dr_cr');
        if(default_dr_cr == 'DR'){
            $("#dr_cr_type"+seq).val('dr');
        }
        else if(default_dr_cr == 'CR'){
            $("#dr_cr_type"+seq).val('cr');
        }
        else{
            $("#dr_cr_type"+seq).val(''); 
        }

        PriceUpdate();
    }

    function openModal(id){
        if(!$('#staticBackdrop').is(':visible')){
            $('#narrationModal').val('')
            $('#narrationEditModal').click();           
            localStorage.setItem('narationId', id);
            $('#narrationModal').val($('#'+id).val())
        }
        else{
            var naration = localStorage.getItem('narationId');
            $('#'+naration).val($('#narrationModal').val())
        }
    }

    $('#staticBackdrop').on('shown.bs.modal', function () {
      $('#narrationModal').focus();
    });

    // fetch sub ledger name
    function fetchSubLedger(id,seq){
            if(id){
                
                $.ajax({
                url:"{{route('v1.accounts.get-sub-ledger-name-list','')}}/"+id,
                method: 'get',
                beforeSend: function() {
                        blockUI();
                },
                success:function(res){
  
                    var subledger_ind = $('#sub_ledger_type'+seq+' option:selected').data('code');
                    if(subledger_ind == 'OPD' || subledger_ind == 'IPD'){
                        $('#sub_ledger_name_select'+seq).hide();
                        $('#sub_ledger_name_input'+seq).attr('type','text'); 
                        $('#sub_ledger_name'+seq).val(0); 
                        $('#sub_ledger_name_input'+seq).val(''); 
                        if(subledger_ind == 'IPD'){
                            $('#sub_ledger_name_input'+seq).attr('placeholder','admission, code, name');                     
                            $('#opd_ipd_ind'+seq).val('IPD');
                        }
                        else{
                            $('#opd_ipd_ind'+seq).val('OPD')
                            $('#sub_ledger_name_input'+seq).attr('placeholder','invoice , code, name'); 
                        }                     
                    }
                    else{
                        $('#sub_ledger_name_input'+seq).val(''); 
                        $('#sub_ledger_name_input'+seq).attr('type','hidden'); 
                        $('#sub_ledger_name_select'+seq).show();
                        $('#sub_ledger_name'+seq).html(res);
                    }              
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            })

            checkEligibility(seq,'ledger');
        }
    }

    function suggestPatient(seq){

        let url = "{{route('v1.accounts.get-patient-info')}}";
        let key = $('#sub_ledger_name_input'+seq).val(); 
        let subledger_ind = $('#sub_ledger_type'+seq+' option:selected').data('code');

        if(key.length >= 3){
            $.ajax({
                    url:url,
                    type:"post",
                    data:{key:key,subledger_ind:subledger_ind},
                    success:function(data){   
                        var option = "";  
                        data.data.forEach(element => {                                
                            option+=`<option value='${element.patient}'>`;                               
                        });
                       
                        $('#patients'+seq).html(option);                                            
                    },
                    error:function(err){   
                        var error = err.responseJSON;
                        // $('.common-modal-notify-error').modal('show');
                        // $('.common-modal-notify-error .modal-title').html('Failed');
                        // $('.common-modal-notify-error .modal-body').html(error.message);
                    },

                });                        
        }
    }

    //update currency rate
    function changeCurrency(value){        
       var rate = $('#currency option:selected').data('rate');
        $('#curr_rate').val(rate);   
        calculateLocalPrice();
    }

    //price calculate
    function PriceUpdate(){
        var dr_values = 0; // Array to store the input values
        var cr_values = 0; // Array to store the input values
        $('input[name="amt_local_curr[]"]').each(function(index) {
            var value = $(this).val();
            var drCrValue = $('select[name="dr_cr_type[]"]').eq(index).val();

            if((value != '') && (drCrValue != '')){
                if(drCrValue == 'dr')
                dr_values+=parseFloat(value);
                if(drCrValue == 'cr')
                cr_values+=parseFloat(value);
                // cr_values.push(value);
            }           
        });
        cr_values = isNaN(cr_values) ? 0: cr_values.toFixed(2);
        dr_values = isNaN(dr_values) ? 0: dr_values.toFixed(2);

        $('#total_dr').val(dr_values)
        $('#total_cr').val(cr_values)

        if(cr_values != dr_values){
            $('#dr_cr_warning').html('Dr/Cr Amount Does  not Matching!')
        }
        else{
            $('#dr_cr_warning').html('')
        }    
        calculateSubDrCrPrice();    
    }

    function calculateSubDrCrPrice(){
        var dr_values = 0; // Array to store the input values
        var cr_values = 0; // Array to store the input values
        $('input[name="amt_local_curr[]"]').each(function(index) {
            var value = $(this).val();
            var drCrValue = $('select[name="dr_cr_type[]"]').eq(index).val();

            if((value != '') && (drCrValue != '')){
                if(drCrValue == 'dr')
                dr_values+=parseFloat(value);
                if(drCrValue == 'cr')
                cr_values+=parseFloat(value);
                // cr_values.push(value);
            }           
        });
        cr_values = isNaN(cr_values) ? 0: cr_values.toFixed(2);
        dr_values = isNaN(dr_values) ? 0: dr_values.toFixed(2);


        var rem_value = 0;
        var dr_cr_type = '';
        var curr_rate = $("#curr_rate").val();
        if(dr_values > cr_values){
             rem_value = parseFloat(dr_values) - parseFloat(cr_values);    
             rem_value = rem_value/curr_rate
            $('input[name="amt_local_curr[]"]').each(function(index) {
                    var amt_curr = $('input[name="amt_curr[]"]').eq(index).val();
                    dr_cr_type = $('select[name="dr_cr_type[]"]').eq(index).val();
                    if(amt_curr == 0 && dr_cr_type == 'cr'){
                        $('input[name="amt_curr[]"]').eq(index).val(rem_value);
                        var selectBoxId = $('input[name="amt_local_curr[]"]').eq(index).attr('id');
                        var ids = selectBoxId.substr(14);
                        calculateLocalPrice()
                    }        
                });
        }
        else if(dr_values < cr_values){
            rem_value = parseFloat(cr_values) - parseFloat(dr_values);  
            rem_value = rem_value/curr_rate
            $('input[name="amt_local_curr[]"]').each(function(index) {
                    var amt_curr = $('input[name="amt_curr[]"]').eq(index).val();
                    dr_cr_type = $('select[name="dr_cr_type[]"]').eq(index).val();
                    if(amt_curr == 0 && dr_cr_type == 'dr'){
                        $('input[name="amt_curr[]"]').eq(index).val(rem_value);
                        var selectBoxId = $('input[name="amt_local_curr[]"]').eq(index).attr('id');
                        var ids = selectBoxId.substr(14);                       
                        calculateLocalPrice()
                    }        
                });
        } 
    }

    //calculate local currency
    function calculateLocalPrice(){
        var rate = $('#curr_rate').val();
        $('input[name="amt_local_curr[]"]').each(function(index) {
            var amt = $('input[name="amt_curr[]"]').eq(index).val();
            var amount = (parseFloat(rate*amt)).toFixed(2);
            $('input[name="amt_local_curr[]"]').eq(index).val(rate*amt)
        });
        PriceUpdate();
    }

    //enable disable bank checque-number
    function changeJournalType(){
        var bank_p_r = $('#journal_type option:selected').data('type');
        if(bank_p_r == 'CASH PAYMENT' || bank_p_r == 'CASH RECEIPT'){
            $('select[name="general_ledger[]"]').each(function(index) { 
                    $('input[name="cheque_date[]"]').eq(index).val('');
                    $('input[name="cheque_no[]"]').eq(index).val('');
                    $('input[name="cheque_date[]"]').css({'border':'dotted 1px black','background-color': 'red !important'});
                    $('input[name="cheque_no[]"]').css({'border':'dotted 1px black','background-color': 'red !important'});
                    $('input[name="cheque_date[]"]').eq(index).attr('disabled',true);
                    $('input[name="cheque_no[]"]').eq(index).attr('disabled',true); 
                })
            
        } 
        else{
            if(bank_p_r != null){
                $('select[name="general_ledger[]"]').each(function(index) { 
                    $('input[name="cheque_date[]"]').css({'border':'1px solid hsl(174deg 59% 45% / 50%)'});
                    $('input[name="cheque_no[]"]').css({'border':'1px solid hsl(174deg 59% 45% / 50%)'});
                    $('input[name="cheque_date[]"]').eq(index).attr('disabled',false);
                    $('input[name="cheque_no[]"]').eq(index).attr('disabled',false);               
                })
            }
        }     
    }

    //Save Form Data
    function savejournalPostingV1(){          
            //check Validation
        if($('#journalPostingV1').valid()){
            
            var inputDate = $("#doc_date").val();
                inputDate =  moment(inputDate, "DD/MM/YYYY").format("MM/DD/YYYY");
            var dates_ind = true;
            var fiscal_year = '<?php echo json_encode($fiscal_year); ?>';
            var fiscal_year_array = JSON.parse(fiscal_year);
            var mergedArray = [...fiscal_year_array];
            mergedArray.forEach(function(year) {
                if (year.status == 1) {
                    var startDate = new Date(year.start_date);
                    var endDate = new Date(year.end_date);
                    var inputDateObject = new Date(inputDate);
                    if (inputDateObject >= startDate && inputDateObject <= endDate) {
                        dates_ind = false;
                    }
                }
            });
            if(dates_ind){
                $('#doc_date').val("");
                $('.post_date').val("");
                alert("Please open fiscal year");
                return false;
            }

            if($('#total_dr').val() != $('#total_cr').val()){
                alert('Dr amount and Cr Ammount Does not Match');
                return false;
            }
            if($('#total_dr').val() == 0){
                alert('Total Dr/Cr Ammount 0 is not valid');
                return false;
            }

            if($('.doc_date').val() != $('.post_date').val()){
                alert('Doc and post date not matched');
                return false;
            }

            var hasError = false;
            var general_ledger = '';
            var dr_cr = '';
            var amt_curr_amt = '';
            var cost_center = '';
            var cost_center_ind = '';
            var sub_ledger_ind = '';
            var sub_ledger = '';
            $('input[name="amt_local_curr[]"]').each(function(index) {                    
                general_ledger = $('select[name="general_ledger[]"]').eq(index).attr('id');
                dr_cr = $('select[name="dr_cr_type[]"]').eq(index).attr('id');
                amt_curr_amt = $('input[name="amt_curr[]"]').eq(index).attr('id');
                cost_center = $('select[name="cost_center[]"]').eq(index).attr('id');
                sub_ledger = $('select[name="sub_ledger_name[]"]').eq(index).attr('id');
                
                if($('#'+general_ledger).val() == null) {
                    alert('General Ledger is Required!');
                    hasError = true;
                    return false;
                }
                if($('#'+dr_cr).val() == null) {
                    alert('Dr/Cr is Required!');
                    hasError = true;
                    return false;
                }

                if($('#'+amt_curr_amt).val() == '') {
                    alert('Amount is Required!');
                    hasError = true;
                    return false;
                }
                if($('#'+amt_curr_amt).val() == 0) {
                    alert('Amount 0 is Invalid!');
                    hasError = true;
                    return false;
                }

                // cost center and sub ledger validation
                cost_center_ind = $('#'+general_ledger+' option:selected').data('cost');
                sub_ledger_ind = $('#'+general_ledger+' option:selected').data('sub');

                if(cost_center_ind == 1 && $('#'+cost_center).val() == 0){
                    alert('Cost Center Required!');
                    hasError = true;
                    return false;
                }

                if(sub_ledger_ind == 1 && $('#'+sub_ledger).val() == 0){
                    alert('Sub Ledger Name Required!');
                    hasError = true;
                    return false;
                }

            });

            if(hasError == true){
                return false;
            }

            let formElement = document.querySelector('#journalPostingV1');
            let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('v1.accounts.save-journal-posting')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                    $('#journalPostingV1 button[type="submit"]').prop('disabled', true);
                },
                success:function(data){                 
                    if(data.success == true){
                        resetForm();  
               
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                        if(data.hospital_code == 'EWMCH')
                            window.open("{{ route('account.payment-voucher-report-show') }}/"+data.voucher, "_blank");
                        else
                            window.open("{{ route('journal_show') }}?journal_id="+data.voucher, "_blank");
                    }                                                     
                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                $.unblockUI();
                $('#journalPostingV1 button[type="submit"]').prop('disabled', false);
                }
            });
        }
    }
    
    function resetForm(){

                var currDate = new Date();
                $('.post_date').datepicker().datepicker('setDate', currDate);
                $('.doc_date').datepicker().datepicker('setDate', currDate);
                $('#sub_ledger_name_input0').attr('type','hidden');
                $('#sub_ledger_name_select0').show();
                $('#sub_ledger_name0').html("<option value='0' selected>Select One</option>");
                $('#sub_ledger_type0').val(0);
                $('#cost_center0').val(0);
                $('#general_ledger0').val(null).trigger('change');
                $("tr:not(#tblhead0, #tbl0)").empty();                
                $('#total_dr').val(0);
                $('#total_cr').val(0);
                $('#journal_type').val('');
                $('#file1').val('');
                $('#file2').val('');
                $('#file3').val('');
                $('#attachment1').val('');
                $('#attachment2').val('');
                $('#attachment3').val('');
                $('#voucher_no').val('');
                $('#notes').val('');
                $('#dr_cr_type0').val('');
                $('#currency').val(1);
                $('#curr_rate').val(1);
                $('#amt_curr0').val(0);
                $('#amt_local_curr0').val(0);
                $('#naration0').val('');
                $('#cheque_date0').val('');
                $('#sub_ledger_name_input0').val('');
                $('#opd_ipd_ind0').val('');
                $('#cheque_no0').val('');       
    }

    function checkEligibility(index,selected){
        if(selected == 'cost'){         
            $('#sub_ledger_type'+index).val(0);
            $('#sub_ledger_name_input'+index).val(''); 
            $('#sub_ledger_name'+index).html("<option value='0' selected>Select One</option>");;              
        }
        else if(selected == 'ledger'){
            var cost_options = '<?php echo json_encode($cost_option); ?>';
            $('#cost_center'+index).html(cost_options);         
        }
    }
</script>

