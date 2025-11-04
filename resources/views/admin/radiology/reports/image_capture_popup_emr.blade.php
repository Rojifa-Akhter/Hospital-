<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
    <!-- Stylesheet -->
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Rubik", sans-serif;
    }

    body {
        background-color: #f5f8ff;
    }

    .img_container {
        background-color: #ffffff;
        width: 100%;
        min-width: 450px;
        position: relative;
        /* margin: 50px auto; */
        padding: 10px 20px;
        border-radius: 7px;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.05);
    }

    input[type="file"] {
        display: none;
    }

    #label {
        display: block;
        position: relative;
        background-color: #025bee;
        color: #ffffff;
        font-size: 18px;
        text-align: center;
        width: 300px;
        padding: 18px 0;
        margin: auto;
        border-radius: 5px;
        cursor: pointer;
    }

    .img_container p {
        text-align: center;
        margin: 20px 0 30px 0;
    }

    #images {
        width: 90%;
        position: relative;
        margin: auto;
        display: flex;
        justify-content: space-evenly;
        gap: 20px;
        flex-wrap: wrap;
    }

    figure {
        width: 45%;
    }

    img {
        width: 100%;
    }

    figcaption {
        text-align: center;
        font-size: 2.4vmin;
        margin-top: 0.5vmin;
    }

    .AClass {
        right: 0px;
        position: absolute;
    }

    .lb-data .lb-close {
        opacity: 1;
        -webkit-transition: all 0.2s;
        -moz-transition: all 0.2s;
        -o-transition: all 0.2s;
        transition: all 0.2s;
    }

    .lb-outerContainer {

        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 700px !important;
        min-height: 500px !important;
    }
</style>

