<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<div class="form-row">
    <div class="col-12">
        <div class="card shadow-xs">
            <div class="card-header d-flex justify-content-between">
                <h5>Employee Roster</h5>
                <div class="d-flex justify-content-between">
                    <form action="{{ route('roster.emp.pdf') }}" method="POST" id="emp_roster_pdf" target="_blank">
                        @csrf
                        <input type="hidden" id="person_no" name="personal_id" value="">
                        <input type="hidden" id="date_from" name="from_date" value="">
                        <input type="hidden" id="date_to" name="end_date" value="">
                        <button type="submit" class="btn btn-warning btn-sm mr-2"><i class="far fa-file-pdf"></i> PDF</button>
                    </form>
                    <button class="btn btn-danger btn-sm" id="delete_all_roster" onclick="deleteAllRoster(this)"><i class="far fa-trash-alt"></i> All Delete </button>
                </div>
            </div>
            <div  class="card-body">
                <table class="table table-bordered table-hover m-0 table-striped" id="load_table1">
                    <thead>
                        <tr>
                            <th class="text-left global-uhl-table-bg">Date</th>
                            <th class="text-left global-uhl-table-bg">Duty Area</th>
                            <th class="text-left global-uhl-table-bg">Shift</th>
                            <th class="text-center global-uhl-table-bg">Start Time</th>
                            <th class="text-center global-uhl-table-bg">End Time</th>
                            <th class="text-center global-uhl-table-bg">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($roster_validate))
                            @foreach ($roster_validate as $value)
                                <tr>
                                    <td class="text-left ">{{ date('d-m-Y', strtotime($value->roster_date)) }}<br>
                                        {{ date('D', strtotime($value->roster_date)) }} </td>
                                    <td class="text-left ">{{ $value->lookupdata_name }}</td>
                                    <td class="text-left ">{{ $value->shift_code }}</td>
                                    @if (isset($value->duty_area_su_no_fk) && !empty($value->duty_area_su_no_fk))
                                        <td class="text-center ">{{ date('h:i a', strtotime($value->duty_start_time)) }}
                                        </td>
                                        <td class="text-center ">{{ date('h:i a', strtotime($value->duty_end_time)) }}
                                        </td>
                                    @else
                                        <td class="text-center "></td>
                                        <td class="text-center "></td>
                                    @endif
                                    <td class="text-center ">
                                        <button class="btn btn-outline-primary btn-sm open-modal"
                                            data-modal="common-modal-sm"
                                            data-action="{{ route('roster.validate-roster-edit', $value->roster_no_pk) }}"
                                            data-title="Edit Roster" title="Edit Roster"><i class="fa fa-edit"></i>
                                        </button>

                                        <input type="hidden" name="" id="valided_roster_delete"
                                            value="{{ $value->roster_no_pk }}">
                                        <span class="btn-danger btn btn-sm" onclick="deleteValidateRoster(this)"><i
                                                class="far fa-trash-alt"></i> </span>


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-left text-center" colspan="5"> No data found between From and To date
                                </td>
                            </tr>

                        @endif

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    function deleteAllRoster(element) {
        $conform_alt = confirm('Are you sure ?');
        var person_id= $("#hidn_personal").val()
        if(person_id != '' && person_id !=null){
            if ($conform_alt) {

            var person_no= $("#hidn_personal").val()
            var date_form= $("#roster_date_from").val()
            var date_to= $("#roster_date_to").val()
            $.ajax({
                data: {
                    person_no:person_no,
                    date_form:date_form,
                    date_to:date_to
                },
                url: "{{ route('roster.all-roster-delete') }}",
                type: 'POST',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $('#load_table1').find("tbody").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");

                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        }else{
            alert("Employee Can not empty")
        }

        event.preventDefault();
    }
    function deleteValidateRoster(element) {
        $conform_alt = confirm('Are you sure ?');

        if ($conform_alt) {
            var roster_id = $(element).siblings('#valided_roster_delete').val();

            $.ajax({
                data: {
                    roster_id: roster_id
                },
                url: "{{ route('roster.validate-roster-delete') }}",
                type: 'POST',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    // alert("#"+fund_id);
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");



                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        event.preventDefault();
    }
</script>
