 <table class="table data-table table-striped table-bordered table-hover mb-0">
     <thead class="bg-primary">
         <tr>
             <th class="text-center">SL</th>
             <th class="text-center">Patient Name</th>
             <th class="text-center">Req. ID</th>
             <th class="text-center">Prescription ID</th>
             <th class="text-center">Admission ID</th>
             <th class="text-center">UHID</th>
             <th class="text-center">Dept. Name</th>
             <th class="text-center">Ward/Cabin Name</th>
             <th class="text-center">Age</th>
             <th class="text-center">Sex</th>
             <th class="text-center">Requisition Date</th>
             <th class="text-center">Proposed operation</th>
             <th class="text-left" style="width: 200px">OT Status</th>
         </tr>
     </thead>
     <tbody>
      
         @if ($ot_requisition_wl)
             @foreach ($ot_requisition_wl as $ot_req)
                 <tr>
                     <td class="text-center">{{ $loop->iteration }}</td>
                     <td>{{ $ot_req->patient_name ?? '' }}</td>
                     <td>{{ $ot_req->ot_req_no_pk ?? '' }}</td>
                     <td>{{ $ot_req->prescription_no_fk ?? '' }}</td>
                     <td>{{ $ot_req->admission_uid ?? '' }}</td>
                     <td>{{ $ot_req->patient_code ?? '' }}</td> {{-- নতুন UHID ফিল্ড --}}
                     <td>{{ $ot_req->new_serivce_unit_name ?? '' }}</td>
                     <td>{{ $ot_req->ward_name ?? '' }}</td>
                     <td>{{ $ot_req->age ?? '' }}</td>
                     <td>{{ $ot_req->gender_txt ?? '' }}</td>
                     <td>{{ !empty($ot_req->ot_req_date) ? date('d/m/Y H:i A', strtotime($ot_req->ot_req_date)) : '' }}
                     </td>
                     <td>{{ $ot_req->item_name ?? '' }}</td>
                     <td class="text-left">
                         @php
                             $status = 'Pending';
                             if ($ot_req->ot_comfirmation_ind == 1) {
                                 $status = 'Confirm';
                             } elseif ($ot_req->reject_ind == 1) {
                                 $status = 'Reject';
                             }

                             $isConfirmed = $ot_req->ot_comfirmation_ind == 1;
                             $isRejected = $ot_req->reject_ind == 1;
                         @endphp

                         @if ($status == 'Pending')
                             <button class="btn btn-warning btn-sm"
                                 onclick="changeStatus({{ $ot_req->ot_req_no_pk }}, 'Confirm')">
                                 Confirm
                             </button>
                             <button class="btn btn-danger btn-sm"
                                 onclick="changeStatus({{ $ot_req->ot_req_no_pk }}, 'Reject')">
                                 Reject
                             </button>
                         @elseif($status == 'Confirm')
                             <span class="badge bg-success">Confirmed</span>
                         @else
                             <span class="badge bg-danger">Rejected</span>
                         @endif
                        
                            <div class="mt-1 small text-muted">
                             @if ($isConfirmed)
                                 Confirmed by
                                 <strong>{{ $ot_req->ot_comfirmation_doc_name ?? '—' }}</strong>
                                 on
                                 {{ $ot_req->ot_comfirmation_time ? date('d/m/Y H:i A', strtotime($ot_req->ot_comfirmation_time)) : '—' }}
                             @elseif ($isRejected)
                                 Rejected by <strong>{{ $ot_req->ot_reject_by_name ?? '—' }}</strong>
                                 on
                                 {{ $ot_req->reject_time ? date('d/m/Y H:i A', strtotime($ot_req->reject_time)) : '—' }}
                                 <br>
                                 <em>Reason:</em>
                                 {{ $ot_req->reject_note ?? '—' }}
                             @endif
                               
                         </div>
                     </td>
                 </tr>
             @endforeach
         @endif
     </tbody>
 </table>
