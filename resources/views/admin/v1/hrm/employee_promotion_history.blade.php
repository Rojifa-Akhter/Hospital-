    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Promotion Information</div>
                <div class="card-body pt-2">

                    <table class="table table-bordered mt-2">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Employee ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Join Date</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Employee Type</th>
                                <th scope="col">Job Type</th>
                                <th scope="col">Promotions Date</th>
                                <th scope="col">Date of Effective</th>
                                <th scope="col">Current Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($promotion_info) && count($promotion_info) > 0)
                                @foreach ($promotion_info as $key => $val)
                                    <tr>
                                        <td scope="row">{{ $key + 1 }}</td>
                                        <td>{{ $val->person_no_pk }}</td>
                                        <td>
                                            {{ $val->full_name }}
                                        </td>
                                        <td>{{ $val->su_name }}</td>
                                        <td>{{ isset($val->join_date) ? date('Y/m/d', strtotime($val->join_date)) : '' }}
                                        </td>
                                        <td>{{ $val->designation }}</td>
                                        <td>{{ $val->emp_type }}</td>
                                        <td>{{ $val->job_type }}</td>
                                        <td>{{ isset($val->promotrans_date) ? date('Y/m/d', strtotime($val->promotrans_date)) : '' }}
                                        </td>
                                        <td>{{ isset($val->date_of_effective) ? date('Y/m/d', strtotime($val->date_of_effective)) : '' }}
                                        </td>
                                        <td>{{ $val->current_salary }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center text-success"><span>No Data Found</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div class="card">
        <div class="card-body p-2">
            <button class="btn btn-danger btn-sm" onclick="" data-func="" data-dismiss="modal"> Close
            </button>
        </div>
    </div>
