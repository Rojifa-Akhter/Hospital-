<div class="col-sm-12 col-lg-8 col-xl-8" id="patient-radiology-container">
    @include('admin.radiology.radiology_search_data')
</div>
<div class="col-sm-12 col-lg-4 col-xl-4">
    <div class="card">
        <div class="card-header">Add to Queue</div>
        <div class="card-body">
            {{-- <form action="{{route('radiology.save-radiology-appointment')}}" id="formdata" method="POST"> --}}
                <form action="{{ route('radiology.save-radiology-appointment') }}" id="formdata" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="inv_voucher_no" name="inv_voucher_no" value="" />
                    <div class="row">
                        <div class="col-md-12 justify-content-center">
                            <div class="form-group ">

                                <label for="radio_room_no" class="col-form-label col-form-label-sm">Room <span
                                    class="text-danger"> *</span></label>
                                    <select class="form-control form-control-sm select2 room_ddl required" name="radio_room_no"
                                    id="search_data" required='required'>
                                    <option value="" id="search_data">Select Room</option>
                                    @if (isset($rooms))
                                    @foreach ($rooms as $record)
                                    <option value="{{ $record->room_no_pk }}">{{ $record->room_name }}</option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="radio_priority" class="col-form-label col-form-label-sm">Priority</label>
                                <select class="form-control form-control-sm select2 " id="radio_priority"
                                name="radio_priority">
                                <option value="0">Select Priority</option>
                                {{-- <option value="1">Priority-1</option>
                                <option value="2">Priority-2</option> --}}
                                @if (isset($priority))
                                @foreach ($priority as $key => $value)
                                <option value="{{ $key }}" @if ($priority == $key) selected @endif>
                                {{ $value }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="radio_appointment_date" class="col-form-label col-form-label-sm">Appointment
                                Date <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-sm date_picker required"
                                id="radio_appointment_date" name="radio_appointment_date" value="{{ date('d-m-Y') }}"
                                readonly="readonly" placeholder="Appointment Date">
                            </div>

                            <div class="form-group">
                                <label for="radio_delivery_date" class="col-form-label col-form-label-sm">Delivery
                                Date</label>
                                <input type="text" class="form-control form-control-sm date_picker" id="radio_delivery_date"
                                name="radio_delivery_date" value="{{ date('d-m-Y') }}" readonly="readonly"
                                placeholder="Delivery Date">
                            </div>
                            <div class="queue_button mt-3">
                                @php

                                $app_id="";
                                $response_action = route('radiology-appointment-card',$app_id);
                                @endphp
                                 <button class="btn btn-success btn-md uhl_save_btn" type="button"
                                onclick="btnSaveUpdate(this , 'afterSaveModal', '{{$response_action}}', 'common-modal-sm', 'Rediology Appointment Card', searchRadiologyInfoByVouchar)"
                               >

                                Save
                            </button>
                            <a href="" type="reset" class="btn btn-danger btn-md"
                            title="Click here to Clear form data">Cancel</a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        var date = new Date();
        date.setDate(date.getDate());

        $('.date_picker').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        $("#invoice_code").focus();
        $('.select2').select2();
    });



    function get_add_que(element) {
        var value = $(element).attr('data-s_id');
        $('#inv_voucher_no').val($(element).attr('data-p_id'));
        console.log(value);


        $.ajax({
            url: "{{ route('radiology.get-room') }}",
            type: 'post',
            data: {
                id: value,
            },
            success: function(data) {
                $('#search_data').html(data);
            },
            error: function() {
                alert('No Room Found .');
            }
        });
    }

</script>
