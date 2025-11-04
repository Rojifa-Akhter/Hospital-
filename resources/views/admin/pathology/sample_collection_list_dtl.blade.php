
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="w-2">#SL</th>
                    <th class="w-8">Invoice No</th>
                    {{-- <th class="w-8">Lab No</th> --}}
                    <th class="w-8">Sample ID</th>
                    <th class="w-10" style="text-align: left">IP Info / Admission Info</th>
                    <th class="w-10" style="text-align: left">{{ $type == 'collected' ? 'Collection Time' : 'Invoice Date' }}</th>
                    <th class="w-10" style="text-align: left">UHID</th>
                    <th class="w-10" style="text-align: left">Patient Info</th>
                    <th class="w-10" style="text-align: left">Referred Doctor</th>
                    <th class="w-15" style="text-align: left">Service Name</th>
                    <th class="w-10" style="text-align: left">Department Name</th>
                    <th class="w-5" style="text-align: left">Sample</th>
                    <th class="w-5" style="text-align: left">Container</th>
                    @if($type == 'collect')
                    <th class="w-2"> <input type="checkbox" id="selectAll" /></th>
                    @endif
                    <th class="w-20"></th>
                </tr>
            </thead>
                {{-- {{ dd($sample_collection_arr) }} --}}
            <tbody id="collection_data">
                @php
                $lab_no='';
                // $bg_color='';
                @endphp
                @if(!empty($sample_collection_arr))
                @foreach ($sample_collection_arr as $sample_row)
                @php
                $lab_no .= $sample_row->lab_no_pk.'_' ;
                $bg_color=strpos($sample_row->delivery_status_lookup_no_fk ,'2')  === false ? '' : 'bg-warning';
                @endphp
                <tr class="<?= $bg_color ?>">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sample_row->invoice_code }}</td>

                    <td>{{ $sample_row->lab_code }}</td>
                    <td class="w-10">
                        @if (isset($sample_row->admission_no_pk) && $sample_row->admission_no_pk)
                        <b>Admission ID&nbsp;:</b> {{isset( $sample_row->admission_no_pk) ?  $sample_row->admission_no_pk:'' }} <br>
                        <b>Bed&nbsp;:</b> {{isset( $sample_row->new_bed_name) ?  $sample_row->new_bed_name:'' }} <br>
                        <b>Ward&nbsp;:</b> {{isset($sample_row->new_ward_name) ?  $sample_row->new_ward_name :''}} <br>
                        <b>Dept&nbsp;:</b> {{isset($sample_row->new_su_name )? $sample_row->new_su_name:'' }}
                        @endif
                    </td>
                    <td>
                        <?php
                        $collection_time = $sample_row->sc_sample_coll_keyed_time != '' ? date('d/m/Y h:i:s a', strtotime($sample_row->sc_sample_coll_keyed_time)) : '';
                        $invoice_datetime = $sample_row->invoice_datetime != '' ? date('d/m/Y h:i:s a', strtotime($sample_row->invoice_datetime)) : '';
                        ?>
                        {{ $type == 'collected' ? $collection_time : $invoice_datetime }}
                    </td>
                    <td>{{ $sample_row->patient_code }} </td>
                    <td>{{ $sample_row->patient_name }} <br> Age: {{ $sample_row->age }}</td>
                    <td>{{ $sample_row->referred_doctor }}</td>
                    <td>{{ $sample_row->test_name_list }}</td>
                    <td>{{ $sample_row->serviceunit_name }}</td>
                    <td>{{ $sample_row->sam_name }}</td>
                    <td>{{ $sample_row->container_item_name }}</td>
                    @if ($type == 'collect')
                    <td class="text-center">
                        <input class="chk_sample" type="checkbox" id="chk_sample_{{$sample_row->lab_no_pk}}" name="chk_sample[]" value="{{ $sample_row->lab_no_pk }}" onchange="pathologyFunc.selectSampleCheckbox(this);uncheckedItem(this)" checked="checked">
                    </td>
                    @endif
                    <td class="w-20">
                        @if ($type == 'pending')
                        <a href="{{ route('path.sample-collection-collect') }}" data-pres="{{ $sample_row->invoice_code }}" onclick="pathologyFunc.collectPendingSamples(this)" class="btn btn-sm btn-primary" title="Print">Collect</a>
                        @else
                        @if(Session::get('user.ses_hospital_code')=="UNICO")
                        @php
                            $backGroundColor=$sample_row->label_print_ind == 1 ?'background-color: Magenta;':'background-color:#3490dc;';
                            $backGroundColorAux=$sample_row->print_type == 'AUX' ?'background-color: Magenta;':'background-color:#3490dc;';
                            $text=$sample_row->label_print_ind == 1 ?'Printed':'Print';
                        @endphp
                        <span class="btn btn-sm " style="<?= $backGroundColor ?>" title="Print" data-print_type="" data-lab_no="{{$sample_row->lab_no_pk}}" id="print_{{$sample_row->lab_no_pk}}" onclick="printLabel(this);enableSaveBtn()">{{$text}}</span>
                        <span class="btn btn-sm " style="<?= $backGroundColorAux ?>" title="Print" data-print_type="AUX" data-lab_no="{{$sample_row->lab_no_pk}}" id="aux_{{$sample_row->lab_no_pk}}" onclick="printLabel(this);enableSaveBtn()">AUX</span>
                        <a onclick="enableSaveBtn()" href="{{ route('path.sample-collection-print', $sample_row->lab_no_pk) }}" class="btn btn-sm btn-primary" target="_blank" title="Print">Manual Print</a>
                        @else
                        <a onclick="enableSaveBtn()" href="{{ route('path.sample-collection-print', $sample_row->lab_no_pk) }}" class="btn btn-sm btn-primary" target="_blank" title="Print">Print</a>
                        @endif
                        @endif
                        @if ($sample_row->test_name_list == 'OGTT-2 Samples' || $sample_row->test_name_list == 'OGTT-3 Samples')
                        <a href="{{ route('print-ogtt-worklist', [$sample_row->lab_code,$sample_row->invoice_code]) }}" class="btn btn-warning btn-sm" id="" target="_blank">Worklist Print </a>

                        @endif

                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="15">
                        <div>No Data Found</div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-2">
            @php
            $response_action = route('path.sample-collection-collect');
            $print_type=isset($print_type) ? $print_type:'';
              $saveDisabled=isset($sampleCollectionCount) && $sampleCollectionCount > 0 ? '': 'disabled';
              $saveText=isset($sampleCollectionCount) && $sampleCollectionCount > 0 ? 'Save': 'Label Print First';
            @endphp
            <span class="btn btn-success btn-md mr-2 uhl_save_btn <?= $saveDisabled   ?> saveBtn" onclick="if (!this.classList.contains('disabled'))btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >{{$saveText}}</span>
            @if(Session::get('user.ses_hospital_code')=="UNICO")
                <span class="btn btn-sm btn-primary mr-2 disabled"  title="All Print"  id="all_print" onclick="allPrintLabel(this);enableSaveBtn()">Print All</span>
            @else
                <a onclick="enableSaveBtn()" href="{{ route('print-all-barcode', $prescription_id) }}" class="btn btn-primary btn-md mr-2 disabled" id="all_print" target="_blank">Print All</a>
            @endif
            @if($prescription_id)
            <a onclick="enableSaveBtn()" href="{{ route('invoice-print-lab', [$lab_no,$prescription_id,$print_type]) }}" class="btn btn-primary btn-md mr-2 disabled-link" disabled id="lab_invoice" id="invoice_list" target="_blank">Work Sheet</a>

            @if(!empty($sample_collection_arr))
            <a onclick="enableSaveBtn()" href="{{ route('temporary-label-print', $sample_collection_arr[0]->lab_no_pk) }}" class="btn btn-md btn-primary mr-2" target="_blank" title="Print">Temporary Lebel</a>
            <a href="{{ route('slide-label-print', $sample_collection_arr[0]->lab_no_pk) }}" class="btn btn-md btn-info mr-2" target="_blank" title="Print">slide Label</a>
            @endif
            @endif

        </div>
    </div>

    <script>
        function printLabel(element) {
            let lab_no = $(element).data('lab_no');
            let machine_name=$('#machine_name').val();
            let print_type=$(element).data('print_type');
            if (machine_name =='') {
                alert('Select Machine Name');
                return false;
            }
            var action = "{{ route('path.sample-collection-print-v2') }}";
            $.ajax({
                data: {
                    lab_no: lab_no,
                    machine_name: machine_name,
                    print_type: print_type,
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                   if (data.print_ind==1) {
                        if (print_type == 'AUX') {
                            // $('#aux_'+lab_no).text('Printed');
                            $('#aux_'+lab_no).css('background-color', 'Magenta');
                        }else{
                            $('#print_'+lab_no).text('Printed');
                            $('#print_'+lab_no).css('background-color', 'Magenta');
                        }
                   }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
        function allPrintLabel(element) {
            let all_lab_no = $('.chk_sample');
            let lab_no_array=[];
            let machine_name=$('#machine_name').val();
            if (machine_name =='') {
                alert('Select Machine Name');
                return false;
            }
            all_lab_no.each(function() {
                if ($(this).is(':checked')) {
                    lab_no_array.push($(this).val());
                }
            });

            if (lab_no_array.length === 0) {
                alert('Please check item');
                return false;
            }
            var action = "{{ route('path.sample-collection-print-all-v2') }}";
            $.ajax({
                data: {
                    lab_no_array: lab_no_array,
                    machine_name: machine_name,
                },
                url: action,
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                   if (data.print_ind==1) {
                    console.log(lab_no_array);
                    lab_no_array.forEach(function(value, index) {
                        $('#print_'+value).text('Printed');
                        $('#print_'+value).css('background-color', 'Magenta');
                    });

                   }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    </script>
