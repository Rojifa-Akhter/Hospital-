
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Bonus Salary</h5>
                    <small>Hrm / Bonus Salary</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create New Bonus Salary</h5></div>
            <div class="card-body mt-2">
                    @include('admin.hrm.bonus.create_salary_bonus')
            </div>
        </div>
    </div>
</section>

<script>
              function editBonusSalary(element){
                var action = $(element).attr("data-action");
                $.ajax({
                  url:action,
                  type: 'get',
                  beforeSend: function() {
                    blockUI();

                  },
                  success: function(data) {
                    $("#salary_bonus").html(data);
                  },
                  complete: function() {

                    $.unblockUI();

                  }
                });
              }
</script>


