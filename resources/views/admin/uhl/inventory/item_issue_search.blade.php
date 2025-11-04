<form action="{{ route('v1.search-indent-issue-list') }}" method="post"
id="indent-issue-list">
@csrf
<div class="card">
    <div class="card-body p-2">

        <div class="form-row">
            <div class="col-lg-3 col-md-3 col-12">
                <div class="form-group form-row">
                    <label for="requsion_no"
                        class="col-sm-4 col-form-label">Indent No</label>
                    <div class="col-sm-8">
                        <input type="text"
                            class="form-control form-control-sm"
                            id="requsion_no" name="requsion_no"
                            placeholder="" />
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-12">
                <div class="form-group form-row">
                    <label for="requsion_no"
                        class="col-sm-4 col-form-label">From Department</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm select2"
                            name="subtore" id="subtore">
                            <option value="">Select</option>
                            @if (!empty($sub_store_list))
                                @foreach ($sub_store_list as $substore)
                                    <option
                                        value="{{ $substore->serviceunit_no_pk }}">
                                        {{ $substore->serviceunit_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            @if (!empty($main_store_list))
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="form-group form-row">
                        <label for="mainStore"
                            class="col-sm-4 col-form-label">To Department</label>
                        <div class="col-sm-8">
                            <select class="form-control form-control-sm select2"
                                name="mainStore" id="mainStore">
                                <option value="">Select</option>
                            
                                    @foreach ($main_store_list as $mainstore)
                                        <option
                                            value="{{ $mainstore->serviceunit_no_pk }}">
                                            {{ $mainstore->serviceunit_name }}
                                        </option>
                                    @endforeach
                            
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="form-group form-row">
                    <label class="col-form-label col-form-label-sm col-sm-3"
                        for="indent_date_from">Indent Date</label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text"
                                class="form-control form-control-sm m-0"
                                id="indent_date_from" name="indent_date_from"
                                value="" placeholder="dd-mm-yyyy" />
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text"
                                class="form-control form-control-sm m-0"
                                id="indent_date_to" name="indent_date_to"
                                value="" placeholder="dd-mm-yyyy" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                <div class="btn-group btn-block" role="group">
                    <button type="button"
                        class="btn btn-success search_indent" onclick="searchData()"><i
                            class="fa fa-search"></i> Search</button>
                    <button type="reset" id="reset" class="btn btn-info"><i
                            class="fa fa-redo"></i> Reset</button>
                </div>
            </div>
        </div>

    </div>
</div>
</form>