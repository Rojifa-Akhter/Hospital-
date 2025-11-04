<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Test Details</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-left">Test Complete Duration(APPROXIMATELY)</td>
                    <td class="highlight test_du text-white">
                        {{ isset($schedule->duration_time) ? $schedule->duration_time : '' }} Min</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Room Details Section -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="card-title mb-0">Room Details</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="text-left">Last Appointment SL</td>
                    <td class="highlight text-white">{{ isset($img_app_sl_no) ? $img_app_sl_no : '' }} </td>
                </tr>
                {{-- <tr>
                    <td>Last Appointment Time</td>
                    <td class="highlight">{{ isset($img_app_dttm) ? date('d/m/Y', strtotime($img_app_dttm)) : '' }} </td>
                </tr> --}}
                <tr>
                    <td class="text-left">Average Time in This Room</td>
                    <td class="highlight text-white">{{ isset($schedule->avg_time) ? $schedule->avg_time : '' }} Min</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
{{-- </tbody>
</table> --}}
{{-- {{dd($schedule->duration_time)}} --}}
<!-- Test Details Section -->




<script>
    $('.book-schedule').click(function() {
        if ($("#search_data").val() == null) {
            alert("Please Select Room !")
            return false;
        }
        var id = $(this).data('id');
        var start = $(this).data('start');
        var end = $(this).data('end');
        var date = $("#radio_appointment_date").val();
        var app_id = $("#app_id").val();
        var inv_voucher_no = $("#inv_voucher_no").val();

        $('#save_buttonRad').click();
        $.ajax({
            url: '{{ route('book.schedule-store-radt') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                start: start,
                end: end,
                date: date,
                app_id: app_id,
                inv_voucher_no: inv_voucher_no,
            },
            success: function(response) {
                $("#appointment_id").val('');
                $('#appointment_id').focus()
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    });

    function cancelSchedule(thisElement) {
        console.log('ok')
    }
</script>
