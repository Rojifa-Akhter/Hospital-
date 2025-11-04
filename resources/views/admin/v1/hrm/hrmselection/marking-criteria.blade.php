<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Marking Criteria</h5>
                        <small>HRM / Marking Criteria</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="criteria_id" class="col-form-label">Criteria Group ID</label>
                                            <input type="text" class="form-control form-control-sm" id="criteria_id"
                                                name="criteria_id" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="criteria_name" class="col-form-label">Criteria Group
                                                Name</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="criteria_name" name="criteria_name" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" id=""
                                            class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </form>

    <form action="{{ route('v1.hrm.save-marking-criteria') }}" id="marking-criteria-entry-form" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="marking_sl" class="col-form-label">Marking SL</label>
                                    <input type="text" class="form-control form-control-sm" id="marking_sl"
                                        name="marking_sl" placeholder="" value="" />
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="marking_creteria" class="col-form-label">Marking
                                        Creteria</label>
                                    <input type="text" class="form-control form-control-sm" id="marking_creteria"
                                        name="marking_creteria" placeholder="" value="" />
                                </div>
                            </div>


                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="top_score" class="col-form-label">Top Score</label>
                                    <input type="text" class="form-control form-control-sm" id="top_score"
                                        name="top_score" placeholder="" value="" />
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="passing_score" class="col-form-label">Passing Score</label>
                                    <input type="text" class="form-control form-control-sm" id="passing_score"
                                        name="passing_score" placeholder="" value="" />
                                </div>
                            </div>

                            <div class="col-md-1">
                                @php
                                    $response_action = route('v1.hrm.marking-criteria');
                                @endphp
                                {{-- <li class="list-inline-item mb-0 mt-0"> --}}
                                <button type="button" class="btn btn-success uhl_save_btn mt-3"
                                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                    id="">Save</button>
                                {{-- </li> --}}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th>SL</th>
                                    <th class="text-left">Marking SL</th>
                                    <th class="text-left">Marking Creteria</th>
                                    <th class="text-left">Top Score</th>
                                    <th class="text-left">Passing Score</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data))
                                    @foreach ($data as $marking_data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $marking_data->marking_sl }}</td>
                                            <td class="text-left">{{ $marking_data->marking_creteria }}</td>
                                            <td class="text-left">{{ $marking_data->top_score }}</td>
                                            <td class="text-left">{{ $marking_data->passing_score }}</td>
                                            <td>
                                                <a data-modal="common-modal"
                                                    data-action="{{ route('v1.hrm.update-marking-criteria', $marking_data->markingcriteria_no_pk) }}"
                                                    class="btn mb-1 btn-success btn-sm open-modal modal-lg"
                                                    data-title="Update Marking Criteria">Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    </section>
</main>
