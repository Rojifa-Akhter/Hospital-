<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-mum-tab" data-toggle="pill" href="#pills-mum" role="tab"
                            aria-controls="pills-mum" aria-selected="false" data-tab_type="0">Most Used</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-group-tab" data-toggle="pill" href="#pills-group"
                            role="tab" aria-controls="pills-group" aria-selected="true" data-tab_type="1">Group</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <!-- Most Used Tab -->
                    <div class="tab-pane fade" id="pills-mum" role="tabpanel" aria-labelledby="pills-mum-tab">
                        <div id="most_used_medicine">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Create
                                                @if ($type == 'INVFIND')
                                                    Investigation
                                                @elseif ($type == 'ADVICE')
                                                    Advice
                                                @endif
                                                List Group
                                            </h5>
                                            <form action="{{ route('prescription-group-item-save') }}" method="POST"
                                                id="group_form" class="ml-2">
                                                @csrf
                                                <div id="hidden_group_data" hidden></div>
                                                <input type="text" id="g_name" name="g_name"
                                                    placeholder="Enter Group Name" class="form-control" required>
                                                <input type="hidden" name="presType" id="presType"
                                                    value="{{ ucfirst($type) }}">
                                                <button type="submit" class="btn btn-outline-primary mt-2 float-right"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'')">
                                                    Set Group
                                                    @if ($type == 'INVFIND')
                                                        Investigation
                                                    @elseif ($type == 'ADVICE')
                                                        Advice
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Search</h5>
                                            <input type="text" class="form-control"
                                                placeholder="Enter @if ($type == 'INVFIND') Investigation  @elseif ($type == 'ADVICE') Advice @endif Item Name"
                                                onkeyup="searchMuiUhl(this)" data-input-id="{{ $type }}"
                                                data-row-id="">
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                    <div class="row" id="itemDataAll">
                                        @include('admin.prescription.uhl.most_used_item_all_data')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group Tab -->
                    <div class="tab-pane fade show active" id="pills-group" role="tabpanel"
                        aria-labelledby="pills-group-tab">
                        <div id="Group">
                            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                <div class="row" id="itemDataAll">
                                    @if (!empty($group_template_list))
                                        @foreach ($group_template_list as $record)
                                            @php
                                                $colClass = $type == 'ADVICE' ? 'col-md-6' : 'col-md-4';
                                            @endphp
                                            <div class="{{ $colClass }}" style="max-width: 90%; overflow: hidden;">
                                                <span
                                                    class="badge badge-success badge-md favourit_list_item cursor-pointer"
                                                    onclick="itemsDataMostUseUhlGroup(this)"
                                                    item-id="{{ $record->psn_template_no_pk }}"
                                                    template-name="{{ $record->template_name }}"
                                                    template-type="{{ $type }}">
                                                    {{ $record->template_name }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of tab-content -->
            </div> <!-- End of card-body -->
        </div> <!-- End of card -->
    </div> <!-- End of col-md-12 -->
</div> <!-- End of row -->


<script>
    function searchMuiUhl(thisElement) {
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
        var lookupDataUid = $(thisElement).attr('data-lookup-data-code');
        $.ajax({
            data: {
                searchDt: searchDt,
                lookupDataUid: lookupDataUid,
                dataType: dataType
            },
            url: "{{ url('prescription-group-item-save') }}",
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

    function itemsDataMostUseUhlGroup(thisElement) {
        var item_id = $(thisElement).attr('item-id');
        var template_name = $(thisElement).attr('template-name');
        var template_type = $(thisElement).attr('template-type');
        $.ajax({
            data: {
                item_id: item_id,
                template_name: template_name,
                template_type: template_type,
            },
            url: "{{ url('prescription-item-load-group-wise-uhl') }}",
            type: 'post',
            beforeSend: function() {
                // blockUI();
            },
            success: function(data) {
                console.log(data)
                $(data.data).each(function(key, value) {
                    console.log(value)
                    var lookup_data =
                        "<li id='item-" +
                        value.lookupdata_item_no_fk +
                        "'><input class='left-element' type='hidden' name='item_dtl_val[]' value=''><input class='left-element' type='hidden' name='item_id[]' value='" +
                        value.lookupdata_item_no_fk +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
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
