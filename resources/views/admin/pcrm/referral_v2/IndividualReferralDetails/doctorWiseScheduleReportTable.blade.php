<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="card-body">
    <div class="form-row mt-2">
        <div class="col-md-12 table-responsive" id="dept_details_report_list">  
            <table class="table data-table table-bordered table-hover table-striped">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">Department Name</th>
                        <th class="text-center">Doctor's Name</th>
                        <th class="text-center">Morning</th>
                        <th class="text-center">Evening</th>
                        <th class="text-center">Total Patient</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $morning = 0;
                        $evening = 0;
                        $total = 0;
                    @endphp
                    @if (!empty($result))
                        @foreach($result as $department => $data) 
                            @foreach($data as $idx => $row)
                                @php
                                    $morning += $row->morning;
                                    $evening += $row->evening;
                                    $total += $row->total_patient;
                                @endphp
                                <tr>
                                    @if($idx == 0)
                                        <td class="text-left" rowspan="{{ count($data) }}">{{ $row->su_name }}</td>
                                    @endif
                                    <td class="text-left">{{ $row->full_name }}</td>
                                    <td class="text-center">{{ $row->morning }}</td>
                                    <td class="text-center">{{ $row->evening }}</td>
                                    <td class="text-center">{{ $row->total_patient }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right">Total Patient</td>
                            <td class="text-center">{{ $morning }}</td>
                            <td class="text-center">{{ $evening }}</td>
                            <td class="text-center">{{ $total }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- <div class="card-body">
    <div class="form-row mt-2">
        <div class="col-md-12 table-responsive" id="dept_details_report_list">
            <table class="table data-table table-bordered table-hover table-striped">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">Department</th>
                        <th class="text-center">Total Patient</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="text-center">Emergency</td>
                            <td class="text-center">15</td>
                        </tr>
                        <tr>
                            <td class="text-center">Radiology</td>
                            <td class="text-center">65</td>
                        </tr>
                        <tr>
                            <td class="text-center">Pathology</td>
                            <td class="text-center">45</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
