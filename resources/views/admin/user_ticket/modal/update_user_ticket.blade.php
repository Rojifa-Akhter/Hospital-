 <!-- Modal -->
 
 <form action="{{route('v1.ticket.update-ticket-progress')}}" method="post" id="updateAccountsGroupType" class="updateAccountsGroupType">
    @csrf
    <div class="row">
        <div class="col-md-7 col-12">
            <label for="progress" class="col-form-label">Progress<span style="color:red">*</span></label>
            <select type="text" class="form-control form-control-sm" id="progress_modal" name="progress_modal"> 
                <option value="1" {{$data->progress_status == 1 ? 'selected' : ''}}>Pending</option>
                <option value="2" {{$data->progress_status == 2 ? 'selected' : ''}}>working</option>
                <option value="3" {{$data->progress_status == 3 ? 'selected' : ''}}>Done</option>
                <option value="4" {{$data->progress_status == 4 ? 'selected' : ''}}>Now Not Possible</option>
                <option value="5" {{$data->progress_status == 5 ? 'selected' : ''}}>Not Possible</option>
            </select> 

            <div class="mt-2">
                <label for="feedback" class="col-form-label">Feedback</label>
                <textarea name="feedback" class="form-control form-control-sm" id="feedback"   rows="5" placeholder="Feedback here ...">{{$data->feedback}}</textarea>
            </div>

            <div class="mt-2">
                <label for="description" class="col-form-label">Description</label>
                <div id="description" class="description">{!!$data->issue_descriptions!!}</div>
            </div>

            <input type="hidden" name="issue_no_pk" id="issue_no_pk" value="{{$data->issue_no_pk}}">
        </div>
        <div class="col-md-5 col-12" style="border-left:2px dotted blue">

            <h6 class="text-center text-primary"><b>Assign Task To Employeer</b> </h6>

            <span class="text-center"><u>Task Assigned</u></span>
            <div><b>Name :</b> {{$data->task_full_mobile}}</div>  
            <div><b>Mobile :</b> {{$data->task_phone_mobile}}</div>  
            <div><b>Designation :</b> {{$data->task_designation}}</div>  
            <div><b>Department :</b> {{$data->task_su_name}}</div>  

            <span class="text-center mt-2"><u>Task Assigned By</u></span>
            <div><b>Name :</b> {{$data->task_assigned_full_name}}</div>  
            <div><b>Mobile :</b> {{$data->task_assigned_phone_mobile}}</div>  
            <div><b>Designation :</b> {{$data->task_assigned_designation}}</div>  
            <div><b>Department :</b> {{$data->task_assigned_su_name}}</div>   


            <label for="priority" class="col-form-label">Priority Type<span style="color:red">*</span></label>
            <select type="text" class="form-control form-control-sm" id="priority_modal" name="priority_modal"> 
                <option value="">Select One</option>
                <option value="1" {{$data->priority_type_no == 1 ? 'selected' : ''}}>Regular</option>
                <option value="2" {{$data->priority_type_no == 2 ? 'selected' : ''}}>Medium</option>
                <option value="3" {{$data->priority_type_no == 3 ? 'selected' : ''}}>High</option>
                <option value="4" {{$data->priority_type_no == 4 ? 'selected' : ''}}>Less Important</option>
            </select> 

            <div class="mt-2">
                <label for="priority" class="col-form-label">Employeer<span style="color:red">*</span></label>
                <select type="text" class="form-control form-control-sm select2" id="priority_modal" name="users_modal"> 
                    <option value="">Select One</option>
                    @foreach ($users as $item)
                        @if($item->status == 1 && !empty($item->user_fullname))
                            <option value="{{$item->person_no_fk}}" {{$data->task_person_no_fk == $item->person_no_fk ? 'selected' : ''}}> @if(!empty($item->user_code)){{$item->user_code}} - @endif {{$item->user_fullname}}   </option>
                        @endif
                    @endforeach                       
                </select> 
            </div>
            

            <div class="mt-2">
                <label for="notes_modal" class="col-form-label">Notes</label>
                <textarea name="notes_modal" class="form-control form-control-sm" id="notes_modal"   rows="5" placeholder="Notes here ...">{{$data->task_notes}}</textarea>
            </div>

        </div>
    </div>

    @php
        $redirect_url = route('v1.ticket.support-ticket');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',supportTicketSearch,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>