<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">IPD Package List</h5>
            <small>IPD / Package List</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h5>Package List</h5></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 table-responsive">
                            <table id="packageTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Package Name</th>
                                        <th>Package Details</th>
                                        <th>Package For</th>
                                        <th>Bed Category</th>
                                        <th>Pathology Amount</th>
                                        <th>Radiology Amount</th>
                                        <th>Medicine Amount</th>
                                        <th>Consultation Amount</th>
                                        <th>Ot Amount</th>
                                        <th>Procedure Amount</th>
                                        <th>Food Amount</th>
                                        <th>Services Amount</th>
                                        <th>Consumable Amount</th>
                                        <th>Map Service Item</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $index => $pkg)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pkg->pkg_name }}</td>
                                            <td>{{ $pkg->pkg_details }}</td>
                                            <td>
                                                @php
                                                    $pkgFor = [];
                                                    if ($pkg->pkg_for_opd) $pkgFor[] = 'OPD';
                                                    if ($pkg->pkg_for_ipd) $pkgFor[] = 'IPD';
                                                    if ($pkg->pkg_for_daycare) $pkgFor[] = 'DAYCARE';
                                                @endphp
                                                {{ implode(', ', $pkgFor) }}
                                            </td>
                                            <td></td>
                                            <td>{{ $pkg->pathology_amount }}</td>
                                            <td>{{ $pkg->radiology_amount }}</td>
                                            <td>{{ $pkg->medicone_amount }}</td>
                                            <td>{{ $pkg->consultation_amount }}</td>
                                            <td>{{ $pkg->ot_sur_ana_amount }}</td>
                                            <td>{{ $pkg->procedure_amount }}</td>
                                            <td>{{ $pkg->food_amount }}</td>
                                            <td>{{ $pkg->service_amount }}</td>
                                            <td>{{ $pkg->consumable_amount }}</td>
                                            <td></td>
                                            <td style="width: 100px;!important">
                                                <a  class="btn btn-info btn-sm" title="View">
                                                     <i class="fa fa-eye"></i></a>
                                                <a href="{{ route('v1.ipd-package-edit', $pkg->pkg_no_pk) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i></a>

                                                <form action="{{ route('v1.ipd-package-delete', $pkg->pkg_no_pk) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this package?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#packageTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true
    });
});
</script>

