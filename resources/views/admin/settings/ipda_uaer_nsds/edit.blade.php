<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section>
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Edit Ipds User NSDS</h5>
                    <small>Edit Ipds User/NSDS</small>
                </div>
                <div class="float-right">
                    <a href="{{route('ipdsusernsds.index')}}" class="btn btn-outline-primary mt-2"><i class="fa fa-plus"></i>Add Data</a>
                </div>
            </div>
        </div>



        {{-- page body start --}}
        <div class="card">
            <div class="card-header">
				<h5>Edit Ipds User NSDS data</h5>
			</div>
            <div class="card-body p-2">
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="itemWise" role="tabpanel">
                        <form action="{{route('ipdsusernsds.update',$item->user_nsds_pk_no)}}"  method="POST" id="attrGroup">
                            @csrf
                            @method('put')
                            <div class="form-row justify-content-between  ">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="upd_privs" class="col-form-label s-12">Upd privs</label>
                                        <input type="number" name="upd_privs" class="form-control mr-sm-2"
                                            placeholder="Upd privs" value="{{$item->upd_privs}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ins_privs" class="col-form-label s-12">Ins privs</label>
                                        <input type="number" class="form-control" name="ins_privs" value="{{$item->ins_privs}}"
                                            placeholder="ins privs" />
                                    </div>
                                </div>
                            </div>


                            <div class="form-row justify-content-between ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label s-12">Status</label><br>
                                        <input type="checkbox" id="status" name="status" value="1" {{ $item->status == '1' ? 'Checked' : '' }} />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row justify-content-end ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        @php
                                            $url = route('ipdsusernsds.edit',$item->user_nsds_pk_no);
                                        @endphp
                                        <button type="submit" class="btn btn-success btn-md"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">Update Data</button>

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    // openItemAutocomplete("#item_name", "LAB,LIQ,TAB", "#hdn_item_id");
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
