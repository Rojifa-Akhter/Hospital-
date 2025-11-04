@php

    $item_info = (isset($item_info) && (!empty($item_info))) ? $item_info : [];
    $item_no_pk = ($item_info) ? $item_info->item_no_pk : '';
    $item_code = ($item_info) ? $item_info->item_code : '';
    $test_short_name = ($item_info) ? $item_info->item_short_name : '';
    $item_name = ($item_info) ? $item_info->item_name : '';
    $su_name = ($item_info) ? $item_info->serviceunit_no_fk : '';
    $sales_price = ($item_info) ? $item_info->sales_price : '';
    $normal_delivery_hour = ($item_info) ? $item_info->normal_delivery_hour : '';
    $urgent_delivery_hour = ($item_info) ? $item_info->urgent_delivery_hour : '';
    $no_of_label = ($item_info) ? $item_info->no_of_label : '';
    $testbygender_ind = ($item_info) ? $item_info->testbygender_ind : '';
    $sc_min_volume = ($item_info) ? $item_info->sc_min_volume : '';
    $report_group = ($item_info) ? $item_info->report_group : '';
    $default_analyzer_no_fk = ($item_info) ? $item_info->default_analyzer_no_fk : '';
    $sam_no_fk = ($item_info) ? $item_info->sam_no_fk : '';
    $container = ($item_info) ? $item_info->con_no_fk : '';
    $report_header = ($item_info) ? $item_info->report_header : '';
    $test_temp_no_fk = ($item_info) ? $item_info->test_temp_no_fk : '';
     $sc_instructions = ($item_info) ? $item_info->sc_instructions : '';
    $test_method = ($item_info) ? $item_info->test_method : '';
    $note = ($item_info) ? $item_info->note_text : '';
    $interpretation = ($item_info) ? $item_info->interpretation : '';
    $comments_txt = ($item_info) ? $item_info->comments_text : '';
    $plain_text = ($item_info) ? $item_info->plain_text : '';
    $status = ($item_info) ? $item_info->status : '';
    $active_stat = ($item_info) ? $item_info->active_stat : '';
@endphp

