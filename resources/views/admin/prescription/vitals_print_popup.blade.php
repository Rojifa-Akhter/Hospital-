<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body>
    <div class="card">
        <main>
            <div class="wrapper">
                <section id="" style=" padding-bottom: 10px;">

                        <a href="{{ route('blank-prescription-form', $appoint_id) }}"
                            class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank"
                            data-id="" title="Print Prescription"><i
                                class="fa fa-prescription"></i> Blank Prescription Print</a>
                                <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data" data-dismiss="modal">Close</button>

                </section>
            </div>
        </main>
    </div>
</body>

</html>
