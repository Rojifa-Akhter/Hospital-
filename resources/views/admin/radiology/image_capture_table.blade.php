<div class="col-md-12 table-responsive">
    <table id="datatable" class="table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Appointment Date</th>
                <th class="text-center" scope="col">Voucher No</th>
                <th class="text-center" scope="col">Invoice Date</th>
                <th class="text-center" scope="col">Prescription ID</th>
                <th class="text-center" scope="col">App. SN</th>
                <th class="text-left" scope="col">Patient Name</th>
                <th class="text-left" scope="col"> Investigation</th>
                <th class="text-center" scope="col">Room</th>
                <th class="text-center" scope="col">Captured</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                @if (!empty($radiologyAppointment))

                    @foreach ($radiologyAppointment as $rad_app)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td>
                <td> {{ $rad_app->invoice_code }} </td>
                <td>{{ date('d/m/Y', strtotime($rad_app->invoice_date)) }}</td>
                <td>{{ $rad_app->prescription_no_fk }}</td>
                <td>{{ $rad_app->img_app_sl_no }}</td>
                <td>{{ $rad_app->patient_name }}</td>
                <td>{{ $rad_app->serviceunit_name }}</td>
                <td>{{ $rad_app->room_name }}</td>
                <td class="text-center" id="icon_id">
                    @if ($rad_app->ic_image_capture_key_ind == 1)
                        <button type="button" id="checkBtn" class="btn btn-sm btn-success "><i
                                class="fas fa-check"></i></button>
                        @if ($image_capture)
                            <?php $i = 0; ?>
                            @foreach ($image_capture as $key => $value)
                                @if ($rad_app->radinvoicedtl_no_pk == $value->radinvoicedtl_no_pk)
                                    <?php $i+=1 ?>
                                @endif
                            @endforeach

                            <button class="btn btn-sm rounded-circle border-primary border btn-capture open-modal" data-id=""
                            data-action="{{ route('radiology.radiology-image-capture-popup', $rad_app->radinvoicedtl_no_pk) }}"
                            data-title="Radiology Image Capture" title="Radiology Appointment card"
                            data-modal="common-modal-sm"> <?php echo ($i); ?></button>

                        @endif
                    @endif
                </td>
                <td class="text-center">
                    @if ($rad_app->ic_image_capture_key_ind == 1)
                        <button type="button" id="UpdateImageData" disabled class="btn btn-sm btn-success btn-capture"
                            data-action="{{ route('radiology.update-image-apointment') }}"
                            data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Capture</button>


                    @else
                        <!-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{ route('radiology.update-image-apointment') }}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}" onclick="capture(this)">Capture</button> -->


                        <button class="btn btn-sm btn-success btn-capture open-modal" data-id=""
                            data-action="{{ route('radiology.radiology-image-capture-popup', $rad_app->radinvoicedtl_no_pk) }}"
                            data-title="Radiology Image Capture" title="Radiology Appointment card"
                            data-modal="common-modal-sm">Capture</button>

                    @endif
                    {{-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{route("radiology.update-image-apointment")}}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Capture</button> --}}
                </td>

            </tr>
            @endforeach
            @endif

            </tr>
        </tbody>
    </table>
</div>


<script>
    $(document).on('click','.open-modal', function(){
        $('.modal-dialog').addClass('modal-dialog-scrollable');

    })
    //      function capture(element){
    //      event.preventDefault();
    //      var action = $(element).attr("data-action");
    //      var invoice_dtl_id = $(element).attr("data-dtl-id");
    //      if ( confirm("Are You Sure ?")) {
    //         $.ajax({
    //             data: { invoice_dtl_id:invoice_dtl_id },
    //             url: action,
    //             type: "post",
    //             beforeSend:function(){
    //                 blockUI();
    //             },
    //             success: function (data) {

    //              var formID      = $("#frmSearch").attr("id");
    //              var formAction  = $("#frmSearch").attr("action");
    //              var formMethod  = $("#frmSearch").attr("method");
    //              $.ajax({
    //                 data: $('#'+formID).serialize(),
    //                 url: formAction,
    //                 type: formMethod,

    //                 success: function (data) {
    //                     $("#search-container").html(data);
    //                 },
    //                 complete:function(){
    //                     $.unblockUI();
    //                 }

    //             });
    //              if(data.title == 'Success')
    //              {

    //                $('.common-modal-notify').modal('show');
    //                $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
    //                $('.common-modal-notify .modal-title').html(data.title);
    //                $('.common-modal-notify .modal-body').html(data.msg);
    //            }



    //        },
    //        complete:function(){
    //         $.unblockUI();
    //     }
    // });
    //     }
    //     event.stopImmediatePropagation();
    // };

    // function CaptureFunction() {

    //     confirm("Are You Sure ?");
    // }
</script>