<form action="{{route('pathology-item-setup-store')}}" method="post" id="exam-setup-create">@csrf
    <div class="card">
        <div class="card-header"><h5>Exam Setup</h5></div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="exam_setup_item_id">Item
                            Id <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="exam_setup_item_id"
                                   name="exam_setup_item_id" value="{{$item_code}}" required placeholder="Item Id">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="exam_active" name="exam_active"
                                           title="Active"  value="1" {{$active_stat == 1 ? 'checked' : ''}} >
                                    <input type="hidden" name="id" value="{{ $item_no_pk}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="exam_short_name">Exam Short
                            Name</label>
                        <input type="text" class="form-control form-control-sm m-0" id="exam_short_name"
                               name="exam_short_name" value="{{ $test_short_name}}" placeholder="Exam Short Name"/>
                    </div>

                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="exam_item_name">Item
                            Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm m-0" id="exam_item_name"
                               name="exam_item_name" value="{{ $item_name}}" required placeholder="Item Name"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exam_setup_department"
                               class="col-form-label col-form-label-sm">Department <span
                                class="text-danger">*</span></label>
                        <select class="form-control select2" id="exam_setup_department"
                                name="exam_setup_department">
                            <option value="0">Select Department</option>
                            @if(!empty($pathology))

                                @foreach($pathology as $key=> $value)
                                    <option value="{{$key}}" {{$key == $su_name ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="exam_rate">Rate</label>
                        <input type="text" class="form-control form-control-sm m-0 text-right number_only"
                               id="exam_rate"
                               name="exam_rate" value="{{ $sales_price}}" placeholder="0.00" autocomplete="off"/>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body pt-2">
            <div class="form-row">
                <div class="col-md-8">
                    <div class="form-row">
                        <div class="col-md-6">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="normal_delivery_time"
                                               class="col-form-label col-form-label-sm">Normal Deli.
                                            Time</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control number_only"
                                                   id="normal_delivery_time"
                                                   name="normal_delivery_time" value="{{ $normal_delivery_hour}}"
                                                   placeholder="HH" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Hour</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="urgent_delivery_time"
                                               class="col-form-label col-form-label-sm">Urgent Deli.
                                            Time</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control number_only"
                                                   id="urgent_delivery_time"
                                                   name="urgent_delivery_time" value="{{ $urgent_delivery_hour}}"
                                                   placeholder="HH" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Hour</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exam_by_gender" class="col-form-label col-form-label-sm">Exam by
                                    Gender</label>
                                <select class="form-control select2" id="exam_by_gender" name="exam_by_gender">
                                    <option value="">Select Gender</option>
                                    @if(!empty($gender))
                                        @foreach($gender as $key=> $value)
                                            <option value="{{$key}}" {{$key == $testbygender_ind ? 'selected' : ''}} >
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="report_group" class="col-form-label col-form-label-sm">Report
                                    Group</label>
                                <div class="d-block">
                                    <div
                                        class="custom-control custom-radio custom-control-inline text-center">
                                        <input type="radio" id="report_group_single"
                                               name="exam_setup_report_group" class="custom-control-input"
                                               value="1" {{ $report_group==1 ? 'checked' : 'checked' }} >
                                        <label class="custom-control-label"
                                               for="report_group_single">Single</label>
                                    </div>

                                    <div
                                        class="custom-control custom-radio custom-control-inline text-center">
                                        <input type="radio" id="report_group_group"
                                               name="exam_setup_report_group" class="custom-control-input"
                                               value="2" {{$report_group==2 ? 'checked' : ''}} >
                                        <label class="custom-control-label"
                                               for="report_group_group">Group</label>
                                    </div>

                                    <div
                                        class="custom-control custom-radio custom-control-inline text-center">
                                        <input type="radio" id="report_group_null"
                                               name="exam_setup_report_group" class="custom-control-input"
                                               value="3" {{$report_group==3 ? 'checked' : ''}} >
                                        <label class="custom-control-label"
                                               for="report_group_null">Null</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="report_group" class="col-form-label col-form-label-sm">
                                    Status</label>
                                <div class="d-block">
                                    <div
                                        class="custom-control custom-radio custom-control-inline text-center">
                                        <input type="radio" id="exam_setup_status_active"
                                               name="exam_setup_status" class="custom-control-input"
                                               value="1" {{$status==1 ? 'checked' : 'checked'}} checked>
                                        <label class="custom-control-label"
                                               for="exam_setup_status_active">Active</label>
                                    </div>

                                    <div
                                        class="custom-control custom-radio custom-control-inline text-center">
                                        <input type="radio" id="exam_setup_status_inactive"
                                               name="exam_setup_status"
                                               class="custom-control-input" value="3" {{$status==3 ? 'checked' : ''}}>
                                        <label class="custom-control-label"
                                               for="exam_setup_status_inactive" >Inactive</label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_setup_sample"
                                               class="col-form-label col-form-label-sm">Sample</label>
                                        <select class="form-control select2" id="exam_setup_sample"
                                                name="exam_setup_sample">
                                            <option value="0">Select Sample</option>
                                            @if(!empty($labs_sample))

                                                @foreach($labs_sample as $sample)
                                                    <option
                                                        value="{{$sample->sam_no_pk}}" {{$sample->sam_no_pk == $sam_no_fk ? 'selected' : ''}}>
                                                        {{$sample->sam_name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_setup_container"
                                               class="col-form-label col-form-label-sm">Container</label>
                                        <select class="form-control select2" id="exam_setup_container"
                                                name="exam_setup_container">
                                            <option value="0">Select Container</option>
                                            @if(!empty($container_ind))
                                                @foreach($container_ind as $sample)
                                                    <option
                                                        value="{{$sample->item_no_pk}}" {{$sample->item_no_pk == $container ? 'selected' : ''}}>
                                                        {{$sample->item_name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_of_label" class="col-form-label col-form-label-sm">No of
                                    Label</label>
                                <input type="text" class="form-control number_only" id="no_of_label" name="no_of_label"
                                       value="{{$no_of_label}}" placeholder="No of Label" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="minimum_collection_volume"
                                       class="col-form-label col-form-label-sm">Minimum
                                    Collection Volume</label>
                                <input type="text" class="form-control number_only" id="minimum_collection_volume"
                                       name="minimum_collection_volume" value="{{ $sc_min_volume}}"
                                       placeholder="Minimum Collection Volume" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="default_analyzer" class="col-form-label col-form-label-sm">Default
                                    Analyzer</label>
                                <select class="form-control" id="default_analyzer" name="default_analyzer">
                                    <option value="">Select Default Analyzer</option>
                                    @if(!empty($default_analyzer))
                                        @foreach($default_analyzer as $def_analyzer)
                                            <option
                                                value="{{$def_analyzer->item_no_pk}}" {{$def_analyzer->item_no_pk == $default_analyzer_no_fk ? 'selected' : ''}}>
                                                {{$def_analyzer->item_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="report_header" class="col-form-label col-form-label-sm">Report
                                            Header</label>
                                        <input type="text" class="form-control" id="report_header"
                                               name="report_header" value="{{$report_header}}"
                                               placeholder="Report Header">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_template"
                                               class="col-form-label col-form-label-sm">Template</label>
                                        <select class="form-control" id="exam_template"
                                                name="exam_template">
                                            <option value="0">Select Template</option>
                                            @if(!empty($labs_testtemplate))

                                                @foreach($labs_testtemplate as $lab_temp)
                                                    <option
                                                        value="{{$lab_temp->test_temp_no_pk}}" {{$lab_temp->test_temp_no_pk == $test_temp_no_fk ? 'selected' : ''}}>
                                                        {{$lab_temp->temp_name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-row row align-items-end">
                                <div class="col-md-12 mt-auto">
                                    <div class="border p-1 text-right">
                                        @php
                                            $response_action = route('item.pathology-item-setup');
                                        @endphp
                                        <button class="btn btn-success btn-md"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                            Save
                                        </button>

                                        <a href="{{route('item.pathology-item-setup')}}" type="button"
                                           class="btn btn-md btn-danger">Reset</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm"
                                       for="sample_collection_instructions">Sample Collection
                                    Instructions</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1"
                                          id="sample_collection_instructions"
                                          name="sample_collection_instructions" value=""
                                          placeholder="Sample Collection Instructions"
                                          rows="1">{{ $sc_instructions}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="item_method">Item
                                    Method</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1"
                                          id="item_method"
                                          name="item_method" value="" placeholder="Item Method"
                                          rows="1">{{$test_method}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="notes">Notes</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1" id="notes"
                                          name="notes" value="" placeholder="Notes" rows="1">{{ $note}}</textarea>
                            </div>
            
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm"
                                       for="interpretation">Interpretation</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1"
                                          id="interpretation"
                                          name="interpretation" value="" placeholder="Interpretation"
                                          rows="1">{{ $interpretation}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm"
                                       for="comments">Comments</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1" id="comments"
                                          name="comments" value="" placeholder="Comments"
                                          rows="1">{{ $comments_txt}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="other_plain_text">Other/Plain
                                    Text</label>
                                <textarea class="form-control form-control-sm m-0 pt-1 pb-1"
                                          id="other_plain_text" name="other_plain_text" value=""
                                          placeholder="Other/Plain Text" rows="1">{{ $plain_text}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
