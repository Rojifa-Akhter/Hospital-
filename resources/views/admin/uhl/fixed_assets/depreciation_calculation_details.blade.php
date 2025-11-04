<style>
    /* .table_heading_bg {
        background: #c3c3c3;
    } */
    td {
        white-space: nowrap !important;
        padding: 5px;
    }

    .modal-body {
        max-height: calc(100vh - 143px);
        overflow-y: auto;
    }
</style>

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Depreciation Calculation</h5>
                                <small>Fixed Assets / Depreciation Calculation</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0" target="_blank" value="" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0" target="_blank" value="" id="EXCEL">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->



            <div class="row">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center">sl.</th>
                                        <th class="text-left">Tag Id</th>
                                        <th class="text-left">Item Name</th>
                                        <th class="text-left">Current User Incharge</th>
                                        <th class="text-left">Current Room Name</th>
                                        <th class="text-center">GRN Date</th>
                                        <th class="text-center">Model No</th>
                                        <th class="text-center">Item Serial No</th>
                                        <th class="text-center">Balance </th>
                                        <th class="text-center">GRN No</th>
                                        <th class="text-center">Cost Balance</th>
                                        <th class="text-center">Charged during the month</th>
                                        <th class="text-center">WDV</th>
                                    </tr>

                                </thead>
                                <tbody id="">
                                    @php
                                        $total_cost_balance = 0;
                                        $total_cost_closing_balance = 0;
                                        $total_depr_charged = 0;
                                        $total_wdv = 0;
                                    @endphp
                                    @if (!empty($depreciation_details))
                                        @foreach ($depreciation_details as $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $value->asset_tag_uid }}</td>
                                                <td class="text-left">{{ $value->item_name }}</td>
                                                <td class="text-left">{{ $value->curr_user_incharge }}</td>
                                                <td class="text-left">{{ $value->curr_location_room_name }}</td>
                                                <td class="text-center">
                                                    {{ $value->grn_date != '' ? date('d/m/Y', strtotime($value->grn_date)) : '' }}
                                                </td>
                                                <td class="text-center">{{ $value->item_model_number }}
                                                </td>
                                                <td class="text-center">{{ $value->item_serial_number }}</td>
                                                <td class="text-right">{{ number_format($value->cost_closing_balance, 2) }}
                                                </td>
                                                <td class="text-right">{{ 'N/A' }}</td>
                                                <td class="text-right">
                                                    {{ number_format($value->cost_closing_balance, 2) }}</td>
                                                <td class="text-right">{{ number_format($value->depr_charged, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format($value->wdv, 2) }}</td>
                                            </tr>

                                            @php
                                                $total_cost_balance += $value->cost_balance;
                                                $total_cost_closing_balance += $value->cost_closing_balance;
                                                $total_depr_charged += $value->depr_charged;
                                                $total_wdv += $value->wdv;
                                            @endphp
                                        @endforeach
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr class="table_heading_bg">
                                        <td class="text-right " colspan="8">Total</td>
                                        <td class="text-right">{{ number_format($total_cost_balance, 2) }}
                                        </td>
                                        <td class="text-right"></td>
                                        <td class="text-right">
                                            {{ number_format($total_cost_closing_balance, 2) }}</td>
                                        <td class="text-right">{{ number_format($total_depr_charged, 2) }}
                                        </td>
                                        <td class="text-right">{{ number_format($total_wdv, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<script>
    $("body").addClass("sidebar-collapse");


    $('#depre_search').on('click', function() {
        var from_year_month = $('#date_from').val();

        if (from_year_month == "") {
            alert('Enter Year Month');
            return false;
        }
        $.ajax({
            url: "{{ route('v1.depreciation-calculation-search') }}",
            method: "post",
            data: {
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response);
                $('#depre_search_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });
</script>
