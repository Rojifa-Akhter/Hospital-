
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="container-fluid">
    <form id="searchForm" action="{{ route('ipd.save-blood-collection-form') }}" method="post">
        <input type="hidden" class="" id="donor_no_fk" name="donor_no_fk" value="{{isset($donor_id) ? $donor_id :''}}">
        <input type="hidden" class="" id="admission_no" name="admission_no" value="{{isset($admission_no) ? $admission_no :''}}">
        <input type="hidden" class="" id="blood_collection_no" name="blood_collection_no" value="{{!empty($collection_data) ? $collection_data->blood_col_no_pk :'' }}">
        <input type="hidden" class="" id="requsition_no" name="requsition_no" value="{{!empty($requsition_no) ? $requsition_no :'' }}">
        <?php
            $formatted_date = date('d-m-Y', strtotime($admission_date)); //
        ?>
        @csrf
        <input type="hidden" name="bag_no" id="bag_no" value="{{@$donor_id}}">
        <div class="form-row">
            <div class="col-md-12 col-sm-12 mb-2">
                <div class="form-row">
                    <div class="col-md-4"><strong>Blood Group <span class="text-danger">*</span></strong></div>
                    <div class="col-md-8">
                        <select name="blood_group" class="form-control" id="blood_group">
                            @if(!empty($bloodg))
                                @foreach($bloodg as $value)
                                    @if(isset($blood_group) && $value == $blood_group) 
                                        <option value="{{$value}}" selected>{{$value}}</option>
                                    @endif
                                @endforeach
                            @endif
                           
                        </select> 
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12 col-sm-12 mb-2">
                <div class="form-row">
                    <div class="col-md-4"><strong>Collected Date <span class="text-danger">*</span></strong></div>
                    <div class="col-md-8"> <input type="text" class="form-control form-control-sm  date-picker" id="collected_date" name="collected_date" autocomplete="off" value="{{!empty($collection_data) && $collection_data->blood_col_date  !='' ? date('d-m-Y',strtotime($collection_data->blood_col_date)) :'' }}" placeholder="dd-mm-yyyy" required></div>
                </div>
            </div> --}}

            {{-- <div class="col-md-12 col-sm-12 mb-2">
                <div class="form-row">
                    <div class="col-md-4"><strong>Bag Number <span class="text-danger">*</span></strong></div>
                    <div class="col-md-8"> <input type="text" class="form-control" id="bag_no" name="bag_no" value="{{!empty($collection_data) ? $collection_data->bag_no :'' }}" autocomplete="off" required></div>
                </div>
            </div> --}}
            <div class="col-md-12 col-sm-12 mb-2">
                <div class="form-row">
                    <div class="col-md-4"><strong>Remarks</strong></div>
                    <div class="col-md-8"><textarea name="remarks" id="remarks" class="form-control" rows="3" autocomplete="off">{{!empty($collection_data) ? $collection_data->remarks :'' }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-footer">
                <div class=" text-right">
                    @php
                    $url=route('ipd.blood-collection-worklist');
                    @endphp
                    <button type="submit" class="btn btn-success btn-md btn-md-global uhl_common_btn" 
                    {{-- onclick="save(this)" --}}
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">Collect</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    var admissionDate = '<?php echo $formatted_date; ?>';
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        startDate: admissionDate // disables all previous dates
    });

    function save(element) {
       
        btnSaveUpdate(element,'','','','', click_dearch);
        // btnSaveUpdate(form_url,'','','','', dynamicFunc.afterSaveLoadPage,'{{$url}}')
    }

    function click_dearch(){
        $('#btnSearch').click();
    }
</script>