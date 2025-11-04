
<div class="container-fluid">
    <div class="card" >

        <div class="card-body p-2">
  
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; text-align:center;">
                        {{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>

                    <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                        <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                            Item Tracking Report (Indent to GRN)
                        </h5>
                        <h6 class="mb" style="text-transform: uppercase">From Date:
                            {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}
                        </h6>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    
                    <div class="Report">      
                        <table cellspacing="0" class="ReportDatatable" id="ReportDatatable">
                            <thead>
                                <tr>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">SL</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Indent No</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Indent Date</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Indent By</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Item No</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Item Name</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">UoM</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">From Store</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">To Store</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Indent Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Issued Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PR No</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PR Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PR Date</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PO No</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PO Date</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PO By</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">PO Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">GRN No</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">GRN By</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">GRN Date</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Order Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">GRN Qty</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Unit Price</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">Received Store Name</th>
                                        <th style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #000000;">suppier Name</th>
                                        
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($requisition_list)) 
                                @foreach($requisition_list as $value)
                                    <tr>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ $loop->iteration }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['INV_REQUISITION_NO_FK']) ? $value['INV_REQUISITION_NO_FK'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['INDENT_DATE']) ? $value['INDENT_DATE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['REQ_BY_NAME']) ? $value['REQ_BY_NAME'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['ITEM_NO_FK']) ? $value['ITEM_NO_FK'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['ITEM_NAME']) ? $value['ITEM_NAME'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['UOM']) ? $value['UOM'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['FROM_STORE']) ? $value['FROM_STORE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['TO_STORE']) ? $value['TO_STORE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['REQ_QUANTITY']) ? $value['REQ_QUANTITY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['ISSUE_QUANTITY']) ? $value['ISSUE_QUANTITY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PR_NO']) ? $value['PR_NO'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PR_QTY']) ? $value['PR_QTY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PR_REQ_AT']) ? $value['PR_REQ_AT'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PO_NO']) ? $value['PO_NO'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PO_DATE']) ? $value['PO_DATE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PO_AU_ENTRY_BY_NAME']) ? $value['PO_AU_ENTRY_BY_NAME'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['PO_APPROVED_QTY']) ? $value['PO_APPROVED_QTY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['GRN_NO']) ? $value['GRN_NO'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['GRN_AU_ENTRY_BY_NAME']) ? $value['GRN_AU_ENTRY_BY_NAME'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['GRN_DATE']) ? $value['GRN_DATE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['ORDER_QTY']) ? $value['ORDER_QTY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['GRN_QTY']) ? $value['GRN_QTY'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['UNIT_PRICE']) ? $value['UNIT_PRICE'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['DEPARTMENT']) ? $value['DEPARTMENT'] :'' }}</td>
                                        <td style="font-family:arial, verdana, sans-serif;font-size:10px;border:1px solid #8a8888;">{{ isset($value['GRN_SUPPLIER_NAME']) ? $value['GRN_SUPPLIER_NAME'] :'' }}</td>
                                    
                                    </tr>
                                @endforeach
                             @endif
                            
                        </table>
                    </div>  
                  
                </div>
            </div>

        </div>
    </div>
</div>