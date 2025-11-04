<style>
    .sticky_header{
        position:sticky;
        top: 90px;
        
    }
</style>
<div class="card" style="overflow-x: scroll;">
    <div class="card-body">
        @if (!empty($schedule))
            {{-- <table style="width:30%">
                <tr> --}}
            <div class="d-inline-flex">
                @php
                    $sl=0;
                @endphp
                @foreach ($schedule as $key => $value)
                    @php
                        $date_explode = explode('_', $key);
                        $sl++;
                    @endphp

                    <div style=" width: 230px;">
                        <div class="card mt-0">
                            <div class="card-body" style="padding-top:0; ">
                                <div class="">
                                    <h5>{{ ucwords($date_explode[1]) }}</h5>
                                    <div style="border-top:1px solid black">
                                      

                                        <button type="button" class="btn btn-danger block" id="block_{{$sl}}" data-sl="{{$sl}}" data-docno='{{$date_explode[0]}}' data-toggle="modal" data-target="#exampleModal" onclick="setData(this)">Block</button>
                                        <button type="button" class="btn btn-warning unblock" id="unblock_{{$sl}}" data-sl="{{$sl}}" data-docno='{{$date_explode[0]}}' data-toggle="modal" data-target="#exampleModal" onclick="setData(this)">Unblock</button>
                                    </div>
                                    {{-- <span class="days_">Day</span> --}}
                                </div>
                                <div class="table-responsive table-y-overflow patient__table">
                                    <table class="table table-bordered table-hover table-striped time_slot">
                                        <thead class="sticky_header">
                                            <tr><th class="" colspan="4"></th></tr>
                                        </thead>
                                        <tbody id="slot_list">
                                          
                                            @if (!empty($value))
                                                @php 
                                                    $data_ind=0;
                                                @endphp
                                                @if(isset($value['block_reason']))
                                                    <tr>
                                                        <td>{{ $value['block_date'] }}</td>
                                                    </tr>
                                                    <tr class="table-row">
                                                        <td>{{ $value['block_reason'] }}</td>
                                                    </tr>
                                                @else
                                                    
                                                    @foreach ($value as $row)
                                                    @php 
                                                        $data_ind=!empty($row) ? 1:0;
                                                      
                                                    @endphp
                                                        @if (isset($row->patient_name)&& $row->cancel_ind != 1)
                                                            @php 
                                                                $app_status_color='';
                                                                if($row->pres_ind == 1){
                                                                    $app_status_color="background-color:gray; color:white; border-radius:5px;";
                                                                }else if($row->consult_ind == 1){
                                                                    $app_status_color="background-color:green; color:white; border-radius:5px;";
                                                                }  
                                                              

                                                            @endphp
                                                            <tr class="table-row" id="table-row-{{ $row->slot_no_pk }}"
                                                                data-slot_id="{{ $row->slot_no_pk }}">
                                                                <th></th>
                                                                <th style="width: 70px;">
                                                                    {{ date('h:i', strtotime($row->start_time)) }}
                                                                    <sup>{{ date('a', strtotime($row->start_time)) }}</sup>
                                                                    <input type="hidden" id="app_info" data-slot_no="{{ $row->slot_no_pk }}" value="{{$row->start_time}}">
                                                                </th>
                                                                <td colspan="3" class="text-left" style="<?= $app_status_color; ?>"
                                                                    title="{{ $row->patient_code }} &#10;{{ $row->patient_name }} &#10;{{ $row->appoint_type_code }} : {{ date('h:i a', strtotime($row->start_time)) }}-{{ date('h:i a', strtotime($row->end_time)) }} &#10;Company: {{ $row->ccm_client_name }} &#10;Mobile No: {{ $row->mobile1 }} &#10;Case Type: {{ $row->case_type_name }}  &#10;Calling Notes: {{ $row->calling_note }} ">
                                                                    {{ $row->patient_name }}
                                                                </td>
                                                            </tr>

                                                            <div class="context-menu"
                                                                id='context-menu-{{ $row->slot_no_pk }}'>
                                                                <ul>
                                                                    <li>
                                                                        <a target="_blank"
                                                                            href="{{ route('uhl.appointment-form', $row->appoint_no_pk) }}">
                                                                            APPOINTMENT DETAILS</a>
                                                                    </li>

                                                                    @if($row->patient_no_pk !='')
                                                                    <li>
                                                                        <span
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                            class=" open-modal" data-modal="common-modal"
                                                                            data-id="{{ $row->patient_no_pk }}"
                                                                            data-title="Patient Information"
                                                                            data-action="{{ route('registration.show', isset($row->patient_no_pk) ? $row->patient_no_pk : 0) }}"
                                                                            rel="tab">PATIENT
                                                                            DETAILS</span>
                                                                    </li>
                                                                    @endif
                                                                    {{-- <li><a href="{{ route('uhl.appointment-edit', $row->appoint_no_pk) }}"
                                                                            rel="tab">EDIT
                                                                            APPOINTMENT</a>
                                                                    </li> --}}

                                                                    <li>
                                                                        <span
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                            class=" open-modal" data-modal="common-modal-sm"
                                                                            data-id="{{ $row->appoint_no_pk }}"
                                                                            data-title="CANCEL APPOINTMENT"
                                                                            data-action="{{ route('uhl.cancel-appointment', $row->appoint_no_pk) }}"
                                                                            rel="tab">CANCEL
                                                                            APPOINTMENT</span>
                                                                    </li>

                                                                    {{-- <li>
                                                                        <span onclick="statusChange(this)"
                                                                            data-url="{{ route('uhl.app-status-change') }}"
                                                                            data-appoint="{{ $row->appoint_no_pk }}"
                                                                            data-res-url="{{ route('uhl.appointment') }}"
                                                                            data-type="checkin"
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;">CHK-IN</span>
                                                                    </li>
                                                                    <li> <span onclick="statusChange(this)"
                                                                            data-url="{{ route('uhl.app-status-change') }}"
                                                                            data-appoint="{{ $row->appoint_no_pk }}"
                                                                            data-res-url="{{ route('uhl.appointment') }}"
                                                                            data-type="cancelchecking"
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;">CANCEL
                                                                            CHC-IN</span>
                                                                    </li>

                                                                    <li>
                                                                        <span onclick="statusChange(this)"
                                                                            data-url="{{ route('uhl.app-status-change') }}"
                                                                            data-appoint="{{ $row->appoint_no_pk }}"
                                                                            data-res-url="{{ route('uhl.appointment') }}"
                                                                            data-type="confirm"
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;">CONFIRM</span>

                                                                    </li>



                                                                    <li> <span onclick="statusChange(this)"
                                                                            data-url="{{ route('uhl.app-status-change') }}"
                                                                            data-appoint="{{ $row->appoint_no_pk }}"
                                                                            data-res-url="{{ route('uhl.appointment') }}"
                                                                            data-type="unconfirm"
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;">UNCONF</span>
                                                                    </li> --}}



                                                                    <li>
                                                                        <span
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                            class=" open-modal" data-modal="common-modal-sm"
                                                                            data-id="{{ $row->appoint_no_pk }}"
                                                                            data-title="CALLING NOTES"
                                                                            data-action="{{ route('uhl.calling-note', $row->appoint_no_pk) }}"
                                                                            rel="tab">CALLING
                                                                            NOTES</span>

                                                                    </li>
                                                                    <li><a target="_blank"
                                                                            href="{{ route('patient-appointment-print', $row->appoint_no_pk) }}">TOKEN
                                                                            PRINT</a>
                                                                    </li>
                                                                    @if($row->patient_no_pk !='')
                                                                    <li>
                                                                        
                                                                        @if(Session::get('user.ses_hospital_code') == "UNICO")
                                                                            @if($row->consult_ind != 1 && $row->pres_ind != 1 && $row->visit_type_code != 'PKG')
                                                                                <a href="{{ route('uhl.billing-invoice-form', $row->patient_no_pk . '-' . $row->appoint_no_pk . '-' . 'app') }}" target="_blank">
                                                                                   Doctor Bill Payment
                                                                                </a>
                                                                            @endif
                                                                        @else
                                                                            @if($row->consult_ind != 1 && $row->pres_ind != 1)
                                                                            <a href="{{ route('billing.service-billing', $row->patient_no_pk . '-' . $row->appoint_no_pk . '-' . 'app') }}" target="_blank">
                                                                                Payment
                                                                            </a>
                                                                            @endif
                                                                        @endif
                                                                    </li>
                                                                    <li>
                                                                        @if(Session::get('user.ses_hospital_code') == "UNICO")
                                                                            @if($row->consult_ind != 1 && $row->pres_ind != 1 && $row->visit_type_code == 'PKG')
                                                                                <a href="{{ route('uhl.billing-invoice-form', $row->patient_no_pk . '-' . $row->appoint_no_pk . '-' . 'PKG') }}" target="_blank">
                                                                                    Package  Payment
                                                                                </a>
                                                                        @endif
                                                                        {{-- @else
                                                                            <a href="{{ route('billing.service-billing', $row->patient_no_pk . '-' . $row->appoint_no_pk . '-' . 'app') }}" target="_blank">
                                                                                Package  Payment --}}
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                    
                                                                    @endif
                                                                    @if($row->patient_no_pk =='')
                                                                   
                                                                        
                                                                   
                                                                        <li>
                                                                            @if (Session::get('user.ses_hospital_code')=="UNICO")
                                                                            <span
                                                                            style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                            class="open-modal"
                                                                            data-modal="common-modal-sm"
                                                                            data-id="{{ $row->appoint_no_pk }}"
                                                                            data-title="Enter UHID"
                                                                            data-action="{{ route('uhl.appointment-update', $row->appoint_no_pk.'_'.$row->slot_no_pk) }}"
                                                                            rel="tab">Update Appointment</span>

                                                                            @else
                                                                                   <a
                                                                                    style=" color: black; text-decoration: none;background-color: transparent;"                      
                                                                                    title="Patient Registration"
                                                                                    class="text-uppercase"
                                                                                    href="{{ route('patient-create', $row->appoint_no_pk) }}"
                                                                                    rel="tab">Patient Registration</a>  
                                                                            @endif

                                                                        </li>
                                                                    @endif
                                                                    {{-- <li><span class='Orange'></span>&nbsp;<span>Orange</span></li>
                                                            <li><span class='Plum'></span>&nbsp;<span>Plum</span></li> --}}
                                                                </ul>
                                                            </div>
                                                        @else
                                                            @php
                                                                 $block_ind = ($row->pres_ind == 1 || $row->consult_ind == 1) ? '' : '<input type="checkbox" class="block_ind" value="' . htmlspecialchars($row->slot_no_pk) . '">';
                                                            @endphp
                                                            <tr class="table-row" id="table-row-{{ $row->slot_no_pk }}"
                                                                data-slot_id="{{ $row->slot_no_pk }}">
                                                                <th>@php echo $block_ind @endphp</th>
                                                                <th style="width: 70px;">
                                                                    {{ date('h:i', strtotime($row->start_time)) }}
                                                                    <sup>{{ date('a', strtotime($row->start_time)) }}</sup>
                                                                    <input type="hidden" id="app_info" data-slot_no="{{ $row->slot_no_pk }}" value="{{$row->start_time}}">
                                                                </th>
                                                                <td colspan="3"
                                                                    class="{{ $row->block_ind == 1 ? 'badge badge-danger d-block' : '' }}">
                                                                    <span
                                                                        title="{{ $row->block_ind == 1 ? 'Block Reason: ' . $row->block_reason . '. This slot is blocked by ' . $row->user_fullname : '' }}"
                                                                        class="{{ $row->block_ind == 1 ? 'text-warning' : '' }}">{{ $row->block_ind == 1 ? 'Blocked' : '' }}</span>
                                                                </td>
                                                            </tr>
                                                            
                                                            @if ($row->block_ind == 1)
                                                                <div class="context-menu"
                                                                    id='context-menu-{{ $row->slot_no_pk }}'>
                                                                    <ul>

                                                                        <li>
                                                                            <span
                                                                                style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                                class=" open-modal"
                                                                                data-modal="common-modal-sm"
                                                                                data-id="{{ $row->slot_no_pk }}"
                                                                                data-title="UNDO SLOT BLOCK REASON"
                                                                                data-action="{{ route('uhl.slot-block-release', $row->slot_no_pk) }}"
                                                                                rel="tab">Undo
                                                                                Break/Block/Reserve</span>
                                                                        </li>


                                                                    </ul>
                                                                </div>
                                                            @else
                                                                <div class="context-menu"
                                                                    id='context-menu-{{ $row->slot_no_pk }}'>
                                                                    <ul>
                                                                        <li><a href="{{ route('uhl.appointment-details', $row->slot_no_pk) }}"
                                                                                rel="tab">New Appointment</a>
                                                                        </li>
                                                                        <li>
                                                                            <span
                                                                                style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                                class=" open-modal"
                                                                                data-modal="common-modal-sm"
                                                                                data-id="{{ $row->slot_no_pk }}"
                                                                                data-title="SLOT BLOCK REASON"
                                                                                data-action="{{ route('uhl.slot-block', $row->slot_no_pk) }}"
                                                                                rel="tab">Break/Block/Reserve</span>
                                                                        </li>

                                                                        <li>
                                                                            <span
                                                                                style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                                class=" open-modal"
                                                                                data-modal="common-modal-md"
                                                                                data-id="{{ $date_explode[0] }}"
                                                                                data-title="Doctor Information"
                                                                                data-action="{{ route('employees.show', $date_explode[0]) }}"
                                                                                rel="tab">Doctor
                                                                                Profile</span>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endif
                                                       
                                                    @endforeach                                                  
                                                    @if($data_ind==1)
                                                        @if(Session::get('user.ses_hospital_code')=="UNICO")
                                                            @if(Session::get('user.inv_hod_ind')==1)
                                                                <tr>
                                                                    <th colspan="2"><strong>Add Slot</strong></th>
                                                                    <td style="text-align: right">
                                                                        <button type="button" class="btn btn-primary cursor-pointer" onclick="add_slot(this)"> <i class="fa fa-plus"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @else
                                                            <tr>
                                                                <th colspan="2"><strong>Add Slot</strong></th>
                                                                <td style="text-align: right">
                                                                    <button type="button" class="btn btn-primary cursor-pointer" onclick="add_slot(this)"> <i class="fa fa-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                       
                                                    @endif
                                                @endif
                                            @endif
                                           
                                        </tbody>
                                    </table>
                                    <input type='hidden' value='' id='txt_id'>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </td> --}}
                @endforeach
            </div>
            {{-- </tr>
        </table> --}}
        @else
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="padding-top:0;height: 468px;">
                                <div class="appointment-box">
                                    <h3> Get Your Appointment</h3>
                                    <img src="{{ asset('images/appitnment-img.png') }}" alt="appointment">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>

