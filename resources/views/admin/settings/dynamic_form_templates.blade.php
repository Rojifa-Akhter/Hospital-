<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Create New Form Template</h5>
                <small>Settings / Create New Form Template</small>
            </div>
        </div>
        <div class="card">
            {{-- <div class="card-header">
                <h5>Create Room</h5>
            </div> --}}
            <div class="card-body mt-2">
                <form action="{{ route('templates.store') }}" method="POST" id="templatesForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Template Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="submit_url">Submit Route</label>
                        <input type="text" class="form-control" id="submit_url" name="submit_url" required>
                    </div>
                    <div class="form-group">
                        <label for="redirect_url">Redirect Route</label>
                        <input type="text" class="form-control" id="redirect_url" name="redirect_url" required>
                    </div>
                     @php
                        $response_action = route('create-templates');
                    @endphp
                    <button type="submit" class="btn btn-primary"  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Create Template</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
