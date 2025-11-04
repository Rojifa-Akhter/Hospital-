
<main id="page-content">

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <section class="indent_worklist">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-7">
                            <h5 class="mt-2 mb-0">Purchase Account Book</h5>
                            <small>Purchase Account Book</small>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-indent" role="tabpanel"
                                    aria-labelledby="pills-indent-tab">
                                    <form action="" id="PurchaseAccountBookPrintForm" method="POST" target="_blank">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body pb-4">

                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                      </div>
                                                    <div class="col-md-2">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="col-form-label col-form-label-sm"
                                                        for="indent_date_from">Date</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                        id="date" name="date"
                                                        value="{{ date('d-m-Y') }}"
                                                        placeholder="yyyy-mm-dd" autocomplete="off" />

                                                    </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit"
                                                        class="btn btn-info btn-block btn-LG mt-4 print"
                                                        value="1" id="PDF">Export PDF</button>
                                                    </div>
                                                  </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.data-table').DataTable({
        // "ordering": false,
        "searching": true,

    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })


    $('.search_pr').on('click', function() {
        $.ajax({
            url: "{{ route('v1.search-pr-list') }}",
            method: "post",
            data: {
                requsion_no: $('#requsion_no').val(),
                status: $('#status').val(),
                main_store: $('#main_store').val(),
                indent_date_from: $('#indent_date_from').val(),
                indent_date_to: $('#indent_date_to').val()
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                $('.search_indent_list').html(response);
            },
            complete: function() {

                $.unblockUI();
            }
        })

    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        console.log(print);
        if (print == 1) {
            $('form').attr('action', "{{ route('v1.purchase-accounts-book-pdf') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('v1.pr-worklist-excel') }}");
        }
    });
</script>
