<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%;">SL.</th>
                        <th class="text-center" style="width: 10%;">ID No.</th>
                        <th class="text-center" style="width: 25%;">Patient Name</th>
                        <th class="text-left" style="width: 25%;">Doctor Name</th>
                        <th class="text-left" style="width: 10%;">App. Date</th>
                        <th class="text-left" style="width: 5%;">Sex</th>
                        <th class="text-left" style="width: 10%;">Mobile</th>
                        <th class="text-center" style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody style="cursor: pointer;" id="tableBody">
                    @foreach($items as $index => $item)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $item->pabxappointment_no_pk }}</td>
                        <td>{{ $item->pat_name }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ !is_null($item->appoint_date) ? date('d/m/Y', strtotime($item->appoint_date)) : 'N/A' }}</td>
                        <td>{{ $item->lookupdata_name }}</td>
                        <td>{{ $item->mobile_no }}</td>
                        <td>
                            <span class="btn btn-sm btn-info btnAppointment" 
                                onclick="appointment({{ $item->pabxappointment_no_pk }})"
                            >Appointment</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 6], className: 'text-center' },
                    { targets: [2, 3, 4, 5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });

    // $('.btnAppointment').on('click', function() {
    //     var $tr = $(this).parents("tr");
    //     let pat_name = $tr.find("td").eq(2).html();
    //     let doctor_name = $tr.find("td").eq(3).html();
    //     let appointment_date = $tr.find("td").eq(4).html();
    //     let sex = $tr.find("td").eq(5).html();
    //     let mobile = $tr.find("td").eq(6).html();

    //     let obj = {
    //         pat_name: pat_name,
    //         doctor_name: doctor_name,
    //         appointment_date: appointment_date,
    //         sex: sex,
    //         mobile: mobile
    //     };
    //     // console.log(obj);

    //     // console.log(id);
    //     // console.log(pat_name);
    //     // console.log(full_name);

    //     // var obj = { id: 'myid', token: 'sometoken' };
    //     let route = '{{ route("appointments.create") }}?' + $.param(obj);
    //     console.log(route);
    // });

    // Appointment
    function appointment(id) {
        let route = '{{ route("appointments.create") }}/'+id;
        console.log(route);

    }
</script>
