<div class="row">
    <div class="col-md-4 col-lg-4 col-sm-4">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card mt-0 bg-none">
                    <div class="card-header">
                        <span id="favourit_list_title" data-append-to="">Favourite List</span>
                        <span class="loading-img"></span>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow:scroll;">
                        <div class="form-group mt-2">
                            <input type="search" class="form-control form-control-sm " id="favListSearch"
                                name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                                placeholder="Search Favourite Item">
                        </div>
                        <table class="table m-0">
                            <tbody id="pres-favourit-list-advice" class="pres-favourit-list" style="word-break: break-all;">
                                @include('admin.prescription.uhl.pres_favourit_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 col-lg-8 col-sm-8 mt-4">
        <div class="form-group">
            <label for="cmb_advice" class="col-form-label col-form-label-sm mb-1">Advice <a
                        class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                        data-action="{{ route('prescription-most-used-items-uhl', 'ADVICE') }}"
                        data-title="Most Used Advice" data-append-id="#adv"
                        onclick="prescriptionFunc.mosUsedIdPass(this)">MUA</a></label>
            <textarea name="advice" class="form-control mb-0" id="advice" cols="50" rows="5" onclick="prescriptionV2.loadToPresFavouritListV2(this,'ADVICE','Advice','#adv', '{{ $action_url }}', '#pres-favourit-list-advice')"
            data-lookup-id="{{ $lookup_id_arr->ADVICE }}" data-lookup-code="ADVICE"></textarea>
    
            <div class="card mt-0">
                <div class="card-body p-0">
                    @php
                        $class = !empty($ad_arr) ? ' border p-1' : '';
                    @endphp
                    <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="adv">
                        @if (!empty($ad_arr))
                            @foreach ($ad_arr as $rows)
                                @foreach ($rows as $row)
                                    @php
                                        $row_data = explode('_', $row);
                                    @endphp
                                    <li id="item-{{ $row_data[0] }}">
                                        <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}" readonly="readonly">
                                        <input class="left-element" type="text" style="width:90%" name="item_name[]" value="{{ $row_data[1] }}">
                                        <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}" readonly="readonly">
                                        <input type="hidden" name="lookup_code[]" value="ADVICE" readonly="readonly">
                                        <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}" readonly="readonly">
                                        <input type='hidden' name='unit_intensity[]'>
                                        <input type='hidden' name='session_duration[]'> 
                                        <input type='hidden' name='no_of_session[]'> 
                                        <input type='hidden' name='session_mu[]'>
                                        <input type='hidden' name='frequency[]'>
                                        <input type='hidden' name='mode[]'>
                                        <input type='hidden' name='in_m_duration[]'>
                                        <input type='hidden' name='in_m_repetition[]'>
                                        <input type='hidden' name='in_e_location[]'>
                                        <span class="float-right text-danger cursor-pointer"
                                            title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;
                                       
                                            @if ($row_data[0] != 0 || $row_data[1] != '' )
                                            <span class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}"
                                                data-id="{{ $row_data[0] }}" data-name="{{ $row_data[1] }}"
                                                data-type="ADVICE"><i class="fa fa-star text-primary"></i></span>
                                        @endif
                                    </li>
                                @endforeach
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
