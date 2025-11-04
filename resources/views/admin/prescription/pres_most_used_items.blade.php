<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0px !important;">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-mum-tab" data-toggle="pill" href="#pills-mum" role="tab"
                            aria-controls="pills-mum" aria-selected="true" data-tab_type="0"
                            onclick="changeTab(this)">Most Used</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab"
                            aria-controls="pills-group" aria-selected="false" data-tab_type="1"
                            onclick="changeTab(this)">Group</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-mum" role="tabpanel"
                            aria-labelledby="pills-mum-tab">
                            <div class="" id="most_used_medicine">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Create @if ($type == 'INVFIND')
                                                        {{ 'Investigation' }}
                                                    @elseif ($type == 'ADVICE')
                                                        {{ 'Advice' }}
                                                    @endif List Group
                                                </h5>
                                                <form action="{{ route('prescription-group-item-save') }}"
                                                    method="POST" id="group_form" style="margin-left: 14px;">
                                                    @csrf


                                                    <div id="hidden_group_data" hidden>

                                                    </div>
                                                    <input type="text" id="g_name" name="g_name"
                                                        placeholder="Enter Group Name" class="form-control" required>
                                                    <input type="hidden" name="presType" id="presType"
                                                        value="{{ ucfirst($type) }}">

                                                    <button type="submit" class="btn btn-md btn-outline-primary mt-2 float-right"
                                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'')">Set
                                                        Group @if ($type == 'INVFIND')
                                                            {{ 'Investigation' }}
                                                        @elseif ($type == 'ADVICE')
                                                            {{ 'Advice' }}
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Search
                                            </h5>
                                                <input type="text" class="float-right form-control" name=""
                                                    id=""
                                                    placeholder="Enter @if ($type == 'INVFIND') {{ 'Investigation' }} @elseif  ($type == 'ADVICE')
                                                    {{ 'Advice' }} @endif Item Name"
                                                    onkeyup="searchMUI(this)" data-input-id="{{ $type }}"
                                                    data-row-id="">

                                            </div>


                                        </div>

                                    </div>

                                    {{-- {{ dd($item_list) }} --}}
                                    <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                        <div class="row" id="itemDataAll">
                                            @include('admin.prescription.most_used_item_data_all')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                            <div class="" id="Group">
                                <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                    <div class="row" id="itemDataAll">
                                        @if (!empty($group_template_list))
                                            @foreach ($group_template_list as $record)
                                                @if ($type == 'ADVICE')
                                                    <div class="col-md-6" style="max-width: 90%;overflow:hidden;">
                                                    @else
                                                        <div class="col-md-4" style="max-width: 90%;overflow:hidden;">
                                                @endif

                                                <span
                                                    class="badge badge-success badge-md favourit_list_item cursor-pointer"
                                                    onclick="mostUsedItemsLoadUhl(this)"
                                                    item-id='{{ $record->psn_template_no_pk }}'
                                                    template-name='{{ $record->template_name }}'
                                                    template-type='{{ $type }}'>{{ $record->template_name }}
                                                </span>

                                    </div>
                                    @endforeach
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>







                    {{-- <div class="card">
                        <div class="card-header">
                            <h4>R<sub>x</sub></h4>
                        </div> --}}

                    {{-- <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table border-0 mt-2 mb-0">
                                        <thead>
                                            <tr class="border-0">
                                                <th class="p-0 border-0 w-35" colspan="3">Medicine</th>
                                                <th class="p-0 px-1 border-0 w-12">Dose</th>
                                                <th class="p-0 px-1 border-0 w-12">Route</th>
                                                <th class="p-0 px-1 border-0">Instruction</th>
                                                <th class="p-0 px-1 border-0 w-20">Duration</th>
                                                <th class="p-0 px-1 border-0">Continue</th>
                                                <th class="p-0 px-1 border-0"></th>
                                            </tr>
                                        </thead> --}}
                    {{-- <tbody id="presMedicineData">

                                        </tbody> --}}
                    {{-- </table> --}}

                    {{-- <div class="modal-footer mt-1">
                                        <div class="col-md-12 mt-4">
                                            <button type="submit" class="btn btn-md btn-success float-right"
                                                onclick="setMedicine(this)">Set
                                                Medicine</button>
                                        </div>
                                    </div> --}}
                    {{-- </div>
                            </div>
                        </div> --}}

                    {{-- </div> --}}
                </div>

            </div>
        </div>
    </div>

    <script>
        function searchMUI(thisElement) {
            var searchDt = $(thisElement).val();
            var dataType = $(thisElement).attr('data-input-id');
            $.ajax({
                data: {
                    searchDt: searchDt,
                    dataType: dataType
                },
                url: "{{ url('prescription-mum-search-data-all') }}",
                type: 'post',
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    $("#itemDataAll").html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        }


        function setGroupItms(thisElement) {
            var searchDt = $(thisElement).val();
            var dataType = $(thisElement).attr('data-input-id');
            $.ajax({
                data: {
                    searchDt: searchDt,
                    dataType: dataType
                },
                url: "{{ url('prescription-mum-search-data-all') }}",
                type: 'post',
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    $("#itemDataAll").html(data);
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        }

        function mostUsedItemsLoadUhl(thisElement) {
            var item_id = $(thisElement).attr('item-id');
            var template_name = $(thisElement).attr('template-name');
            var template_type = $(thisElement).attr('template-type');
            $.ajax({
                data: {
                    item_id: item_id,
                    template_name: template_name,
                    template_type: template_type,
                },
                url: "{{ url('prescription-item-load-group-wise') }}",
                type: 'post',
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    $(data.data).each(function(key, value) {
                        console.log(value)
                        var lookup_data =
                            "<li id='item-" +
                            value.lookupdata_item_no_fk +
                            "'><input class='left-element' type='hidden' name='item_dtl_val[]' value=''><input class='left-element' type='hidden' name='item_id[]' value='" +
                            value.lookupdata_item_no_fk +
                            "' readonly='readonly'><input class='left-element' style='width:90%' type='text'  name='item_name[]' value='" +
                            value.item +
                            "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='ADVICE' readonly='readonly'><input type='hidden' name='lookup_code[]' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                            value.lookupdata_uid +
                            "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'><input type='hidden' class='' id='' name='frequency[]'><input type='hidden' class='' id='' name='mode[]'><i class='fa fa-angle-double-right'></i> " +
                            value.item +
                            "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' data-id='" +
                            value.lookupdata_item_no_fk +
                            "' data-name='" +
                            value.item +
                            "'><i class='fa fa-star'></i></span></li>";
                        if (value.type == 'ADVICE') {
                            $('#adv').append(lookup_data);
                        } else {
                            $('#investigation').append(lookup_data);
                        }

                    });
                },
                complete: function() {
                    // $.unblockUI();
                }
            });
        }
    </script>
