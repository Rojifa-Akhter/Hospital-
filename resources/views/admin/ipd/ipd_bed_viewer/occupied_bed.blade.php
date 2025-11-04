
<div class="form-row">
    @if (!empty($ipds_bed))
        @foreach ($ipds_bed as $data)
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="user-card">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="image">

                                <img class="w-100"
                                     src="{{ asset('images/ipd.png') }}">

                            </div>

                            <div class="details">
                                <h4>{{ !empty($data->bed_name) ? $data->bed_name : '' }}</h4>
                                {{-- <h6>Ward Name: {{ !empty($data->ward_name) ? $data->ward_name : '' }}, Department:
                                    {{ !empty($data->serviceunit_name) ? $data->serviceunit_name : '' }}</h6> --}}

                                @if ($data->bed_status == 2)
                                    {{-- <h6>Patient Name: {{ !empty($data->patient_name) ? $data->patient_name : '' }}, Gender:
                                        {{ !empty($data->gender_txt) ? $data->gender_txt : '' }}</h6> --}}
                                    <span class="badge badge-secondary mt-3">Occupied</span>
                                @endif
                            </div>

                            <div class="actions">
                                <div class="btn-group btn-block">
                                    <button class="btn btn-md btn-outline-success open-modal" id="Bed_details" data-modal="common-modal-md"
                                            data-action="{{ route('ipd.bed-information',$data->bed_no_pk) }}"
                                            data-title="Bed Information" bed-attr="{{ $data->bed_no_pk }}">Bed Details</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif
</div>