<body class="hv-100">
    <section>
        <div class="">
            <div class="img_container">
                <div id="images">
                    @include('admin.radiology.reports.image_capture_list_emr')
                </div>
            </div>
        </div>

        <section>
            <script src="{{ asset('js/lightbox.js') }}"></script>
            <script>
                function preview(Element) {
                    let fileInput = document.getElementById("imageUpload");
                    // let fileInput = document.getElementById("imageUpload");
                    let imageContainer = document.getElementById("images");
                    let numOfFiles = document.getElementById("num-of-files");
                    // imageContainer.innerHTML = "";


                    for (i of fileInput.files) {

                        let reader = new FileReader();
                        let figure = document.createElement("a");
                        let main_figure = document.createElement("figure");

                        main_figure.setAttribute("id", "main_figure");

                        let c_span = document.createElement("span");
                        c_span.setAttribute("onclick", "cancel_img(this)");
                        c_span.setAttribute("type", "button");
                        c_span.setAttribute("style", "margin-left:5px");
                        c_span.setAttribute("class", "text-danger");
                        c_span.setAttribute("title", "remove");
                        // c_span.classList.add("text-danger");
                        c_span.innerHTML = "&times";


                        let figCap = document.createElement("input");
                        figCap.setAttribute("style", "margin-bottom:5px");
                        figCap.setAttribute('name', 'caption[]');
                        figCap.setAttribute('class', 'caption');
                        figCap.setAttribute('placeholder', 'Write caption');
                        figCap.setAttribute('value', '');

                        let image = document.createElement("input");
                        image.setAttribute('name', 'image_id[]');
                        image.setAttribute('class', 'image_id');
                        image.setAttribute('type', 'hidden');
                        image.setAttribute('value', '');

                        let hdn_image_name = document.createElement("input");
                        hdn_image_name.setAttribute('name', 'hdn_image_name[]');
                        hdn_image_name.setAttribute('class', 'hdn_image_name');
                        hdn_image_name.setAttribute('type', 'hidden');
                        hdn_image_name.setAttribute('value', '');

                        let newNode = document.createElement("span");
                        let span = document.createElement("span");
                        let button_span = document.createElement("span");


                        figure.appendChild(newNode);


                        main_figure.appendChild(figCap);
                        main_figure.appendChild(c_span);
                        main_figure.appendChild(figure);
                        main_figure.appendChild(image);


                        reader.onload = () => {

                            let img = document.createElement("img");
                            img.setAttribute("src", reader.result);
                            img.setAttribute("style", "width:150px; height:100px; margin-bottom:10px");
                            figure.setAttribute("href", reader.result);
                            figure.setAttribute("data-lightbox", "roadtrip");

                            // button.insertBefore(c_span, button_span);
                            figure.insertBefore(img, newNode);
                            main_figure.insertBefore(figCap, c_span, figure, image);

                        }

                        // imageContainer.appendChild(button);
                        imageContainer.appendChild(main_figure);
                        // imageContainer.appendChild(figure);
                        reader.readAsDataURL(i);
                    }
                    let count = $('figure').length;
                    if (count > 0) {
                        numOfFiles.textContent = `${count} Files Selected`;
                    } else {
                        numOfFiles.textContent = `Choose maximum 20 photo`;
                    }
                    // imageContainer.innerHTML = "";
                    previewCapture(this);

                };

                function cancel_img(element) {
                    if (confirm("Are You Sure ?")) {
                        $(element).parents('figure').remove();
                        let count = $('figure').length;

                        if (count <= 0) {
                            $("#num-of-files").html("Choose maximum 20 photo");
                        } else {
                            $("#num-of-files").html(count + " " + "Files Selected");
                        }
                    }
                }



                function previewCapture(element) {

                    event.preventDefault();
                    var action = "{{ route('radiology.update-image-apointment-preview') }}";
                    var invoice_dtl_id = {{ $id }};
                    var formData = new FormData();
                    var imageFile = $('#imageUpload')[0].files;
                    var caption = $('.caption');
                    var image_id = $('.image_id');
                    var length = $('.caption').length;
                    var array = [];

                    console.log(imageFile);
                    if (length > 20) {
                        // alert("You can only upload a maximum of 20 Photos");
                        return;
                    }
                    var i = 0;
                    for (i = 0; i != length; i++) {
                        let img_id = image_id[i].value ? image_id[i].value : 0;
                        formData.append('img_upload[]', imageFile[i]);
                        formData.append('caption[]', caption[i].value + '_' + image_id[i].value);
                        formData.append('image_id[]', image_id[i].value);

                        // console.log('img_upload[]', imageFile[i].name);
                    }

                    formData.append('capture_id', {{ $id }});


                    $.ajax({
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: action,
                        type: "post",
                        beforeSend: function() {
                            blockUI();
                        },
                        success: function(data) {

                            $("#images").html(data);

                            var formID = $("#frmSearch").attr("id");
                            var formAction = $("#frmSearch").attr("action");
                            var formMethod = $("#frmSearch").attr("method");
                            $.ajax({
                                data: $('#' + formID).serialize(),
                                url: formAction,
                                type: formMethod,

                                success: function(data) {
                                    $("#search-container").html(data);
                                    $.unblockUI();
                                },

                            });
                            // if (data.title == 'Success') {

                            //     $('.common-modal-notify').modal('show');
                            //     $('.common-modal-notify .modal-body').html(
                            //         "<i class='fas fa-stroopwafel fa-spin'></i>");
                            //     $('.common-modal-notify .modal-title').html(data.title);
                            //     $('.common-modal-notify .modal-body').html(data.msg);

                            // }
                        },
                        complete: function() {

                            // $('#exampleModal').on('hidden.bs.modal', function(e) {
                            //         $('#exampleModal').modal('hide')

                            //     })
                            // $('.exampleModal ').modal('hide');
                            // return false;


                            $.unblockUI();
                        }
                    });

                    event.stopImmediatePropagation();
                };

                function capture(element) {

                    event.preventDefault();
                    var action = $(element).attr("data-action");
                    var invoice_dtl_id = $(element).attr("data-dtl-id");
                    var formData = new FormData();
                    var imageFile = $('#imageUpload')[0].files;
                    var caption = $('.caption');
                    var image_id = $('.image_id');
                    var length = $('.caption').length;
                    var array = [];

                    console.log(imageFile);
                    if (length > 20) {
                        alert("You can only upload a maximum of 20 Photos");
                        return;
                    }
                    var i = 0;
                    for (i = 0; i != length; i++) {
                        let img_id = image_id[i].value ? image_id[i].value : 0;
                        formData.append('img_upload[]', imageFile[i]);
                        formData.append('caption[]', caption[i].value + '_' + image_id[i].value);
                        formData.append('image_id[]', image_id[i].value);

                        // console.log('img_upload[]', imageFile[i].name);
                    }

                    formData.append('capture_id', {{ $id }});

                    if (confirm("Are You Sure ?")) {
                        $.ajax({
                            data: formData,
                            processData: false,
                            contentType: false,
                            url: action,
                            type: "post",
                            beforeSend: function() {
                                blockUI();
                            },
                            success: function(data) {
                                var formID = $("#frmSearch").attr("id");
                                var formAction = $("#frmSearch").attr("action");
                                var formMethod = $("#frmSearch").attr("method");
                                $.ajax({
                                    data: $('#' + formID).serialize(),
                                    url: formAction,
                                    type: formMethod,

                                    success: function(data) {
                                        $("#search-container").html(data);
                                    },
                                    complete: function() {
                                        $.unblockUI();
                                    }
                                });
                                if (data.title == 'Success') {

                                    $('.common-modal-notify').modal('show');
                                    $('.common-modal-notify .modal-body').html(
                                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                                    $('.common-modal-notify .modal-title').html(data.title);
                                    $('.common-modal-notify .modal-body').html(data.msg);

                                }
                            },
                            complete: function() {

                                // $('#exampleModal').on('hidden.bs.modal', function(e) {
                                //         $('#exampleModal').modal('hide')

                                //     })
                                $('.exampleModal ').modal('hide');
                                return false;
                                $.unblockUI();
                            }
                        });
                    }
                    event.stopImmediatePropagation();
                };

                function image_delete(element) {
                    if (confirm("Are You Sure ?")) {
                        var id = $(element).attr("data-id");
                        var url = $(element).attr("data-action");
                        console.log(id);
                        $.ajax({
                            data: {
                                id: id
                            },
                            url: url,
                            type: "post",
                            beforeSend: function() {
                                $(element).parents('figure').remove();
                                let count = $('figure').length;
                                if (count <= 0) {
                                    $("#num-of-files").html("Choose maximum 20 photo");
                                } else {
                                    $("#num-of-files").html(count + " " + "Files Selected");
                                }

                                // blockUI();
                            },

                            success: function(data) {
                                // $("#search-container").html(data);

                                var formID = $("#frmSearch").attr("id");
                                var formAction = $("#frmSearch").attr("action");
                                var formMethod = $("#frmSearch").attr("method");
                                $.ajax({
                                    data: $('#' + formID).serialize(),
                                    url: formAction,
                                    type: formMethod,

                                    success: function(data) {
                                        $("#search-container").html(data);
                                    },
                                    complete: function() {
                                        $.unblockUI();
                                    }
                                });
                            },
                            complete: function() {
                                $.unblockUI();
                            }
                        });
                    }
                }
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                })
            </script>
</body>

</html>
