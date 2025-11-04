<div class="card-header ">
    <h5>Laboratory Life Cycle</h5>
</div>
@php
    function formatDate($date)
    {
        return !is_null($date) ? date('d/m/Y h:i:s a', strtotime($date)) : 'N/A';
    }
@endphp
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" style="width: 85px;" scope="col">Invoice ID</th>
                        <th class="text-left" style="" scope="col">Patient Name</th>
                        <th class="text-center" style="width: 85px;" scope="col">UHID</th>
                        <th class="text-center" style="width: 85px;" scope="col">Sample Id</th>
                        <th class="text-center" scope="col">Item Name</th>
                        <th class="text-center" style="width: 150px;" scope="col">Sample Collection</th>
                        <th class="text-center" scope="col">Lab Receive</th>
                        <th class="text-center" scope="col">Machine Entry Time</th>
                        @if (session()->get('user.ses_hospital_code') != 'UNICO')
                            <th class="text-center" scope="col">Result Entry</th>
                        @endif                       
                        @if(session()->get('user.ses_hospital_code') == 'UNICO')
                        <th class="text-center" scope="col">Report Checked</th>
                        <th class="text-center" style="width: 150px;" scope="col">Report Approved</th>
                        @else
                        <th class="text-center" scope="col">Report Verify</th>
                        <th class="text-center" style="width: 150px;" scope="col">Report Finalized</th>
                        @endif
                        <th class="text-center" style="width: 130px;" scope="col">Report Process</th>
                        <th class="text-center" style="width: 190px;" scope="col">Receive at Delivery</th>
                        <th class="text-center" scope="col">Report Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($items))
                        @php
                            function getNameDatetime($name, $datetime)
                            {
                                $result = '';
                                if(!is_null($name)) $result .= $name;
                                if(!is_null($datetime)) {
                                    $result .= ' (' . $datetime . ')';
                                } else {
                                    $result .= 'N/A';
                                }

                                return $result;
                            }
                        @endphp

                        @foreach ($items as $item)
                            @php
                                $sample_collection = getNameDatetime($item->sc_sample_coll_keyed_name, $item->sc_sample_coll_keyed_time);
                                $lab_receive = getNameDatetime($item->lab_rcv_from_sp_keyed_name, $item->lab_rcv_from_sp_keyed_time);
                                $result_entry = getNameDatetime($item->result_ent_keyed_name, $item->result_prepared_keyed_time);
                                $report_verify = getNameDatetime($item->result_verify_keyed_name, $item->result_verify_keyed_time);
                                $report_finalized = getNameDatetime($item->result_final_keyed_name, $item->result_final_keyed_time);
                                $report_process = getNameDatetime($item->report_procees_keyed_name, $item->report_procees_keyed_time);
                                $receive_at_delivery = getNameDatetime($item->report_delivered_keyed_name, $item->report_delivered_time);
                                $report_delivery = getNameDatetime($item->report_rcb_keyed_name, $item->report_rcb_keyed_time);
                                $urgent_bg_color= $item->delivery_status_no ==2 ? 'background-color:#ffed4a;':'';
                            @endphp

                        <tr style="<?= $urgent_bg_color ?>">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item->invoice_code }}</td>
                            <td class="text-left">{{ $item->patient_name }}</td>
                            <td class="text-center">{{ $item->patient_code }}</td>
                            <td class="text-center">{{ $item->lab_code }}</td>
                            <td class="text-center">{{ $item->item_name }}</td>
                            <td class="text-center">{{ $sample_collection }}</td>
                            <td class="text-center">{{ $lab_receive }}</td>
                            <td class="text-center">{{ $item->mac_result_date !="" ? date('d/m/Y h:i:s',strtotime($item->mac_result_date)):'' }}</td>
                            @if (session()->get('user.ses_hospital_code') != 'UNICO')
                            <td class="text-center">{{ $result_entry }}</td>
                            @endif 
                            
                            <td class="text-center">{{ $report_verify }}</td>
                            <td class="text-center">{{ $report_finalized }}</td>
                            <td class="text-center">{{ $report_process }}</td>
                            <td class="text-center">{{ $receive_at_delivery }}</td>
                            <td class="text-center">{{ $report_delivery }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#pat_type', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
    });

    var table = $('.data_table').DataTable({
        searching: true,
        columnDefs: [
            { targets: [0, 1, 2,  5, 6, 7, 8, 9, 10, 11, 12], className: 'text-center' },
            { targets: [4], className: 'text-left' }
        ],
        "lengthMenu": [[5,3,10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "pageLength": 5
    });
</script>