</div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12">
                <ul class="grid__box">
                    <li class="bg_patient">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->new_pat) ? $total_app_count->new_pat : '0' }}</h4>
                                <span class="icon"><i class="fas fa-user-injured"></i></span>
                            </div>
                            <p>New Registration</p>
                        </div>
                    </li>
                    <li class="bg_appointment">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->app_patient) ? $total_app_count->app_patient : '0' }}
                                </h4>
                                <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <p>Appointment</p>
                        </div>
                    </li>
                    {{-- <li class="bg_confirmed">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->confirmed) ? $total_app_count->confirmed : '0' }}</h4>
                                <span class="icon"><i class="fas fa-calendar-check"></i></span>
                            </div>
                            <p>Confirmed</p>
                        </div>
                    </li>
                    <li class="bg_checked">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->chk) ? $total_app_count->chk : '0' }}</h4>
                                <span class="icon"><i class="fas fa-spell-check"></i></span>
                            </div>
                            <p>Checked In</p>
                        </div>
                    </li> --}}
                    <li class="bg_cancel">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->can) ? $total_app_count->can : '0' }}</h4>
                                <span class="icon"><i class="fas fa-window-close"></i></span>
                            </div>
                            <p>Cancelled</p>
                        </div>
                    </li>
                    <li class="bg_payment">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->new_pat) ? $total_app_count->new_pat : '0' }}</h4>
                                <span class="icon"><i class="fas fa-money-check-alt"></i></span>
                            </div>
                            <p>Payment</p>
                        </div>
                    </li>
                    <li class="bg_seen">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->new_pat) ? $total_app_count->new_pat : '0' }}</h4>
                                <span class="icon"><i class="fas fa-user-md"></i></span>
                            </div>
                            <p>Consulted</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{-- <div class="modal-body">
            <label for="message-text" class="col-form-label">Reason:</label>
            <textarea class="form-control" id="reasonText" data-reason="" name="" id="message-text" required></textarea>

        </div> --}}
        <div class="modal-footer">
            {{-- <label for="message-text" class="col-form-label text-left">Reason:</label> --}}
            <textarea class="form-control" id="reasonText"  name="" id="message-text" required></textarea>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-sm btn-danger" id="block_{{$sl}}" data-docno='{{$date_explode[0]}}' onclick="saveBlock(this)">Block</button>
          <button type="button" class="btn btn-sm btn-warning" id="unblock_{{$sl}}" data-docno='{{$date_explode[0]}}' onclick="saveBlock(this)">Unblock</button> --}}
          <input type="hidden" name="idSlNo" id="idSlNo" value="">
          <input type="hidden" name="docNo" id="docNo" value="">
          <button type="button" class="btn  btn-danger"  data-dismiss="modal" id="save_block" onclick="saveBlock(this)">Block</button>
          <button type="button" class="btn  btn-warning"  data-dismiss="modal" id="save_unblock"  onclick="saveBlock(this)">Unblock</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>

