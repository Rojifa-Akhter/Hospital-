<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<section id="create_menu">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Item Type List</h5>
                <small>Settings / item type Setup / item type Add</small>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Create Item Type</h5>
                    </div>
                    <div class="card-body mt-2">
                        @include('admin.settings.item.create_item_type_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<link>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    $('.timepicker').timepicker({
        showInputs: false
    });
</script>
