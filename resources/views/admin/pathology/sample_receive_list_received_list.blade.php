 <div class="tab-pane fade show active" id="receive-sample" role="tabpanel"
 aria-labelledby="received-by-challan-tab">
 <div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th>SL#</th>
                    <th class="text-left">UHID</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">IP No</th>
                    <th class="text-left">Invoice No</th>
                    <!-- <th>LAB No</th> -->
                    <th class="text-left">Sample Id</th>
                    <th class="text-left">Sample Collection Date</th>
                    {{-- <th>Delivery Date</th> --}}
                    <th class="text-left">Service Name</th>
                    <th class="text-left">Container</th>
                </tr>
            </thead>
           
            <tbody id="receive-container">
                @if(!empty($receive_arr))
                @foreach($receive_arr as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->patient_code }}</td>
                    <td>{{ $row->patient_name }}</td>
                    <td>{{ $row->admission_no_pk }}</td>
                    <td>{{ $row->invoice_uid }}</td>
                    <!-- <td>{{ $row->lab_no_pk }}</td> -->
                    <td>{{ $row->lab_uid }}</td>
                    <td>{{$row->sc_sample_coll_keyed_time !="" ? date("d/m/Y h:i a", strtotime($row->sc_sample_coll_keyed_time)) :''}}</td>
                    <td>{{ $row->test_name_list }}</td>
                    <td class="text-left">{{ $row->container_name }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7">No Data Found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
