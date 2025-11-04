@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    //Initialize variable
    $count1 = 0; //Initialize variable
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center"></th>
            <th class="text-center">Department</th>
            <th class="text-center">Total Item</th>
            <th class="text-center">Total Investigation</th>
            <th class="text-center">OPD</th>
            <th class="text-center">IPD</th>
            <th class="text-center">Corporate</th>
            <th class="text-center">Academic</th>
            <th class="text-center">Total</th>

            {{-- @if (!empty($column_name2))
                @foreach ($column_name2 as $c_name)
                    <th class="text-center">{{ !empty($c_name->module_code) ? ucfirst($c_name->module_code) : '' }}</th>
                @endforeach
            @endif
            @if (!empty($column_name))
                @foreach ($column_name as $c_name)
                    <th class="text-center">
                        {{ !empty($c_name->patient_type_code) ? ucfirst($c_name->patient_type_code) : '' }}</th>
                @endforeach
            @endif --}}
        </tr>


    </thead>
    <tbody>    <?php
        $final_patient = $final_quantity = $final_opd_qty = $final_opd_amt = $final_ipd_qty = $final_ipd_amt = $final_academic_qty = $final_academic_amt = $final_corporate_qty = $final_corporate_amt = $final_qty = $final_amt = 0;
        
        ?>
        @if (!empty($report_data))
    
            @foreach ($parent_dt as $key => $value)
                <tr>
                    <td colspan="9" class="text-left"><strong>{{ $key }}</strong></td>
                </tr>
                <?php
                $total_patient = $total_quantity = $total_opd_qty = $total_opd_amt = $total_ipd_qty = $total_ipd_amt = $total_academic_qty = $total_academic_amt = $total_corporate_qty = $total_corporate_amt = $total_qty = $total_amt = 0;
                
                ?>
                @foreach ($value as $dt)
                    <tr>
                        <td></td>
                        <td>{{ $dt->item_serviceunit_name }}</td>
                        <td>{{ $dt->date_w_cnt }}</td>
                        <td>{{ $dt->item_qty_investigation }}</td>
                        <td class="text-right">
                            <div><strong>Total Item:</strong>{{ $dt->item_qty_opd }}</div>
                            <div><strong>{{ number_format($dt->item_amt_opd) }}</strong>
                            </div>
                        </td>

                        <td class="text-right">
                            <div><strong>Total Item:</strong>{{ $dt->item_qty_ipd }}</div>
                            <div><strong>{{ number_format($dt->item_amt_ipd) }}</strong>
                            </div>
                        </td>

                        <td class="text-right">
                            <div><strong>Total Item:</strong>{{ $dt->item_qty_corp }}</div>
                            <div><strong>{{ number_format($dt->item_amt_corp) }}</strong>
                            </div>
                        </td>

                        <td class="text-right">
                            <div><strong>Total Item:</strong>{{ $dt->item_qty_academic }}</div>
                            <div><strong>{{ number_format($dt->item_amt_academic) }}</strong>
                            </div>
                        </td>
                        <td class="text-right">
                            <div><strong>Total
                                    Patient:</strong>{{ $dt->item_qty_opd + $dt->item_qty_ipd + $dt->item_qty_corp + $dt->item_qty_academic }}
                            </div>
                            <div>
                                <strong>{{ number_format($dt->item_amt_opd + $dt->item_amt_ipd + $dt->item_amt_corp + $dt->item_amt_academic) }}</strong>
                            </div>
                        </td>
                    </tr>

                    <div style="display: none">{{ $total_patient += $dt->date_w_cnt }}</div>
                    <div style="display: none">{{ $total_quantity += $dt->item_qty_investigation }}</div>
                    <div style="display: none">{{ $total_opd_qty += $dt->item_qty_opd }}</div>
                    <div style="display: none">{{ $total_opd_amt += $dt->item_amt_opd }}</div>
                    <div style="display: none">{{ $total_ipd_qty += $dt->item_qty_ipd }}</div>
                    <div style="display: none">{{ $total_ipd_amt += $dt->item_amt_ipd }}</div>

                    <div style="display: none">{{ $total_academic_qty += $dt->item_qty_academic }}</div>
                    <div style="display: none">{{ $total_academic_amt += $dt->item_amt_academic }}</div>
                    <div style="display: none">{{ $total_corporate_qty += $dt->item_qty_corp }}</div>
                    <div style="display: none">{{ $total_corporate_amt += $dt->item_amt_corp }}</div>
                    <div style="display: none">
                        {{ $total_qty += $dt->item_qty_opd + $dt->item_qty_ipd + $dt->item_qty_corp + $dt->item_qty_academic }}
                    </div>
                    <div style="display: none">
                        {{ $total_amt += $dt->item_amt_opd + $dt->item_amt_ipd + $dt->item_amt_corp + $dt->item_amt_academic }}
                    </div>


                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="2">Sub Total =</th>
                    <th class="text-left bg-light-blue">{{ $total_patient }}</th>
                    <th class="text-left bg-light-blue">{{ $total_quantity }}</th>
                    <th class="text-right bg-light-blue">
                        <div><strong>Total Item:</strong>{{ $total_opd_qty }}</div>
                        <div><strong>{{ number_format($total_opd_amt) }}</strong>
                        </div>
                    </th>
                    <th class="text-right bg-light-blue">
                        <div><strong>Total Item:</strong>{{ $total_ipd_qty }}</div>
                        <div><strong>{{ number_format($total_ipd_amt) }}</strong>
                        </div>
                    </th>
                    <th class="text-right bg-light-blue">
                        <div><strong>Total Item:</strong>{{ $total_corporate_qty }}</div>
                        <div><strong>{{ number_format($total_corporate_amt) }}</strong>
                        </div>
                    </th>
                    <th class="text-right bg-light-blue">
                        <div><strong>Total Item:</strong>{{ $total_academic_qty }}</div>
                        <div><strong>{{ number_format($total_academic_amt) }}</strong>
                        </div>
                    </th>
        
                    <th class="text-right bg-light-blue">
                        <div>{{ $total_qty }}</div>
                        <div><strong>{{ number_format($total_amt) }}</strong>
                        </div>
                    </th>
                </tr>

                <div style="display: none">{{ $final_patient += $total_patient}}</div>
                <div style="display: none">{{ $final_quantity += $total_quantity }}</div>
                <div style="display: none">{{ $final_opd_qty += $total_opd_qty }}</div>
                <div style="display: none">{{ $final_opd_amt += $total_opd_amt }}</div>
                <div style="display: none">{{ $final_ipd_qty += $total_ipd_qty }}</div>
                <div style="display: none">{{ $final_ipd_amt += $total_ipd_amt }}</div>

                <div style="display: none">{{ $final_academic_qty += $total_academic_qty }}</div>
                <div style="display: none">{{ $final_academic_amt += $total_academic_amt }}</div>
                <div style="display: none">{{ $final_corporate_qty += $total_corporate_qty }}</div>
                <div style="display: none">{{ $final_corporate_amt += $total_corporate_amt }}</div>
                <div style="display: none">
                     {{ $final_qty += $total_qty }}
                </div>
                <div style="display: none">
                    {{ $final_amt +=  $total_amt}}
                </div>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total =</th>
            <th class="text-left bg-light-blue">{{ $final_patient }}</th>
            <th class="text-left bg-light-blue">{{ $final_quantity }}</th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                <div><strong>Total Item:</strong>{{ $final_opd_qty }}</div>
                <div><strong>{{ number_format($final_opd_amt) }}</strong>
                </div>
            </th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                <div><strong>Total Item:</strong>{{ $final_ipd_qty }}</div>
                <div><strong>{{ number_format($final_ipd_amt) }}</strong>
                </div>
            </th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                <div><strong>Total Item:</strong>{{ $final_corporate_qty }}</div>
                <div><strong>{{ number_format($final_corporate_amt) }}</strong>
                </div>
            </th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                <div><strong>Total Item:</strong>{{ $final_academic_qty }}</div>
                <div><strong>{{ number_format($final_academic_amt) }}</strong>
                </div>
            </th>

            <th class="text-right bg-light-blue" style="text-align: right;">
                <div>{{ $final_qty }}</div>
                <div><strong>{{ number_format($final_amt) }}</strong>
                </div>
            </th>
        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
