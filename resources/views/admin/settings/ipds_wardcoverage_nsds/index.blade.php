<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section>
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Ipds Wardcoverage Nurse & Doctor Station</h5>
                    <small>Ipds Wardcoverage Nurse/Doctor Station</small>
                </div>
            </div>
        </div>



        {{-- page body start --}}
        <div class="card">
            <div class="card-header">
				<h5>Create Ipds Wardcoverage Nurse & Doctor Station data</h5>
			</div>
            <div class="card-body p-2">
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="itemWise" role="tabpanel">
                        <form action="{{ route('ipdswardcoveragensds.store') }}" method="POST" id="attrGroup">
                            @csrf
                            <div class="form-row justify-content-between  ">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ward_no_fk" class="col-form-label s-12">Word no Fk</label>
                                        <input type="number" name="ward_no_fk" class="form-control mr-sm-2"
                                            placeholder="Word no Fk">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status" class="col-form-label s-12">Status</label><br>
                                            <input type="checkbox" id="status" name="status" value="1" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row justify-content-end ">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        @php
                                            $url = route('ipdswardcoveragensds.index');
                                        @endphp
                                        <button type="submit" class="btn btn-success btn-md"
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $url }}')">Save Data</button>

                                    </div>
                                </div>
                            </div>
                        </form>



                        {{-- Ipds Wardcoverage Nurse & Doctor Station --}}
                        <section class="mt-4">
                            <h5 class="">Ipds Wardcoverage Nurse & Doctor Station Data</h5>
                            <table class="table table-bordered table-hover table-striped data-table" id="myTable">
                                <thead class="bg-primary">
                                    <tr>
                                        <th style="vertical-align:middle;">SL&nbsp;NO.</th>
                                        <th style="vertical-align:middle;">Word&nbsp;no&nbsp;Fk&nbsp;</th>
                                        <th style="vertical-align:middle;">Status</th>
                                        <th style="vertical-align:middle;">Edit Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->ward_no_fk }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td> <a href="{{ url('ipds-wardcoverage-nsds/'.$item->nsdscoverage_no_pk) }}"
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
    // openItemAutocomplete("#item_name", "LAB,LIQ,TAB", "#hdn_item_id");
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
