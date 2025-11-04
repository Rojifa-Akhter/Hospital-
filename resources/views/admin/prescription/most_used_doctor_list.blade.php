@if (!empty($item_list))
    @foreach ($item_list as $record)
        <div class="col-md-6" style="max-width: 90%;overflow:hidden;">

            <span class="badge badge-success badge-md cursor-pointer" id="doctor_name"
                doctor-id="{{ $record->person_no_pk }}" doctor-name='{{ $record->full_name }}'
                doctor-department='{{ $record->su_name }}' onclick="addDoctorsDataMostUse(this)">{{ $record->full_name }}
                <strong>({{ $record->su_name }})</strong>
            </span>
        </div>
    @endforeach
@endif

<script>
    function addDoctorsDataMostUse(thisElement) {

        var doc_id = $(thisElement).attr('doctor-id');
        var doctor_name = $(thisElement).attr('doctor-name');
        var doctor_department = $(thisElement).attr('doctor-department');

        $('#ref_doc_card_hidn').val(doc_id)
        $('#txt_referred_doctor').val(doctor_name)
        $(".department_name").val(doctor_department)

        $(".exampleModal").modal("hide");
    }
</script>
