<div class="card-header ">
    <h5>
        <span class="updatedHeader">Communication</span>
        List (<span class="text-danger"><?php if (!empty($report_data)) {
            echo count($report_data);
        } else {
            echo 0;
        } ?></span>)
    </h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col" style="width: 200px;">Patient Name</th>
                        <th class="text-center" scope="col" style="width: 270px;">Date</th>
                        <th class="text-center" scope="col" style="width: 270px;">Mobile Number</th>
                        <th class="text-center" scope="col" style="width: 270px;">Age</th>
                        <th class="text-center" scope="col" style="width: 270px;">Gender</th>
                        <th class="text-center" scope="col" style="width: 270px;">Communication Medium</th>
                        <th class="text-right" scope="col" style="width: 270px;">Sales</th>
                        <th class="text-right" scope="col" style="width: 270px;">Discount</th>
                        <th class="text-right" scope="col" style="width: 270px;">Collection</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total_sales = $total_discount = $total_collection = 0;
                @endphp
                    @if (!empty($report_data))
                        @foreach ($report_data as $value)

                            <tr>


                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    {{ !empty($value->patient_name) ? strtoupper($value->patient_name) : '' }}</td>
                                <td class="text-left">
                                    {{ !empty($value->reg_date) ? date('d/m/Y H:i', strtotime($value->reg_date)) : 'N/A' }}
                                </td>
                                <td class="text-left">{{ !empty($value->mobile1) ? $value->mobile1 : '' }}</td>
                                <td class="text-left">{{ !empty($value->age) ? $value->age : '' }}</td>
                                <td class="text-left">{{ !empty($value->gender_txt) ? $value->gender_txt : '' }}</td>
                                @if(Session::get('user.ses_hospital_code') != 'IMPALA')
                                <td class="text-left">
                                    <div><strong>{{ !empty($type) ? $type : '' }}</strong></div>
                                    {{ !empty($value->full_name) ? $value->full_name : '' }}({{ !empty($value->person_code) ? $value->person_code : '' }})
                                </td>
                                @else
                                <td class="text-left">
                                    <div><strong>{{ !empty($type) ? $type : '' }}</strong></div>
                                    {{ !empty($value->full_name) ? $value->full_name : '' }}{{ !empty($value->person_code) ? '('.$value->person_code.')' : '' }}
                                </td>
                                @endif
                                <td class="text-right">{{ number_format($value->sales, 2) }}</td>
                                <td class="text-right">{{ number_format($value->discount, 2) }}</td>
                                <td class="text-right">{{ number_format($value->payment, 2) }}</td>
                                <div style="display: none">{{ $total_sales += $value->sales }}</div>
                                <div style="display: none">{{ $total_discount += $value->discount }}</div>
                                <div style="display: none">{{ $total_collection += $value->payment }}</div>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <th class="text-right" colspan="7">Total =</th>
                    <th class="text-right bg-light-blue">{{ number_format($total_sales, 2) }}</th>
                    <th class="text-right bg-light-blue">{{ number_format($total_discount, 2) }}</th>
                    <th class="text-right bg-light-blue">{{ number_format($total_collection, 2) }}</th>

                </tfoot>
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
</script>
