<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


    @page {
        margin: .5cm .6cm;
        width: 100%;
        height: 100%
    }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 10px;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
    }


    /** Define the header rules **/
    header {
        position: fixed;
        top: 0;
        height: 2cm;

        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 11px;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: .7cm;
        text-align: center;
        padding: 0 1cm;
        border-top: 1px solid;
    }

    .signature_ {
        position: fixed;
        bottom: 1.6cm;
        left: .8cm;
        right: .8cm;
        width: 100%;
        /* text-align: center; */

        /* border-top: 1px solid; */
    }

    tfoot tr td {
        font-weight: bold;
    }

    .page-break {
        page-break-after: always;
    }

    .mt-5 {
        margin-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-20 {
        margin-top: 20px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-5 {
        margin-bottom: 15px;
    }

    .pb-0 {
        padding-bottom: 0;
    }
</style>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supplier List</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

    </style>
</head>

<body>
<main>
    <div class="wrapper">
        <div style="text-align:center; margin-bottom:20px; margin-top:20px;" class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;">Supplier List</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th style="text-align: center;" ><strong>SL</strong></th>
                            <th style="text-align: center;" ><strong>Supplier Uid</strong></th>
                            <th style="text-align: center;" ><strong>File No.</strong></th>
                            <th style="text-align: left;" ><strong>Supplier Name</strong></th>
                            <th style="text-align: left;" ><strong>Phone 1</strong></th>
                            <th style="text-align: left;" ><strong>Phone 2</strong></th>

                            <th style="text-align: left;" ><strong>Bank Account Name</strong></th>
                            <th style="text-align: left;" ><strong>Bank Account No.</strong></th>
                            <th style="text-align: left;" ><strong>Bank Name</strong></th>
                            <th style="text-align: left;" ><strong>Branch Name</strong></th>
                            <th style="text-align: left;" ><strong>Routing</strong></th>
                            
                            <th style="text-align: left;" ><strong>Contact Person</strong></th>
                            <th style="text-align: left;" ><strong>CP. Designation</strong></th>
                            <th style="text-align: center;" ><strong>Cp. Phone Number</strong></th>
                            <th style="text-align: left;" ><strong>CP. Email</strong></th>
                            <th style="text-align: left;" ><strong>Address</strong></th>
                            <th style="text-align: left;" ><strong>Supplier Type</strong></th>
                            <th style="text-align: left;" ><strong>Company Name</strong></th>
                            <th style="text-align: left;" ><strong>Email</strong></th>
                            <th style="text-align: left;" ><strong>Country Name</strong></th>
                            <th style="text-align: left;" ><strong>Description</strong></th>
                            <th style="text-align: center;" ><strong>File No</strong></th>
                            <th style="text-align: left;" ><strong>Status</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(!empty($supplier_data))
                            @foreach($supplier_data as $key=>$row)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $row->supplier_uid }}</td>
                                    <td style="text-align: center;">{{ $row->file_no }}</td>
                                    <td style="text-align: left;">{{ $row->supplier_name }}</td>
                                    <td style="text-align: left;">{{ $row->mobile1 }}</td>
                                    <td style="text-align: left;">{{ $row->mobile2 }}</td>

                                    <td style="text-align: left;">{{ $row->bank_account_name }}</td>
                                    <td style="text-align: left;">{{ $row->bankaccount }}</td>
                                    <td style="text-align: left;">{{ $row->bank_name }}</td>
                                    <td style="text-align: left;">{{ $row->bank_branch_name }}</td>
                                    <td style="text-align: left;">{{ $row->routing }}</td>
                                    
                                    <td style="text-align: left;">{{ $row->contact_person }}</td>
                                    <td style="text-align: left;">{{ $row->cp_jobtitle }}</td>
                                    <td style="text-align: left;">{{ $row->cp_phone }}</td>
                                    <td style="text-align: left;">{{ $row->cp_email }}</td>
                                    <td style="text-align: left;">Address 1 : {{ $row->addr1 }} <br> Address 2 : {{ $row->addr2 }}</td>
                                    <td style="text-align: left;">{{ $row->supp_type_name }}</td>
                                    <td style="text-align: left;">{{ $row->company_name }}</td>
                                    <td style="text-align: left;">{{ $row->e_mail }}</td>
                                    <td style="text-align: left;">{{ $row->country_name }}</td>
                                    <td style="text-align: left;">{{ $row->remarks }}</td>
                                    <td style="text-align: center;">{{ $row->file_no }}</td>
                                    <td style="text-align: left;">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
</body>

</html>