<script>
    function setData(element) {
        let sl=$(element).data('sl');
        let docno=$(element).data('docno');
        let idName=$(element).attr('id');
        $('#idSlNo').val(sl);
        $('#docNo').val(docno);
        if (idName=="block_"+sl) {
            $('#save_block').removeClass('d-none');
            $('#save_unblock').addClass('d-none');
        }else{
            $('#save_block').addClass('d-none');
            $('#save_unblock').removeClass('d-none');
        }
    }
    function saveBlock(element){
        // let doc_no=$(element).data('docno');
        let doc_no=$(element).siblings('#docNo').val();
        let reasonText=$(element).siblings('#reasonText').val();     
        let findSiblingsSl=$(element).siblings('#idSlNo').val();         
        let type=$(element).attr('id') == 'save_block' ? 1 :0;
        var slot_no=$('#block_'+findSiblingsSl)
        .parents('div')
        .parents('div')
        .siblings('div')
        .children('table')
        .children('tbody')
        .find('.block_ind:checked')
        .map(function() {
            return $(this).val();          // Get the value of each '.block_ind' element
        })
        .get();   
       
      
        if (slot_no.length ===0) {
            alert('Select Slot');
            return false;
        }
        if (reasonText =='') {
            alert('Enter Reason');
            return false;
        }
        console.log(reasonText,type,slot_no)
        // return false;
        var url="{{route('uhl.array-slot-block')}}";
       
       
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    slot_no: slot_no,                    
                    doc_no: doc_no,                    
                    cancel_reason: reasonText,                    
                    type: type,                    
                },
                url:url ,
                type: "post",
                cache: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                //  $('#search_btn').click();
                },
                complete: function() {
                    // $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $('#search_btn').click();
                $.unblockUI();
                // dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }
    function add_slot(element){
        var slot_no=$(element).parents('tr').prev().find('#app_info').attr('data-slot_no');
        var time =$(element).parents('tr').prev().find('#app_info').val();
        var url="{{route('uhl.add-slot')}}";
        console.log(slot_no)
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    slot_no: slot_no,                    
                },
                url:url ,
                type: "post",
                cache: false,
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                 $('#search_btn').click();
                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
                dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }
    $(document).ready(function() {
        var slot_id_open = '';
        // disable right click and show custom context menu
        $(".time_slot tr").bind('contextmenu', function(e) {
            var id = this.id; //$(this).attr('class');
            var slot_id = $(this).data('slot_id');
            $("#context-menu-" + slot_id).hide();

            $("#txt_id").val(id);

            var top = e.pageY;
            var left = e.pageX;

            // Show contextmenu
            $(".context-menu").hide();
            $("#context-menu-" + slot_id).toggle(100)
                .css({
                    top: top - 200 + "px",
                    //left: left + "px"
                });

            // disable default context menu
            return false;
        });

        // Hide context menu
        $(document).bind('contextmenu click', function() {

            $(".context-menu").hide();
            $("#txt_id").val("");
        });

        // disable context-menu from custom menu
        $('.context-menu').bind('contextmenu', function() {
            return false;
        });

        // Clicked context-menu item
        $('.context-menu li').click(function() {
            var className = $(this).find("span:nth-child(1)").attr("class");
            var titleid = $('#txt_id').val();
            $("." + titleid).css("background-color", className);
            $(".context-menu").hide();
        });

    });

    function statusChange(element) {
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    appoint_no_pk: $(element).attr('data-appoint'),
                    type: $(element).attr('data-type'),
                },
                url: $(element).attr('data-url'),
                type: "post",
                cache: false,
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
                dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }
</script>
