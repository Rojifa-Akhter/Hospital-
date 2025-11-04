 <div class="table-responsive" style="overflow-x:auto;">
     <table class="table table-bordered table-striped mb-0 data-table">
         <thead class="thead-light">
             <tr class="bg-light-blue">
                 <th style="min-width: 60px;">SL#</th>
                 <th style="min-width: 120px;" class="text-left">Debtor Code</th>
                 <th style="min-width: 200px;" class="text-left">Debtor Name</th>
                 <th style="min-width: 100px;" class="text-right">OP Bill Count</th>
                 <th style="min-width: 120px;" class="text-right">OP Sales</th>
                 <th style="min-width: 100px;" class="text-right">IP Bill Count</th>
                 <th style="min-width: 120px;" class="text-right">IP Sales</th>
                 <th style="min-width: 120px;" class="text-right">Total Sales</th>
             </tr>
         </thead>
         <tbody>
             @php
                 $grandOpCount = $grandIpCount = $grandOpSales = $grandIpSales = 0;
             @endphp

             @forelse ($report_data as $row)
                 @php
                     $opCount = (int) $row->op_count;
                     $ipCount = (int) $row->ip_count;
                     $opSales = (float) $row->op_sales;
                     $ipSales = (float) $row->ip_sales;
                     $totalSales = $opSales + $ipSales;

                     $grandOpCount += $opCount;
                     $grandIpCount += $ipCount;
                     $grandOpSales += $opSales;
                     $grandIpSales += $ipSales;
                 @endphp
                 <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td class="text-left">{{ trim($row->patient_code) }}</td>
                     <td class="text-left">{{ trim($row->patient_name) }}</td>
                     <td class="text-right">{{ number_format($opCount, 0) }}</td>
                     <td class="text-right">{{ number_format($opSales, 2) }}</td>
                     <td class="text-right">{{ number_format($ipCount, 0) }}</td>
                     <td class="text-right">{{ number_format($ipSales, 2) }}</td>
                     <td class="text-right bg-light-gray"><strong>{{ number_format($totalSales, 2) }}</strong></td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="8" class="text-center">No data available</td>
                 </tr>
             @endforelse
         </tbody>

         @if (!empty($report_data))
             <tfoot>
                 @php $grandTotalSales = $grandOpSales + $grandIpSales; @endphp
                 <tr class="bg-light-blue">
                     <th colspan="3" class="text-right"><strong>Grand Total =</strong></th>
                     <th class="text-right">{{ number_format($grandOpCount, 0) }}</th>
                     <th class="text-right">{{ number_format($grandOpSales, 2) }}</th>
                     <th class="text-right">{{ number_format($grandIpCount, 0) }}</th>
                     <th class="text-right">{{ number_format($grandIpSales, 2) }}</th>
                     <th class="text-right bg-light-blue"><strong>{{ number_format($grandTotalSales, 2) }}</strong>
                     </th>
                 </tr>
             </tfoot>
         @endif
     </table>
 </div>
