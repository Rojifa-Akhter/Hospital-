@php
$ccm_company_id = $corporate_client ? $corporate_client->ccm_client_no_pk : '';
$ccm_company_name = $corporate_client ? $corporate_client->ccm_client_name : '';
$ccm_contact_person = $corporate_client ? $corporate_client->contact_person : '';
$ccm_contact_number = $corporate_client ? $corporate_client->contact_mobile : '';
@endphp

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <!-- form start -->
        {{--form start--}}
        <form action="{{route('corporate.staff.add')}}" method="post" id="staffadd">
            @csrf
            <input type="hidden" name="companyId" value="{{ $ccm_company_id}}">
            <input type="hidden" name="companyName" value="{{ $ccm_company_name}}">
            <input type="hidden" name="contactPerson" value="{{ $ccm_contact_person}}">
            <input type="hidden" name="contactNumber" value="{{ $ccm_contact_number}}">

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID" class="col-form-label s-12">ID</label>
                        <input type="text" class="form-control" id="Id" name="Id"
                        placeholder="Staff ID" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Name" class="col-form-label s-12">Name</label>
                        <input type="text" class="form-control" id="Name" name="Name"
                        placeholder="Staff Name" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <label for="Designation" class="col-form-label s-12">Designation</label>
                    <select class="form-control mr-sm-2 select2" id="Designation" name="Designation">
                        <option selected value="">Choose designation</option>
                        @if(isset($designation))
                        @foreach($designation as $record)
                        <option value="{{$record->designation_no_pk}}" {{$record->designation_no_pk == $ccm_designation_no_fk? 'selected': ''}}>{{$record->designation_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Contact" class="col-form-label s-12">Contact</label>
                        <input type="tel" class="form-control" id="Contact" name="Contact"
                        value="" placeholder="+880" />
                    </div>
                </div> --}}
            </div>
            <div class="form-row">
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID" class="col-form-label s-12">ID</label>
                        <input type="text" class="form-control" id="Id" name="Id" value=""
                        placeholder="Staff ID" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Name" class="col-form-label s-12">Name</label>
                        <input type="text" class="form-control" id="Name" name="Name" value=""
                        placeholder="Staff Name" />
                    </div>
                </div> --}}

                <div class="col-md-6">
                    <label for="Designation" class="col-form-label s-12">Designation</label>
                    <select class="form-control mr-sm-2 select2" id="Designation" name="Designation">
                        <option selected value="">Choose designation</option>
                        @if(isset($designation))
                        @foreach($designation as $record)
                        <option value="{{$record->designation_no_pk}}">{{$record->designation_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Contact" class="col-form-label s-12">Contact</label>
                        <input type="tel" class="form-control" id="Contact" name="Contact"
                       placeholder="+880" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Email" class="col-form-label s-12">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                         placeholder="example@mail.com" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Patient ID</label>
                        <input type="text" class="form-control" id="patientID"
                        name="patientID"  placeholder="Patient ID" />
                    </div>
                </div>

                {{-- <div class="col-md-5">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB" value="{{}}"
                            class="form-control" />
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <input type="text" id="Age" name="Age" value="{{}}"
                            class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="Gender" class="col-form-label s-12">Gender</label>
                    <select class="form-control mr-sm-2" id="Gender" name="Gender">
                        <option selected value="{{}}">Choose gender</option>
                        @if(isset($gender))
                        @foreach($gender as $key=>$value)
                        <option value="{{$key}}"  {{$key == $ccm_gender_no_fk? 'selected': ''}}>{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div> --}}
            </div>
            <div class="form-row">
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="Email" class="col-form-label s-12">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                        value="{{}}" placeholder="example@mail.com" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Patient ID</label>
                        <input type="text" class="form-control" id="patientID"
                        name="patientID" value="{{}}" placeholder="Patient ID" />
                    </div>
                </div> --}}

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB"
                            class="form-control" />
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <input type="text" id="Age" name="Age"
                            class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="Gender" class="col-form-label s-12">Gender</label>
                    <select class="form-control mr-sm-2" id="Gender" name="Gender">
                        <option selected value="">Choose gender</option>
                        @if(isset($gender))
                        @foreach($gender as $key=>$value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="modal-footer mt-1 text-left">
                @php
                $response_action = route('corporate.worklist');
                @endphp
                {{-- <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button> --}}
                {{-- <button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button> --}}

            </div>

            <button type="button" class="btn btn-info btn-md btn-block" title="" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">ADD</button>

            {{-- <button type="submit" class="btn btn-info btn-md btn-block" title="">ADD</button> --}}

        </form>

        <!-- form end -->
    </div>
</div>
<script type="text/javascript">
    $(function() {

        $("input[name=Deposit]:radio").click(function() {
            if ($('input[name=Deposit]:checked').val() == "1") {
                $('.deposit-text-box').show();
            }
        });

    });
</script>

