<style>
	.doctor_img {
		width: 90px;
		height: 90px;
		display: inline-block;
		border-radius: 50%;
		overflow: hidden;
		margin-top: 12px;
		border: 5px solid #dcdcdc;
		box-shadow: 0 2px 3px rgba(0, 119, 193, 0.76);
	}
</style>
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <div class="float-left">
                <h5 class="mt-2 mb-0"> Employee Card</h5>
                <small>Settings / Employee Card</small>
            </div>
        </div>
    </div>

    @include('admin.hrm.employee.employee_card_search')

    <section id="full_doctor_list">
        <div class="container-fluid list_view">
            <div class="card">
                <div class="card-header "><h5>Employee Card List <a href="{{ route('doctor.index') }}" rel="tab" class="btn btn-sm btn-success float-right grid_view"><i class="fa fa-bars"></i> List</a> <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal" data-action="{{ route('doctor.create_form') }}" data-title="Create New Employee">Add Employee</button></h5></div>

                <div class="card-body">
                    <div class="row" id="card_data">
                        @include("admin.hrm.employee.card_list_data")

                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(document).on("click", "#card_search_btn", function(e) {
        var formID = $("#searchCardForm").attr("id");
        var formMethod = $("#searchCardForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('employee/card-list-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#card_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
