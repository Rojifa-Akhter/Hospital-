{{-- patient information --}}

@include('admin.components.patient_info_min_uhl')

{{-- EMR data --}}
<div class="card">
    <div class="card-body">
        <div class="form-row">
            @include('admin.EMR.uhl.emr_tabs_uhl')
        </div>
    </div>
</div>

