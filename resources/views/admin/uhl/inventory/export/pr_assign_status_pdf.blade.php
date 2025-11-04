
<style>
    table tr {
        border-bottom: none;
    }

    /* @media print {
    .signature {
            page-break-inside: avoid;
        }
    } */
    .signature{
      height:100px;
      width: 100%;
      top: 40px;
      position: relative;

    }
    .second-class{
        position: absolute;
        top:80px;
    }

    footer {
        position: fixed;
        z-index: 999;
        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        bottom: -100px;
        padding-top: 10px;
    }

    body {
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 15px;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr td,
    table tr th {
        font-size: 12px;
        border: 0;
        padding: 2px;
    }

    .border-0 {
        border: 0px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .logo {
        width: 80px;
        display: inline-block;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .form-heading p {
        font-size: .8rem;
        margin-top: -10px;
    }
    .mb-1 {
        margin-bottom: 7px;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
    }
</style>




<div class="form-content">
    <div class="form-heading border-bottom pb-3" style="">
        <div id="logo" style="display:inline-block !important; ">
            @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
            @endif
        </div>
        <div style="display:inline-block !important; ">
            <h1 class="mb-1">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>          
            <p class="mb-1">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>           
            <p class="mb-1">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
        </div>
    </div>

    <div class="heading text-center border-bottom mb-10">
        <h2>PR Assign Status Report</h2>
        <h4> @if(!empty($from_date)) <b>Date:</b>  {{ date('d/m/Y', strtotime($from_date))}}  - @endif   @if(!empty($to_date))  {{ date('d/m/Y', strtotime($to_date))}} @endif</h4>
    </div>

    <div class="row">

        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-center" style="width: 15%">Department</th> 
                        <th class="text-center" style="width: 15%">Assigned Employee</th> 
                        <th class="text-center" style="width: 8%">PR No</th> 
                        <th class="text-center" style="width: 8%">PR Date</th> 
                        <th class="text-center" style="width: 9%">Assign Date</th> 
                        <th class="text-left" style="width: 24%">Item Name</th>
                        <th class="text-center" style="width: 8%">Revoke</th> 
                        <th class="text-center" style="width: 8%">PO Status</th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left"> {{ $item->department_name}}</td>
                                <td class="text-left"> {{ $item->emp_name}}</td>
                                <td class="text-center"> {{ $item->inv_requisition_po_no_fk}}</td>
                                <td class="text-center">{{date('d/m/Y',strtotime($item->inv_requisition_po_date))}}</td>
                                <td class="text-center">{{date('d/m/Y',strtotime($item->assign_at))}}</td>
                                <td class="text-left">{{$item->item_name}}</td> 
                                <td class="text-center">
                                     @if(($item->revoked_ind) == 1)
                                        <span class="badge badge-success">Yes</span>
                                     @else
                                        <span class="badge badge-danger">No</span>
                                     @endif
                                    </td>
                                <td class="text-center"> 
                                    @if(($item->po_ind) == 1)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif 
                                </td>
                               
                            </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>

</div>

<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <div style="border-top: 1px solid black;">
        <table>
            <tbody>
                <tr>
                    <td style="text-align:left; font-size: 9px;">
                        <span>Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
                    </td>
                    <td style="text-align:right; font-size: 9px;">
                        <span>Powered By: NEXTGEN IT</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</footer>







