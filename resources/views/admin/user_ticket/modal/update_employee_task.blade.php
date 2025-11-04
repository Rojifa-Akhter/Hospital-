 <!-- Modal -->
 
 <form action="{{route('v1.ticket.update-employe-task-progress')}}" method="post" id="updateAccountsGroupType" class="updateAccountsGroupType">
    @csrf
    <div class="row">
        <div class="col-md-12 col-12">
            <label for="progress" class="col-form-label">Progress<span style="color:red">*</span></label>
            <select type="text" class="form-control form-control-sm" id="progress_modal" name="progress_modal"> 
                <option value="1" {{$data->progress_status == 1 ? 'selected' : ''}}>Pending</option>
                <option value="2" {{$data->progress_status == 2 ? 'selected' : ''}}>working</option>
                <option value="3" {{$data->progress_status == 3 ? 'selected' : ''}}>Done</option>
                <option value="4" {{$data->progress_status == 4 ? 'selected' : ''}}>Now Not Possible</option>
                <option value="5" {{$data->progress_status == 5 ? 'selected' : ''}}>Not Possible</option>
            </select> 

            <div class="mt-2">
                <label for="notes" class="col-form-label">Notes</label>
                <textarea name="notes" class="form-control form-control-sm" id=""  rows="3">{{ $data->task_notes }}</textarea>
            </div>
            <div class="mt-2">
                <label for="description" class="col-form-label">Description</label>
                <div id="description" class="description">{!!$data->issue_descriptions!!}</div>
            </div>

            <input type="hidden" name="issue_no_pk" id="issue_no_pk" value="{{$data->issue_no_pk}}">
        </div>

    </div>

    @php
        $redirect_url = route('v1.ticket.employee-task');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',employeeTaskSearch,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>