<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
{{-- <script>
    $(document).ready(function() {
        $('#item_wise_table').DataTable();
    });
</script> --}}
<script>
    $(function() {
        $('.select2').select2();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Get item wise data
        itemWiseFetch();

        function itemWiseFetch() {
            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-itemwise') }}",
                dataType: "json",
                success: function(response) {

                    $('#item_wise_t_body').html("");
                    $.each(response.itemWiseData_view, function(key, item) {

                        $('#item_wise_t_body').append('<tr>\
                                        <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                        <td > ' + item.item_name + ' </td>\
                                        <td > ' + (item.cr_account_name ? item.cr_account_name : " ") + ' </td>\
                                        <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                            .trn_cr_account_percent : " ") + ' </td>\
                                        <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                        <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                            .trn_dr_account_percent : " ") + ' </td>\
                                        <td class="text-center"> ' + (item.tn_name ? item.tn_name : " ") + ' </td>\
                                        <td class="text-center"> ' + (item.tc_name ? item.tc_name : " ") + ' </td>\
                                        <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                                    </tr>');
                    });
                    $('#item_wise_table').DataTable();
                }
            });
        }

        //Get Item type wise data
        itemtypewiseFetch();

        function itemtypewiseFetch() {
            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-itemtypewise') }}",
                dataType: "json",
                success: function(response) {

                    $('#item_type_wise_t_body').html("");
                    $.each(response.itemTypeWiseData, function(key, item) {
                        $('#item_type_wise_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.item_type_name + ' </td>\
                                <td > ' + (item.cr_account_name ? item.cr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                            .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                            .trn_dr_account_percent : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tn_name ? item.tn_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tc_name ? item.tc_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                            </tr>');
                    });
                    $('#item_type_wise_table').DataTable();
                }
            });
        }

        //Get service unit data
        serviceUnitWiseFetch();

        function serviceUnitWiseFetch() {
            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-serviceunit') }}",
                dataType: "json",
                success: function(response) {

                    $('#service_unit_t_body').html("");
                    $.each(response.serviceUnitWiseData, function(key, item) {

                        $('#service_unit_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.serviceunit_name + ' </td>\
                                <td > ' + (item.cr_account_name ? item.cr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                            .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                            .trn_dr_account_percent : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tn_name ? item.tn_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tc_name ? item.tc_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                            </tr>');
                    });
                    $('#service_unit_table').DataTable();
                }
            });
        }

        //Get Acc type wise data
        accTypeDataFetch();

        function accTypeDataFetch() {

            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-acctypewise') }}",
                dataType: "json",
                success: function(response) {

                    $('#acc_type_t_body').html("");
                    $.each(response.accTypeWiseData, function(key, item) {
                        var edit_action =
                            '{{ route('accounts.acc-type-integration-edit', ':id') }}';

                        edit_action = edit_action.replace(':id', item
                            .integrationtrntypewise_no_pk);
                        $('#acc_type_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.cr_account_name + ' </td>\
                                <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                                .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                                .trn_dr_account_percent : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tn_name ? item.tn_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tc_name ? item.tc_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                                <td class="text-center"> ' + (item.serviceunit_name ? item.serviceunit_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_patient_val_ind ? ((item.set_patient_val_ind ==
                                    1) ?
                                '<span class="badge badge-success">Yes</span>' :
                                '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_supplier_val_ind ? ((item
                                    .set_supplier_val_ind == 1) ?
                                '<span class="badge badge-success">Yes</span>' :
                                '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_person_val_ind ? ((item.set_person_val_ind ==
                                    1) ?
                                '<span class="badge badge-success">Yes</span>' :
                                '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.independent_voucher_ind ? ((item
                                    .independent_voucher_ind == 1) ?
                                '<span class="badge badge-success">Yes</span>' :
                                '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> <span class="btn btn-sm btn-primary open-modal" data-id="' +
                            item.integrationtrntypewise_no_pk + '" data-action="' +
                            edit_action + '" data-modal="common-modal-sm" data-title="Edit Account Type Wise" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>\
                            </tr>');
                    });
                    var table = $('#acc_type_wise_table').DataTable();
                    table.destroy();
                    $('#acc_type_wise_table').DataTable({
                        'iDisplayLength': 100
                    });
                }
            });
        }

        //Get Acc type wise data
        accPayrollDataFetch();

        function accPayrollDataFetch() {

            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-accpayroll') }}",
                dataType: "json",
                success: function(response) {

                    $('#acc_payroll_t_body').html("");
                    $.each(response.accPayrollData, function(key, item) {
                        var edit_action =
                            '{{ route('accounts.acc-payroll-integration-edit', ':id') }}';

                        edit_action = edit_action.replace(':id', item
                            .integrationpayroll_no_pk);
                        $('#acc_payroll_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.cr_account_name + ' </td>\
                                <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                                .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                                .trn_dr_account_percent : " ") + ' </td>\
                                <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                                <td class="text-center"> <span class="btn btn-sm btn-primary open-modal" data-id="' +
                            item.integrationpayroll_no_pk + '" data-action="' +
                            edit_action + '" data-modal="common-modal-sm" data-title="Edit Account Type Wise" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>\
                            </tr>');
                    });
                    var table = $('#acc_payroll_table').DataTable();
                    table.destroy();
                    $('#acc_payroll_table').DataTable({
                        'iDisplayLength': 100
                    });
                }
            });
        }

        //Get Cost center data
        costCenterDataFetch();

        function costCenterDataFetch() {
            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-costcenter') }}",
                dataType: "json",
                success: function(response) {

                    $('#cost_center_t_body').html("");
                    $.each(response.costCenter, function(key, item) {
                        $('#cost_center_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.costcenter_name + ' </td>\
                                <td> ' + (item.status ? item.status : " ") + ' </td>\
                                <td> ' + (item.service_unit_no_fk ? item.service_unit_no_fk :
                            " ") + ' </td>\
                                <td > ' + (item.costcenter_desc ? item.costcenter_desc : " ") + ' </td>\
                            </tr>');
                    });
                    $('#cost_center_table').DataTable();
                }
            });
        }

        //Get Cost center child data
        costCenterChildDataFetch();

        function costCenterChildDataFetch() {
            $.ajax({
                type: "GET",
                url: "{{ route('accounts-intregration.fetch-costcenterchild') }}",
                dataType: "json",
                success: function(response) {

                    $('#cost_center_child_t_body').html("");
                    $.each(response.costCenterChildData, function(key, item) {
                        $('#cost_center_child_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.account_name + ' </td>\
                                <td> ' + (item.trn_cr_account_percent ? item
                            .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td> ' + (item.trn_dr_account_percent ? item
                            .trn_dr_account_percent : " ") + ' </td>\
                                <td> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                            </tr>');
                    });
                    $('#cost_center_child_table').DataTable();
                }
            });
        }

        //Item wise item list
        $("#itemWiseItemList").autocomplete({
            source: function(request, response) {
                $.getJSON('{{ url('accounts-intregration/search/item') }}?itemList=' +
                    request
                    .term,
                    function(data) {
                        var array = $.map(data, function(row) {
                            return {
                                value: row.item_name,
                                label: row.item_name,
                                item_id: row.item_no_pk
                            }
                        })
                        response($.ui.autocomplete.filter(array, request.term));

                    })
            },
            select: function(event, ui) {
                $('#item_list_no_pk').val(ui.item.item_id);
            },
            minLength: 2,
            delay: 500

        })

        //cr acc no Auto Complete
        $("#itemWiseCrAccNo,#itemTypeCrAccNo,#serviceUnitrAccNo,#AccTypeWisecrAccNo,#costCenterChildcrAccNo,#AccPayrollcrAccNo")
            .autocomplete({
                source: function(request, response) {
                    $.getJSON('{{ url('accounts-intregration/search/item') }}?crAccount=' +
                        request
                        .term,
                        function(data) {
                            var array = $.map(data, function(row) {
                                return {
                                    value: row.account_name,
                                    label: row.account_name,
                                    item_id: row.account_no_pk
                                }
                            })
                            response($.ui.autocomplete.filter(array, request.term));

                        })
                },
                select: function(event, ui) {
                    $('#itemWiseCrAccNo_pk,#itemTypeCrAccNo_pk,#serviceUnitrAccNo_pk,#AccTypeWisecrAccNo_pk,#costCenterChildcrAccNo_pk,#AccPayrollcrAccNo_pk')
                        .val(ui.item.item_id);
                },
                minLength: 2,
                delay: 500

            })

        //DR acc no Auto Complete
        $("#itemWisedrAccNo,#itemTypedrAccNo,#serviceUnitrDrcNo,#AccTypeWisedrAccNo,#costCenterChilddrAccNo,#AccPayrolldrAccNo")
            .autocomplete({
                source: function(request, response) {
                    $.getJSON('{{ url('accounts-intregration/search/item') }}?draccount=' +
                        request
                        .term,
                        function(data) {
                            var array = $.map(data, function(row) {
                                return {
                                    value: row.account_name,
                                    label: row.account_name,
                                    item_id: row.account_no_pk
                                }
                            })
                            response($.ui.autocomplete.filter(array, request.term));

                        })
                },
                select: function(event, ui) {
                    // $('#itemWiseItemList').val(ui.item.value)
                    $('#itemWisedrAccNo_pk,#itemTypedrAccNo_pk,#serviceUnitrDrcNo_pk,#AccTypeWisedrAccNo_pk,#costCenterChilddrAccNo_pk,#AccPayrolldrAccNo_pk')
                        .val(ui.item.item_id);
                },
                minLength: 2,
                delay: 500

            })

        //Item type wise  Item Type List
        $("#itemTypeList").autocomplete({
            source: function(request, response) {
                $.getJSON(
                    '{{ url('accounts-intregration/search/item') }}?itemtypeListfilter=' +
                    request
                    .term,
                    function(data) {
                        var array = $.map(data, function(row) {
                            return {
                                value: row.item_type_name,
                                label: row.item_type_name,
                                item_id: row.itemtype_no_pk
                            }
                        })
                        response($.ui.autocomplete.filter(array, request.term));

                    })
            },
            select: function(event, ui) {
                // $('#itemWiseItemList').val(ui.item.value)
                $('#item_type_list_no_pk').val(ui.item.item_id);
            },
            minLength: 2,
            delay: 500

        })

        //SYSC_SERVICEUNIT Service Unit List

        $("#serviceunitlist,#costCenterSerUnitNum").autocomplete({
            source: function(request, response) {
                $.getJSON('{{ url('accounts-intregration/search/item') }}?servicUnitList=' +
                    request
                    .term,
                    function(data) {
                        var array = $.map(data, function(row) {
                            return {
                                value: row.serviceunit_name,
                                label: row.serviceunit_name,
                                item_id: row.serviceunit_no_pk
                            }
                        })
                        response($.ui.autocomplete.filter(array, request.term));

                    })
            },
            select: function(event, ui) {
                $('#serviceunitlist_no_pk,#costCenterSerUnitNum_pk').val(ui.item.item_id);
            },
            minLength: 2,
            delay: 500
        })




        // From Data

        // Item wise  form data
        $(document).on('submit', '#item_wise_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#item_wise_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.itemwise') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        $('#item_wise_form_data')[0].reset();
                        alert('Data Added success')
                        itemWiseFetch();

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                }
            });
        });




        //Item Types  form Data
        $(document).on('submit', '#item_type_wise_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#item_type_wise_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.itemtype') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))
                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        itemtypewiseFetch();
                        $('#item_type_wise_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                }
            });
        });

        // service_unit_wise_form_data
        $(document).on('submit', '#service_unit_wise_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#service_unit_wise_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.serviceunit') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        serviceUnitWiseFetch();
                        $('#service_unit_wise_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                }
            });
        });

        //acc_payroll_setup_form_data
        $(document).on('submit', '#acc_payroll_setup_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#acc_payroll_setup_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.payroll') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            z
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        accTypeDataFetch();
                        $('#acc_type_wise_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();

                    accTypeDataFetch();
                }
            });
        });


        //acc_type_wise_form_data
        $(document).on('submit', '#acc_type_wise_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#acc_type_wise_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.acctype') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            z
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        accTypeDataFetch();
                        $('#acc_type_wise_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();

                    accTypeDataFetch();
                }
            });
        });

        $(document).on('click', '#acc_type_wise_form_data_btn', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#acc_type_wise_form_data_edit')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.acctype') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            //z
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        accPayrollDataFetch();
                        $('#acc_type_wise_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                    accTypeDataFetch();
                }
            });
        });


        //payroll edit
        $(document).on('click', '#acc_payroll_form_data_btn', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#acc_payroll_setup_form_data_edit')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.payroll') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            //z
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        accPayrollDataFetch();
                        $('#acc_payroll_setup_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                    accPayrollDataFetch();
                }
            });
        });


        // costCenterChild_form_data
        $(document).on('submit', '#costCenterChild_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#costCenterChild_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.costcenterchild') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else if (data.status == 2) {
                        alert('Cr acc. % must be more than 0 and less than 100 ')
                    } else if (data.status == 3) {
                        alert('DR Account % must be more than 0 and less than 100 ')
                    } else {
                        costCenterChildDataFetch();
                        $('#costCenterChild_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                }
            });
        });

        //costCenter_form_data
        $(document).on('submit', '#costCenter_form_data', function(e) {
            e.preventDefault();
            let itemwisedata = new FormData($('#costCenter_form_data')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('accounts.intregration.store.costcenter') }}",
                data: itemwisedata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.status == 0) {
                        var requiredFill = [];
                        $.each(data.error, function(prefix, val) {
                            requiredFill.push(val[0])
                        })
                        alert(requiredFill.join('<span> > </span>'))

                    } else {
                        costCenterDataFetch();
                        $('#costCenter_form_data')[0].reset();
                        alert('Data Added success')

                    }
                },
                complete: function(data) {

                    $.unblockUI();
                }
            });
        });



    })

    function search_data() {
        var table = $('#acc_type_wise_table').DataTable();
        table.destroy();
        console.log("first call");
        var search_trn_type = $("#search_trn_type").val();
        var search_service_unit = $("#search_service_unit").val();
        var module_code = $("#module_code").val();

        $.ajax({
            type: "POST",
            url: "{{ route('accounts.acc-type-wise-data') }}",
            data: {
                search_trn_type: search_trn_type,
                search_service_unit: search_service_unit,
                module_code: module_code,
            },
            beforeSend: function() {
                blockUI();
                $('#acc_type_t_body').empty("");
            },
            success: function(response) {
                console.log("final call");

                $.each(response.accSearchDataTypeWise, function(key, item) {
                    console.log(item.dr_account_name);

                    var edit_action =
                        '{{ route('accounts.acc-type-integration-edit', ':id') }}';

                    edit_action = edit_action.replace(':id', item
                        .integrationtrntypewise_no_pk);
                    $('#acc_type_t_body').append('<tr>\
                                <th class="text-center" scope="row">' + (key + 1) + '</th>\
                                <td > ' + item.cr_account_name + ' </td>\
                                <td class="text-center"> ' + (item.trn_cr_account_percent ? item
                            .trn_cr_account_percent : " ") + ' </td>\
                                <td > ' + (item.dr_account_name ? item.dr_account_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.trn_dr_account_percent ? item
                            .trn_dr_account_percent : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tn_name ? item.tn_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.tc_name ? item.tc_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.module_code ? item.module_code : " ") + ' </td>\
                                <td class="text-center"> ' + (item.serviceunit_name ? item.serviceunit_name : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_patient_val_ind ? ((item.set_patient_val_ind ==
                                1) ?
                            '<span class="badge badge-success">Yes</span>' :
                            '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_supplier_val_ind ? ((item
                                .set_supplier_val_ind == 1) ?
                            '<span class="badge badge-success">Yes</span>' :
                            '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.set_person_val_ind ? ((item.set_person_val_ind ==
                                1) ?
                            '<span class="badge badge-success">Yes</span>' :
                            '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> ' + (item.independent_voucher_ind ? ((item
                                .independent_voucher_ind == 1) ?
                            '<span class="badge badge-success">Yes</span>' :
                            '<span class="badge badge-danger">No</span>') : " ") + ' </td>\
                                <td class="text-center"> <span class="btn btn-sm btn-primary open-modal" data-id="' +
                        item.integrationtrntypewise_no_pk + '" data-action="' +
                        edit_action + '" data-modal="common-modal-sm" data-title="Edit Account Type Wise" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>\
                            </tr>');
                });

                $('#acc_type_wise_table').DataTable({
                    'iDisplayLength': 100
                });
            },
            complete: function(data) {

                $.unblockUI();
            }
        });

    }
</script>
