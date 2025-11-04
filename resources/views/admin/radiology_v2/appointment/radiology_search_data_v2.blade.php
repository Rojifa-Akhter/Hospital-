<style>
    .highlight {
        background-color: #26b46d;
        /* Light grey background for highlight */
    }

    .myTest {
        cursor: pointer;
        /* Show pointer cursor on hover */
        transition: background-color 0.3s ease;
    }
</style>
<div class="card">
    <div class="card-header">
        <h5>Patient Investigation</h5>
    </div>
    <div class="card-body mt-2">
        <table class="table table-bordered table-hover table-striped mb-0">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Invoice ID</th>
                    <th class="text-center">Invoice Date</th>
                    <th class="text-center">Room</th>
                    <th class="text-center">Appointment date</th>
                    <th class="text-center" colspan="2">Appointed</th>
                    {{-- <th class="text-center">Actions</th> --}}
                </tr>
            </thead>
           {{-- {{dd($test_info)}} --}}
            <tbody id="invest_data">

                @if (!empty($test_info))
                    @foreach ($test_info as $row)
                        <tr class="myTest" style="cursor: pointer">
                            <td>{{ $loop->iteration }}</td>
                            <td class="myValue">{{ $row->item_name }}</td>
                            <td class="myValue">{{ $row->invoice_no_pk }}</td>
                            <td>{{ !empty($row->img_app_dttm) ? date('d/m/Y', strtotime($row->invoice_date)) : '' }}
                            </td>

                            <td class="myValue">{{ $row->room_name }}</td>
                            <td class="myValue">
                                {{ !empty($row->img_app_dttm) ? date('d/m/Y', strtotime($row->img_app_dttm)) : '' }}
                            </td>
                            @if (empty($row->room_name))
                                <td class="text-center">
                                    <span class="badge badge-warning">Pending</span>
                                </td>
                            @else
                                <td class="text-center"><span class="badge badge-success">Done</span></td>
                            @endif

                            @if (empty($row->room_name))
                                <td class="text-center" style="display: none">
                                    <input type="radio" id="get_room"
                                        data-action="{{ route('radiology.create-radiology-item') }}" name="get_room"
                                        data-s_id="{{ !empty($row->serviceunit_no_fk) ? $row->serviceunit_no_fk : '' }}"
                                        data-item_id="{{ !empty($row->item_no_pk) ? $row->item_no_pk : '' }}"
                                        data-p_id="{{ !empty($row->radinvoicedtl_no_pk) ? $row->radinvoicedtl_no_pk : '' }}"
                                        onchange="get_add_que(this)">
                                </td>
                            @else
                                <td class="text-center"><span class="badge badge-primary">Complete</span></td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {



        $('.myTest').on('click', function() {
            $('.myTest').closest('tr').removeClass(
                'bg-success');
            $(this).closest('tr').addClass(
                'bg-success');
            var radioButton = $(this).find('input[type="radio"]');
            var itemName = $(this).find('.myValue').eq(0).text();
            get_add_que(radioButton);
            console.log('Item Name:', itemName);
        });


        // function get_add_que(element) {
        //     var value = $(element).attr('data-s_id');
        //     $('#inv_voucher_no').val($(element).attr('data-p_id'));
        //     console.log('Selected Data S_ID:', value);
        //     $.ajax({
        //         url: "{{ route('radiology.get-room') }}",
        //         type: 'POST',
        //         data: {
        //             id: value,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(data) {
        //             $('#search_data').html(data);
        //         },
        //         error: function() {
        //             alert('No Room Found.');
        //         }
        //     });
        // }
    });
</script>
