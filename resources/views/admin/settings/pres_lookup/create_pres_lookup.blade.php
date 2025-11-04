<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pres Lookup Detail Data</h5>
                <small>Settings / Pres_lookup / create_pres_lookup_form</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Pres Lookup Detail Data</h5></div>
            <div class="card-body mt-2">
                @include('admin.settings.pres_lookup.create_pres_lookup_form')
            </div>
        </div>
    </div>
</section>
<script>
var lookUp = {
    getlookupList:function (thisElement) {
        var lookupCodeId = $('#lookup_code').val();

        $.ajax({
            url:"{{route('lookupCodeId')}}",
            type:'POST',
            data: {
             lookupCodeId:lookupCodeId
         },
         beforeSend: function () {
            blockUI();
        },
        success: function (data) {
         $('#pres_lookup_data').html(data);
     },
     complete: function () {

        $.unblockUI();
    }
});
    },
};

</script>
