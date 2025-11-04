<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_corporate">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Add New Corporate</h5>
                    <small>Corporate / Add New Corporate</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Add New Corporate</h5></div>
            <div class="card-body mt-2">
             @include('admin.corporate.corporate_entry_form')
                
            </div>
        </div>
        {{-- page body start--}}

        {{-- page body End--}}
    </div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {
        $('.select2').select2();
    });
</script>
