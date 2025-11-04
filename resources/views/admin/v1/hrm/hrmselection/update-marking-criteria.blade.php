<form action="{{ route('v1.hrm.save-marking-criteria') }}" id="marking-criteria-update-form" method="post">
    @csrf

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-5 col-xl-12">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <input type="hidden" class="form-control form-control-sm"
                                    id="hidden_markingcriteria_no_pk" name="hidden_markingcriteria_no_pk" placeholder=""
                                    value="{{ $update_data->markingcriteria_no_pk }}" />
                                {{-- @dd($update_data->markingcriteria_no_pk) --}}
                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="marking_sl" class="col-form-label">Marking SL</label>
                                        <input type="text" class="form-control form-control-sm" id="marking_sl"
                                            name="marking_sl" placeholder="" value="{{ $update_data->marking_sl }}"
                                            readonly />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="marking_creteria" class="col-form-label">Marking
                                            Creteria</label>
                                        <input type="text" class="form-control form-control-sm" id="marking_creteria"
                                            name="marking_creteria" placeholder=""
                                            value="{{ $update_data->marking_creteria }}" />
                                    </div>
                                </div>


                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="top_score" class="col-form-label">Top Score</label>
                                        <input type="text" class="form-control form-control-sm" id="top_score"
                                            name="top_score" placeholder="" value="{{ $update_data->top_score }}" />
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="passing_score" class="col-form-label">Passing Score</label>
                                        <input type="text" class="form-control form-control-sm" id="passing_score"
                                            name="passing_score" placeholder=""
                                            value="{{ $update_data->passing_score }}" />
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    @php
                                        $response_action = route('v1.hrm.marking-criteria');
                                    @endphp
                                    <button type="button" class="btn btn-success mt-4"
                                        onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                        id="">Save</button>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="col-md-12">
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
    </div>
</div>



{{-- <section id="create_Supplier_item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-5 col-xl-12">
                <form action="{{ route('v1.hrm.save-marking-criteria') }}" method="post" id="supplier-create">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="marking_sl" class="col-form-label">Marking SL</label>
                            <input type="text" class="form-control form-control-sm" id="marking_sl" name="marking_sl"
                                placeholder="" value="" />
                        </div>
                        <div class="col-md-4">
                            <label for="marking_creteria" class="col-form-label">Marking
                                Creteria</label>
                            <input type="text" class="form-control form-control-sm" id="marking_creteria"
                                name="marking_creteria" placeholder="" value="{{ $data->marking_creteria }}" />
                        </div>
                        <div class="col-md-4">
                            <label for="top_score" class="col-form-label">Top Score</label>
                            <input type="text" class="form-control form-control-sm" id="top_score" name="top_score"
                                placeholder="" value="{{ $data->top_score }}" />
                        </div>

                        <div class="col-md-4">
                            <label for="passing_score" class="col-form-label">Passing Score</label>
                            <input type="text" class="form-control form-control-sm" id="passing_score"
                                name="passing_score" placeholder="" value="{{ $data->passing_score }}" />
                        </div>
                    </div>

                    <div class="form-row border-top py-2">
                        @php
                            $response_action = route('v1.hrm.marking-criteria');
                        @endphp
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success btn-md"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                Save
                            </button>
                            <button type="reset" class="btn btn-danger btn-md" title="Click here to cancel data"
                                data-dismiss="modal">Cancel
                            </button>
                        </div>
                        <!-- <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> --}}
