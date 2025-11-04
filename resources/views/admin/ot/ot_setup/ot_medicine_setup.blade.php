<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
{{-- {{ dd($procedureData) }} --}}
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">OT Medicine Procedure Setup</h5>
                <small>OT Medicine / OT Medicine Setup / OT Medicine Procedure Setup</small>
            </div>
        </div>


        <div class="row">
            <div class="card col-md-6">
                <div class="card-header">

                    <h5>OT Medicine Procedure List</h5>
                </div>

                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center" scope="col">Sl#</th>
                                        {{-- <th class="text-left" scope="col">Procedure ID</th> --}}
                                        <th class="text-left" scope="col">Procedure Name</th>
                                        {{-- <th class="text-center" scope="col">Medicine List</th>
                                        <th class="text-center" scope="col">Qty</th> --}}
                                        {{-- <th class="text-center" scope="col">Status</th> --}}
                                        <th class="text-center width-150" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6" id="otForm">
                @include('admin.ot.ot_setup.ot_create_medicine_setup')
            </div>

        </div>




    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('ot/get-all-pakages') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {

                    // var create_action = '{{ route('lookup.create') }}';
                    // create_action = create_action.replace(':id', row[0]);

                    var edit_action = '{{ route('ot.edit-pakage', ':id') }}';
                    edit_action = edit_action.replace(':id', row[2]);
                    // var delete_action = '{{ route('lookup.destroy', ':id') }}';
                    // delete_action = delete_action.replace(':id', row[0]);

                    return '<span Class="btn btn-sm btn-primary" data-id="' +
                        row[2] + '" data-action="' + edit_action +
                        '" data-title="Edit Procedure" title="Edit" onclick="otEditMode(' +
                        row[2] + ')"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });



    $("body").addClass("sidebar-collapse");

    // openItemAutocompleteWithStock(".item_typehead", "MED,LIQ,TAB", "", "" , itemdata);



    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    function addItemRow(thisElement) {
        const pkg_name = $('#pakage_name option:selected').val()
        console.log(typeof($('#qty_0').val())+'__________11111');
        if (pkg_name != '' && pkg_name != '0') {
            if ($('#item_id_0').val() == '' || $('#qty_0').val() == '') {

                alert('Please add Item Name & QTY')
                $("#item_id_0").focus()
                $(thisElement).parents('tbody').find('#item_id_0').val('');
                $(thisElement).parents('tbody').find('#qty_0').val('');
                $(thisElement).parents('tbody').find('#item_hdn_id_0').val('');
            } else {
                var row = $(thisElement).parents("tr").clone();
                var oldId = Number($(thisElement).parents("tr").attr("id"));
                var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
                row.attr('id', newId);

                row.find('#item_id_' + oldId).attr('id', 'item_id_' + newId);
                row.find('#item_td_action_' + oldId).attr('id', 'item_td_action_' + newId);
                row.find('#item_hdn_id_' + oldId).attr('id', 'item_hdn_id_' + newId);
                row.find('#qty_' + oldId).attr('id', 'qty_' + newId);
                row.find('#hdn_id_' + oldId).attr('id', 'hdn_id_' + newId);

                $(thisElement).parents("#data-append-to").append(row);
                console.log($(thisElement).parents("tr").clone() + "_________________check")
                $('#item_td_action_' + newId).html(
                    "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
                );

                $(thisElement).parents('tbody').find('#item_id_' + oldId).val('');
                $(thisElement).parents('tbody').find('#qty_' + oldId).val('');
                $(thisElement).parents('tbody').find('#item_hdn_id_' + oldId).val('');
            }

        } else {
            alert('Please add a Pakage Name')
            $("#pakage_Name").focus()
            $(thisElement).parents('tbody').find('#item_id_0').val('');
            $(thisElement).parents('tbody').find('#qty_0').val('');
            $(thisElement).parents('tbody').find('#item_hdn_id_0').val('');
        }


    }


    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }



    function otEditMode(item) {
        console.log(item)
        var action = "edit-pakage/" + item;
        console.log(action)
        $.ajax({
            data: {
                id: item
            },
            url: action,
            type: "get",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // console.log(data.procedure_name)
                // $('#Pakage_Name').html(data.procedure_name)
                $("#otForm").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
