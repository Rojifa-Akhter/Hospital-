<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    {{-- <div class="form-group row">
        <div class="col-md-12">
            <label for="item_name" class="">Alternative Item</label>
            <div class="">
                <select class="form-control font_size_12 m-auto select2" id="item_name" name="item_name"
                    onchange="setALternativeMed(this)" data-id="{{$data_row_id}}">
                    <option selected="selected" data-price="0" value="" >Select Alternative Item</option>
                    @foreach ($item_list as $record)
                        <option value="{{ $record->item_no_pk }}">{{ $record->item_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> --}}
    <div class="form-row">
        <div class="card mt-0">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Alternative Item </h5>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="float-right form-control" name="" id=""
                            placeholder="Enter Supplier Name" onkeyup="searchAltItem(this)" data-input-id="{{ $genetic_name }}" data-row-id="{{ $data_row_id }}">
                    </div>
                </div>

            </div>
            <div class="row" id="altData">
                @include('admin.prescription.alternative_medicine_data')

            </div>
        </div>
    </div>
</div>



<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});

    function setALternativeMed(element) {

        const id = $(element).attr('data-id');
        const med_id = $(element).attr('data-alt-id');
        // const med_id = $(element).val();
        const med_item = $(element).attr('data-alt-name');
        // const med_item = $(element).find(":selected").text()
        console.log(med_id, med_item, id)
        $('#tr_id_' + id).find('td:first-child').find('#hdn_medicine_item_id_' + id).val(med_id);
        $('#tr_id_' + id).find('td:first-child').find('#hdn_report_serial_med_' + id).val(id);
        $('#tr_id_' + id).find('td:first-child').find('#medicine_item_' + id).val(med_item);
        $('#tr_id_' + id).find('td:first-child').find('#hdn_medicine_item_id_' + id).attr('name',
            'hdn_medicine_item_id[]');
        $('.exampleModal ').modal('hide');
    }

    function searchAltItem(thisElement) {
        console.log($(thisElement).val())
        var searchDt = $(thisElement).val();
        var gen_name = $(thisElement).attr('data-input-id');
        var data_row_id = $(thisElement).attr('data-input-id');
        console.log(gen_name)
        $.ajax({
            data: {
                searchDt: searchDt,gen_name:gen_name,data_row_id:data_row_id
            },
            url: "{{ url('prescription-alt-search-data') }}",
            type: 'post',
            beforeSend: function() {
                // blockUI();
            },
            success: function(data) {
                $("#altData").html(data);
            },
            complete: function() {
                // $.unblockUI();
            }
        });
    }
</script>
