<style>
    .sticky_header {
        position: sticky;
        top: 90px;

    }
</style>



@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Doctor
                </h5>
                <small>Doctor/Doctor Favorite Entry</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">

                <div class="form-row" style="width:100%;">
                    <div class="col-md-6">
                        <div class="form-row">
                            <form action="{{ route('prescription-favorite-search-worklist') }}" id="searchForm"
                                method="post" target="_blank">
                                @csrf
                                <div class="" style="float: left;">
                                    <div class="form-group">
                                        <label for="card_no" class=" col-form-label col-form-label-sm">Doctor
                                            Name</label>
                                        <input type="text" class="form-control form-control-sm m-0"
                                            id="primary_doctor" name="primary_doctor" maxlength="50" value=""
                                            placeholder="Doctor Name" />
                                        <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                        <div><strong>
                                                <p id="autocomplete_data"></p>
                                            </strong></div>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="form-group">
                                        <label for="card_no"
                                            class=" col-form-label col-form-label-sm">Department</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="doc_dept"
                                            name="doc_dept" maxlength="50" value="" placeholder="Department"
                                            readonly />
                                    </div>
                                </div>
                                <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                                <div class="" style="border-right: 2px solid aliceblue;">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" id="pres_data_search_btn"
                                            class="btn btn-md btn-success btn-block mt-4">Search</button>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('prescription.favorite-add-all') }}" method="post"
                            id="medicine-create">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="card_no" class=" col-form-label col-form-label-sm">Copy From
                                            Others</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="copy_doctor"
                                            name="copy_doctor" maxlength="50" value=""
                                            placeholder="Doctor Name" />
                                        <input type="hidden" id="copy_id_doctor" name="copy_id_doctor"
                                            value="" />

                                        <input type="hidden" id="copy_from_doctor" name="copy_from_doctor"
                                            value="" />
                                        <div><strong>
                                                <p id="autocomplete_data"></p>
                                            </strong></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="btn-group btn-block" role="group">
                                        @php
                                            $response_action = route('prescription-favorite-worklist');
                                        @endphp
                                        <button type="submit"
                                            class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Copy</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h5>Favorite List</h5>
            </div>
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="pres_favorite_data">
                        @include('admin.prescription.favorite.pres_favorite_worklist_data')

                    </div>
                </div>
            </div>
        </div>




    </div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#primary_doctor', 'doctor_id', '', '', function(item, obj) {
        deptDoctor(item, obj);
        obj.stopImmediatePropagation();
    });

    openDoctorAutocomplete('#copy_doctor', 'copy_id_doctor');

    function deptDoctor(item, obj) {
        console.log(item)
        $('#doc_dept').val(item.su_name)
        $('#copy_from_doctor').val(item.doctor_id)
    }

    $(document).on("click", "#pres_data_search_btn", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('prescription-favorite-search-worklist') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#pres_favorite_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
