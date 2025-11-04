<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card">
                <div class="card-body">

                    <div class="row" id="">
                        <div class="card-body" style="max-height: 350px;overflow:scroll;">
                            <div class="row" id="doctorData">
                                @if (!empty($doctor_info))
                                    @foreach ($doctor_info as $record)
                                        <div class="col-md-6">
                                            <span class="badge badge-success badge-md favourit_list_item cursor-pointer"
                                                onclick="doctorselect(this)" item-id='{{ $record->person_no_pk }}'
                                                item-su='{{ $record->su_name }}'
                                                item-name='{{ $record->full_name }}'>{{ $record->full_name }}
                                                <strong>({{ $record->su_name }})</strong>
                                            </span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function doctorselect(thisElement) {
            var id = $(thisElement).attr('item-id')
            var dept = $(thisElement).attr('item-su')
            var name = $(thisElement).attr('item-name')
            $('#myModal').modal("hide");

            $('#txt_referred_doctor').val(name)
            $('#ref_doc_card_hidn').val(id)
            $(".department_name").val(dept)
            $('#doc_dept').find(":selected").val(item.serviceunit_no_fk);
            $('#doc_dept').find(":selected").text(dept);
            $('#myModal').removeData('bs.modal');

        }
    </script>
