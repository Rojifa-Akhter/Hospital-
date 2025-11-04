<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{@$data['report']->report_name_show}}</title>


    <style>
        thead {
            background-color: white;
        }
        .fs-12{
            font-size: 14px;
        }
        .table{
            border-collapse: collapse;
            width:100%;
        }
        .table-bordered{
            border: 1px solid #333;
        }
        td,th{
            font-size: 13px;
            border: 1px solid #333;
            padding-right:3px;
        }

        .w-16{
            width: 16%;
        }
        .w-8{
            width:8%;
        }
        .w-15{
            width:15%;
        }
        .w-25{
            width:25%;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .header>tbody>tr>td{
            border:1px solid black;
        }

        body{
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }
        .footer-table {
            margin-top: 10px;
            /* position: relative;
            bottom: 20px;
            left:0px;
            right:0px; */
        }
        td{
            page-break-inside: avoid
        }
        .border-right-0{
            border: transparent !important;
        }
        .logo{
            height: 50px;
            width: auto;
        }
    </style>
</head>
<body onload="window.print()">

    <section>
        <div style="display: flex">

            <div style="width: 15%" >

                <div style="padding-top: 20px">
                    @if (!empty(@$hospital_details->logo))
                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . @$hospital_details->logo) }}" class="logo"  />
                        {{-- <img src="http://115.127.139.2:8085/h360_uhl/public/images/uploads/hospital_images/thumb/unico_logo.png" class="logo" /> --}}
                    @endif
                </div>
            </div>
            <div style="width: 70%">
                <h4 style="margin-top: 20px;margin-bottom:3px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
                <h5 style="margin-top: 0px; text-align:center;" >{{isset($org_info->addrress1 )? $org_info->addrress1 : ""}}</h5>

            </div>
            <div style="width: 15%">

            </div>
        </div>

        <div style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
            <span style="font-size: 16px;text-transform:uppercase"><b>{{@$data['report']->report_name_show}}</b></span>
        </div>
    </section>


    @if(!empty($input))
    @php $total_input = floor(count($input) / 2) @endphp
    <section>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td  style="border:none">
                        @foreach ($input as $key => $item)
                            @if($loop->iteration  <= $total_input)
                                <div><b>{{$key}} :</b> {{$item}}</div>
                            @endif
                        @endforeach
                    </td>

                    <td class="text-right" style="border:none">
                        @foreach ($input as $key => $item)
                            @if($loop->iteration  > $total_input)
                                <div><b>{{$key}} :</b> {{$item}}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    @endif

    <section>
        <table class="table table-bordered">
            <thead>
                <tr>

                    @foreach($show_column as $item)

                        <th>{{$item->column_heading_name}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($result as $value)

                    <tr>
                    @foreach($show_column as $key => $item)
                        @php $key = strtolower($item->column_name_actual) @endphp
                        <td class="{{$item->alignment_type}}">
                            @if($item->value_type == 2)
                                @if(!empty($value->{$key}))
                                    {{date('d/m/Y', strtotime($value->{$key}))}}
                                @endif
                            @elseif($item->value_type == 4)
                                {{ number_format($value->{$key}, 2) }}
                            @else
                                {{ $value->{$key} }}
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach


                <tr>
                    @foreach($show_column as $key => $item)

                        @if($item->sum_ind == 1)
                            <td class="text-right"><b>{{ number_format(collect($result)->sum(strtolower($item->column_name_actual)), 2)}}</b></td>
                        @else


                            <td class="text-right {{isset($show_column[$key+1]) ? 'border-right-0' : ''}}">
                                @isset($show_column[$key+1])
                                        @if($show_column[$key+1]->sum_ind == 1)
                                           <b>Total</b>
                                        @endif
                                @endisset
                            </td>
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>
    </section>

    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp
        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    @php
                        // hospital code
                        $hospital_code = isset($org_info->hospital_code) ? $org_info->hospital_code : '';
                    @endphp
                    @if($hospital_code == 'KPJ')
                        <td style="text-align:right;border:none;width:30%"></td>
                    @else
                        <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>







