 <!-- Modal -->
<form action="{{route('v1.accounts.update-sub-ledger-name')}}" method="post" id="updateSubLedgerName" class="updateSubLedgerName">
    @csrf
    <div class="form-row">
        {{-- @dd($sub_ledger_type->getData()->data); --}}
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Sub Ledger Type<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select name="sub_ledger_type" id="sub_ledger_type" class="form-control form-control-sm selectSubLedgerName">
                        <option value="" disabled selected>Select One</option>
                        @foreach ($sub_ledger_type->getData()->data as $item)
                            @if($item->status == 1)
                            <option value="{{$item->acct_subledger_typeno_pk}}" {{ $item->acct_subledger_typeno_pk == $data->acct_subledger_typeno_fk ? 'selected' : '' }}>{{$item->subledgertype_name}} - {{$item->subledgertype_code}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="sub_ledger_tracking_no" class="col-sm-4 col-form-label">Tracking(Protfolio/Emp Code)</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="tracking_id"
                        name="tracking_id" value="{{$data->sub_ledger_tracking_no}}" placeholder="Tracking(Protfolio/Emp Code)"/>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Sub Ledger Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="sub_ledger_name"
                        name="sub_ledger_name" value="{{$data->subledger_name}}" placeholder="Sub Ledger Name"/>
                        <input type="hidden" value="{{$data->acct_subledger_no_pk}}" name="acct_subledger_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="" class="col-sm-4 col-form-label">Sub Ledger Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="sub_ledger_name_code" name="sub_ledger_name_code" value="{{$data->subledger_code}}" placeholder="Sub Ledger Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->notes}}" placeholder="Notes" cols="5" rows="5">{{$data->notes}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status"
                        name="status" value="1" @if($data->status == 1) {{'checked'}} @endif/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('v1.accounts.sub-ledger-name-setup');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',subLedgerNameFunc,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.selectSubLedgerName').select2();
        $("#updateSubLedgerName").validate({
            rules:{
                sub_ledger_type:{
                    required:true,
                },
                sub_ledger_name:{
                    required:true,
                    minlength:5,
                    maxlength:50,
                    notOnlySpaces: true
                },
                sub_ledger_name_code:{
                    required:true,
                    minlength:1,
                    maxlength:50,
                    notOnlySpaces: true
                },
                notes:{
                    maxlength:500,
                }
            },
            messages:{
                sub_ledger_type:{
                    required: "Sub Ledger Type Required"
                },
                sub_ledger_name:{
                    required: "Sub Ledger Name Required",
                },
                sub_ledger_name_code:{
                    required: "Sub Ledger Code Required"
                }
            }
        });

    });
</script>