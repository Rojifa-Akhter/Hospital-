<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section>
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Attribute Group</h5>
                    <small>Attribute/Attribute Group</small>
                </div>
            </div>
        </div>



        {{-- page body start --}}
        <div class="card">
            <div class="card-header">
				<h5>Create Attribute Group data</h5>
			</div>
            <div class="card-body p-2">
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="itemWise" role="tabpanel">
                        <form action="{{ route('att.store') }}" method="POST" id="attrGroup">
                            @csrf
                            <div class="form-row justify-content-between  ">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="t_att-group_name" class="col-form-label s-12">Test Attribute Group
                                            code</label>
                                        <input type="text" name="t_att_group_name" class="form-control mr-sm-2"
                                            placeholder="Test Attribute Group Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="att-group_name" class="col-form-label s-12">Attribute Group
                                            Name</label>
                                        <input type="text" class="form-control" name="att_group_name" value=""
                                            placeholder="Attribute Group Name" />
                                    </div>
                                </div>
                            </div>


                            <div class="form-row justify-content-between ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label s-12">Status</label><br>
                                        <input type="checkbox" id="status" name="status" value="1" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row justify-content-end ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        @php
                                            $url = route('att.index');
                                        @endphp
                                        <button type="submit" class="btn btn-success btn-md"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">Save Data</button>

                                    </div>
                                </div>
                            </div>
                        </form>



                        {{-- Attribute Group Data --}}
                        <section class="mt-4">
                            <h5 class="">Attribute Group Data</h5>
                            <table class="table table-striped table-hover" id="myTable">
                                <thead>
                                    <tr class="global-uhl-table-bg">
                                        <th style="vertical-align:middle;">SL&nbsp;NO.</th>
                                        <th style="vertical-align:middle;">Test&nbsp;Attribute&nbsp;Group&nbsp;code</th>
                                        <th style="vertical-align:middle;">Attribute&nbsp;Group&nbsp;Name</th>
                                        <th style="vertical-align:middle;">Status</th>
                                        <th style="vertical-align:middle;">Edit Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->test_group_code }}</td>
                                            <td>{{ $item->attrgroup }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td> <a href="{{ url('attribute/group/' . $item->test_group_no_pk) }}"
                                                    class="btn btn-primary"><i class="fa fa-pencil-alt"></a></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </section>

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
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
