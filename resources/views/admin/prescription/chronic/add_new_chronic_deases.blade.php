
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('store-new-chronic-deasease') }}" method="post" id="chronic_deasese">
        @csrf
        <div class="form-group row">
            <label for="deasese_name" class="col-sm-12 col-form-label col-form-label-sm">Chronic Disease Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="deasese_name" name="deasese_name"
                    value="" placeholder="Enter Chronic Disease Name" required>
            </div>
        </div>

        <div class="modal-footer mt-1">
            <button type="submit" class="btn btn-sm btn-success" id="btnSave"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'')">Save
                changes</button>
        </div>
    </form>
</div>
<script>
     $("#deasese_name").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $('#btnSave').focus()
        }
    });
</script>
