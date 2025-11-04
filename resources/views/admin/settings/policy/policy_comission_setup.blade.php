<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_Policy">
    <form method="post" action="{{ route('policy.store-comission') }}" id="frmBilling" onsubmit="">
        <div class="container-fluid">
            <nav class="mt-3">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="{{ route('policy.index') }}" rel="tab" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-plus"></i> Add New Policy</a>

                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="{{ route('policy.comission') }}" rel="tab" role="tab" aria-controls="nav-home" aria-selected="true">Policy Commission Setup</a>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtPolicy" class="col-sm-2 col-form-label">Policy</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtPolicy" name="txtPolicy" placeholder="Write Policy Code / Policy Name" value="{{ $policy_name }}">
                                <input type="hidden" class="form-control" name="hdn_policy_id" id="hdn_policy_id" value="{{ $policy_id }}" >
                                <input type="hidden" class="form-control" name="hdn_policy_code" id="hdn_policy_code" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtItem" class="col-sm-2 col-form-label">Item</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control bg-light" id="item_name" name="item_name" autocomplete="off" placeholder="Write Item Code or Item Name here" />
                                <input type="hidden" class="form-control" name="hdn_item_id" id="hdn_item_id" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <label>Commission Setup</label>
                    <div class="border rounded mb-2 bg-light">

                        <div class="row">
                            <div class="col-sm border-right">
                                <div class="form-row">
                                    <div class="form-group col-md-12 pl-3">
                                        <label for="txtDoctor">Doctor</label>
                                        <input type="text" class="form-control" id="txtDoctor" name="txtDoctor" placeholder="">
                                        <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm border-right">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label>Doctor Commission</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Doctor Name" name="txtDocCommitsion" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label for="inputEmail4" class="text-center"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkDocSms" name="chkDocSms"> SMS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm border-right">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label for="inputEmail4">1st Ref. Commission</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            <input type="text" class="form-control" name="txtFirstRefCommitsion" aria-label="Commission" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label for="inputEmail4" class="text-center"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkFirstRefSms" name="chkFirstRefSms"> SMS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm border-right">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label for="inputEmail4">2nd Ref. Commission</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            <input type="text" class="form-control" name="txtSecondRefCommitsion" aria-label="Commission" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label for="inputEmail4" class="text-center"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkSecondRefSms" name="chkSecondRefSms"> SMS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label>Agent Commission</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            <input type="text" class="form-control" name="txtAgentComission" aria-label="Agent Commission" aria-describedby="basic-addon2">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label for="inputEmail4" class="text-center"></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkAgentRefSms" name="chkAgentRefSms"> SMS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-md btn-success" id="btnPolicyComission">Save</button>
                    <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                    <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                </div>
            </div>
            <div id="policy-details">
                @include('admin.settings.policy.policy_details')
            </div>
        </div>
    </form>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openPolicyAutocomplete('#txtPolicy', 'hdn_policy_id');
    openDoctorAutocomplete('#txtDoctor', 'hdn_doctor_id');

    $('#item_name').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        limit: 'Infinity',
        async: true,
        source: function (query, processSync, processAsync) {
            return $.ajax({
                url: "{{ route('get-item-name') }}",
                type: 'POST',
                data: {query: query},
                dataType: 'json',
                success: function (result) {
                    return processAsync(result);
                }
            });
        },
        display: 'item_name',
        templates: {
            suggestion: function(item){
                return  '<div id="user-selection" class="clearfix border-bottom">' +
                '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item.item_name+'</div></div>' ;
            }
        }

    }).bind("typeahead:selected", function(obj, item, name) {
        $("#hdn_item_id").val(item.item_id);
    });

    $(document).on("click","#btnPolicyComission", function(e){
        var hdn_policy_id = $("#hdn_policy_id").val();
        btnSaveUpdate($(this));
        //btnSaveUpdate($(this),'', '', '', '', policy_list, hdn_policy_id);
        e.stopImmediatePropagation();
        return;
    });

    function policy_list(hdn_policy_id)
    {
        var redirect_to = '{{ route("policy.comission", ":id") }}';
        redirect_to = redirect_to.replace(':id', hdn_policy_id);
        window.location.replace(redirect_to);
    }

</script>