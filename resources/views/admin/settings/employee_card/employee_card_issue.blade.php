<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<style>
    .select2-container {
        z-index: 9999999999999999;
    }
</style>
<form method="post" id="frm-menu-store" action="{{ route('issue-card-store') }}">
    @csrf
    <input type="hidden" name="id" name="person_no_pk" value="{{$cardId->person_no_pk}}">
    <div class="form-group row">
        <input type="hidden" name="" value="">
        <label for="parent_menu" class="col-sm-4 col-form-label col-form-label-sm">Card Number</label>
        <div class="col-sm-8">
            <input type="text" class="form-control font_size_12 m-auto" name="card_number" id="" value="{{$cardId->card_no}}" placeholder="Enter Card number">
        </div>
    </div>
    <div class="modal-footer mt-1">

    <button type="button" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
        <input type="button" class="btn btn-sm btn-danger " value="Close" data-dismiss="modal">
        <a href="{{route('menu.index')}}" class="btn btn-sm btn-info ">Exit</a>
    </div>
</form>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
