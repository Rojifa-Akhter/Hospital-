<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section>
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0"> Edit Attribute Group</h5>
                    <small>Attribute/Attribute Group Edit</small>
                </div>
                <div class="float-right">
                    <a href="{{route('att.index')}}" class="btn btn-outline-primary mt-2"><i class="fa fa-plus"></i>Add Data</a>
                </div>
            </div>
        </div>



        {{-- page body start --}}
        <div class="card">
            <div class="card-body p-2">
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="itemWise" role="tabpanel">
                        <form  action="{{route('att.updateAtt',$item->test_group_no_pk)}}" method="POST" id="attrGroup">
                            @csrf
                            @method('put')
                            <div class="form-row justify-content-between  ">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="t_att-group_name" class="col-form-label s-12">Test Attribute Group
                                            code</label>
                                        <input type="text" name="t_att_group_name" class="form-control mr-sm-2"
                                            value="{{$item->test_group_code}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="att-group_name" class="col-form-label s-12">Attribute Group
                                            Name</label>
                                        <input type="text" class="form-control" name="att_group_name"
                                        value="{{$item->attrgroup}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row justify-content-between ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label s-12">Status</label><br>
                                        <input  type="checkbox" id="status" {{ $item->status == '1' ? 'Checked' : '' }}
                                            name="status" value="1"/>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row justify-content-end ">
                            <div class="col-md-3">
                                <div class="form-group">
                                    @php
                                    $url = route('att.editAtt',$item->test_group_no_pk);
                                @endphp
                               <button type="submit"  class="btn btn-success btn-md"   onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">Update Data</button>

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
openItemAutocomplete("#item_name", "LAB,LIQ,TAB", "#hdn_item_id");
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
