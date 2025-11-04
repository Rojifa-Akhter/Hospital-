function blockUI() {
    $.blockUI({
        message:
            '<h1><i class="fas fa-stroopwafel fa-spin" style="color: #38C172; font-size: 40px;" ></i></h1>',
        overlayCSS: {
            backgroundColor: "#1b2024",
            opacity: 0.8,
            zIndex: 999999,
            cursor: "wait",
        },
        css: {
            border: 0,
            color: "#fff",
            padding: 0,
            zIndex: 9999999,
            backgroundColor: "transparent",
        },
    });
}

function formValidation(formID) {
    $("#" + formID).validate({
        errorElement: "em",
        errorPlacement: function (error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                element.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                error.insertAfter(element.next('.select2-container'));
            } else {
                element.addClass("is-invalid");
                error.insertAfter(element);
            }
        },
        success: function (label, element) {
            const $element = $(element);

            if ($element.hasClass('select2-hidden-accessible')) {
                $element.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            } else {
                $element.removeClass("is-invalid");
            }

            label.remove();
        },
    });

    if ($("#" + formID).valid()) {
        return true;
    } else {
        return false;
    }
}

function loadEditor(element_id) {
    $("#" + element_id).redactor({
        autoresize: false,
        buttonsAdd: ["|", "button1"],
        buttonsCustom: {
            button1: {
                title: "Button",
                callback: function () {
                    callFx();
                },
            },
        },
    });
}

// $.fn.extend({
//     treed: function(o) {
//         var openedClass = 'oi-minus';
//         var closedClass = 'oi-plus';

//         if (typeof o != 'undefined') {
//             if (typeof o.openedClass != 'undefined') {
//                 openedClass = o.openedClass;
//             }
//             if (typeof o.closedClass != 'undefined') {
//                 closedClass = o.closedClass;
//             }
//         };

//         //initialize each of the top levels
//         var tree = $(this);
//         tree.addClass("tree");
//         tree.find('li').has("ul").each(function() {
//             var branch = $(this); //li with children ul
//             branch.prepend("<i class='indicator oi " + closedClass + "'></i>");
//             branch.addClass('branch');
//             branch.on('click', function(e) {
//                 if (this == e.target) {
//                     var icon = $(this).children('i:first');
//                     icon.toggleClass(openedClass + " " + closedClass);
//                     $(this).children().children().toggle();
//                 }
//             })
//             branch.children().children().toggle();
//         });
//         //fire event from the dynamically added icon
//         tree.find('.branch .indicator').each(function() {
//             $(this).on('click', function() {
//                 $(this).closest('li').click();
//             });
//         });
//         //fire event to open branch if the li contains an anchor instead of text
//         tree.find('.branch>a').each(function() {

//             $(this).on('click', function(e) {
//                 $(this).closest('li').click();
//                 e.preventDefault();
//             });
//         });
//         //fire event to open branch if the li contains a button instead of text
//         tree.find('.branch>button').each(function() {
//             $(this).on('click', function(e) {
//                 $(this).closest('li').click();
//                 e.preventDefault();
//             });
//         });
//         // Filter tree
//         $(document).on("keyup", "#txtSearchTree", function() {
//             var that = this,
//             $allListElements = $('.tree ul li');
//             var $matchingListElements = $allListElements.filter(function(i, li) {
//                 var listItemText = $(li).text().toUpperCase(),
//                 searchText = that.value.toUpperCase();
//                 return ~listItemText.indexOf(searchText);
//             });
//             $allListElements.hide();
//             $matchingListElements.show();
//         });
//     }
// });

function displayWindowSize() {
    //alert(1);
}
// menu click
$(function () {
    $(document.body).on("click", "a[rel='tab']", function (e) {
        return false;
    });
    $(document.body).on("click", "a[rel='tab']", function (e) {
        e.preventDefault();

        //blockUI();

        var pageurl = $(this).attr("href");
        var img_path = "images/loader.gif";
        //to get the ajax content and display in div with id 'content'
        $.ajax({
            async: true,
            type: "get",
            url: pageurl,
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $("#page-content").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });

        //to change the browser URL to the given link location
        if (pageurl != window.location) {
            window.history.pushState({ path: pageurl }, "", pageurl);
        }
        //stop refreshing to the page given in
        return false;
    });

    /* $(document).on("click", ".main-menu", function(){
         var menu_id = $(this).attr("data-id");
         var pageurl = $(this).attr("data-route");
         var title = $(this).attr("title");
         $.ajax({
             async: true,
             type: 'post',
             url: pageurl,
             data: {menu_id:menu_id},
             beforeSend: function() {
                 $("#menu_loading").html('<i class="spinner-border spinner-border-sm float-right"></i>');
             },
             success: function(data) {
                 $("#module_name").html(title);
                 $('#menu_list').html(data);
                 $("#menu_loading").html('');

             },
             complete: function(data) {
                     //$.unblockUI();
                 }
             });
         });*/

    $(window).bind("popstate", function () {
        location.reload(true);
        /*$.ajax({
            async: false,
            type:'get',
            url:window.location,
            beforeSend: function () {
                blockUI();
            },
            success: function(data){
                $.unblockUI();
                $('#page-content').html(data);
            }
        });*/
    });

    //window.addEventListener("resize", displayWindowSize);
});

// $('#sidebarCollapse').on('click', function() {

// });
$("#sidebarCollapse").on("click", function () {
    $("#sidebar-left, #content").toggleClass("active");
    if ($(this).find(".indicator").hasClass("glyphicon-chevron-left")) {
        $(this)
            .find(".indicator")
            .removeClass("glyphicon-chevron-left")
            .addClass("glyphicon-chevron-right");
    } else {
        $(this)
            .find(".indicator")
            .removeClass("glyphicon-chevron-right")
            .addClass("glyphicon-chevron-left");
    }
});

$(document).on("click", ".open-modal", function () {
    var id = $(this).attr("data-id");
    var action = $(this).attr("data-action");
    var title = $(this).attr("data-title");
    var modal = $(this).attr("data-modal");
    console.log(id + "_id");

    if (id == "ipd_discount") {
        function isEmpty(el) {
            return !$.trim(el.html());
        }
        if (!isEmpty($("." + modal + " .modal-body"))) {
            $("." + modal).modal("show");
            // $('.' + modal + ' .modal-title').html(title);
        } else {
            $.ajax({
                async: true,
                url: action,
                data: { id: id },
                type: "get",
                beforeSend: function () {
                    blockUI();
                    $("." + modal).modal("show");
                    $("." + modal + " .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $("." + modal + " .modal-title").html(title);
                },
                success: function (data) {
                    $("." + modal + " .modal-body").html(data);
                },
                complete: function (data) {
                    $.unblockUI();
                },
            });
        }
    } else {
        $.ajax({
            async: true,
            url: action,
            data: { id: id },
            type: "get",
            beforeSend: function () {
                blockUI();
                $("." + modal).modal("show");
                $("." + modal + " .modal-body").html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                );
                $("." + modal + " .modal-title").html(title);
            },
            success: function (data) {
                $("." + modal + " .modal-body").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });
    }
});
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function isAModalOpen() {
    return $(".modal.in").length > 0;
}

var dynamicFunc = {
    afterSaveModal: function (responseAction, modalClass, modalTitle) {
        if (responseAction != "") {
            $.ajax({
                async: false,
                url: responseAction,
                type: "get",
                beforeSend: function () {
                    blockUI();
                    if (isAModalOpen) $(".modal").modal("hide");
                    $("." + modalClass).modal("show");
                    console.log(modalClass + "bellal_model");
                    if (modalClass != "")
                        $("." + modalClass).addClass(modalClass);
                    $("." + modalClass + " .modal-title").html(modalTitle);
                    $("." + modalClass + " .modal-body").html("");
                },
                success: function (data) {
                    $("." + modalClass + " .modal-body").html(data);
                },
                complete: function (data) {
                    $.unblockUI();
                },
            });
        }
    },
    afterSaveLoadList: function (responseAction) {
        if (responseAction != "") {
            $.ajax({
                async: false,
                url: responseAction,
                type: "post",
                beforeSend: function () {
                    blockUI();
                    //$('.data-table').DataTable().destroy();
                },
                success: function (data) {
                    $("#page-content").html(data);
                },
                complete: function (data) {
                    $.unblockUI();
                },
            });
        }
    },
    afterSaveLoadPage: function (responseAction) {
        if (responseAction != "") {
            $.ajax({
                async: false,
                url: responseAction,
                type: "get",
                beforeSend: function () {
                    //blockUI();
                    //$('.data-table').DataTable().destroy();
                },
                success: function (data) {
                    $("#page-content").html(data);
                },
                complete: function (data) {
                    //$.unblockUI();
                },
            });
        }
    },
};

function btnSaveUpdate(
    thisElement,
    customFunc = "",
    responesUrl = "",
    modalClass = "",
    modalTitle = "",
    callback = "",
    callbackparam = ""
) {
    event.preventDefault();

    var formID = $(thisElement).parents("form").attr("id");

    var formAction = $(thisElement).parents("form").attr("action");
    var formMethod = $(thisElement).parents("form").attr("method");
    console.log($(thisElement), formAction, formMethod);
    if (formValidation(formID) == false) {
        return false;
    }

    if (confirm("Are You Sure?")) {
        $.ajax({
            async: true,
            data: $("#" + formID).serialize(),
            url: formAction,
            type: formMethod,
            cache: false,
            beforeSend: function () {
                if (customFunc == "") {
                    if (isAModalOpen) $(".modal").modal("hide");
                }
                blockUI();
            },
            success: function (data) {
                if (customFunc == "") {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }
                } else {
                    var response_url = responesUrl + "/" + data.insert_id;
                    if (typeof data.sl != "undefined") {
                        var response_url =
                            responesUrl + "/" + data.insert_id + "/" + data.sl;
                    }

                    if (typeof data.trx_id != "undefined") {
                        var response_url =
                            responesUrl +
                            "/" +
                            data.insert_id +
                            "/" +
                            data.trx_id;
                    }
                    console.log(response_url + "_url");

                    dynamicFunc[customFunc](
                        response_url,
                        modalClass,
                        modalTitle
                    );
                }

                $("#" + formID)
                    .find("input, textarea")
                    .not(".keep_me")
                    .val("");
                $("#" + formID)
                    .find("select")
                    .not(".keep_me")
                    .val("0");
                $("#doctor_info").html("");
                $("#doctor_ref1_info").html("");
                $("#doctor_ref2_info").html("");
                // $('#item_dis_ind').prop('checked', false);
                // $('input[name="item_dis_radio"]').prop('checked', false);

                billingEngine.resetBillForm();
            },
            complete: function () {},
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText);
                error_messages = "";
                for (messages in errors) {
                    console.log(typeof errors[messages]);
                    if (typeof errors[messages] == "object") {
                        // test_data = JSON.parse(errors[messages]);
                        // console.log(test_data);
                        // test_data.forEach(function (item, index) {
                        //     console.log(item, index)
                        // })
                    } else {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }
                }

                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    error_messages
                );

                $.unblockUI();
            },
        }).done(function () {
            $.unblockUI();

            if (callback != "") callback(callbackparam);
        });
    }

    event.stopImmediatePropagation();
}

function btnSaveUpdateWithNewTab(
    thisElement,
    customFunc = "",
    responesUrl = "",
    modalClass = "",
    modalTitle = "",
    callback = "",
    callbackparam = ""
) {
    event.preventDefault();

    var formID = $(thisElement).parents("form").attr("id");

    var formAction = $(thisElement).parents("form").attr("action");
    var formMethod = $(thisElement).parents("form").attr("method");
    console.log($(thisElement), formAction, formMethod);
    if (formValidation(formID) == false) {
        return false;
    }

    if (confirm("Are You Sure?")) {
        $.ajax({
            async: true,
            data: $("#" + formID).serialize(),
            url: formAction,
            type: formMethod,
            cache: false,
            beforeSend: function () {
                if (customFunc == "") {
                    if (isAModalOpen) $(".modal").modal("hide");
                }
                blockUI();
            },
            success: function (data) {
                var response_url = responesUrl + "/" + data.insert_id;
                // console.log(response_url + data.insert_id);
                // window.open(response_url, "_blank");
                // window.history.pushState(
                //     { path: response_url },
                //     "",
                //     data.insert_id
                // );

                // for popup
                $("#common-modal-md .modal-body").html(response_url);
                $("#common-modal-md .modal-title").html("Prescription Preview"); // Optional
                $("#common-modal-md").modal("show");



                $("#" + formID)
                    .find("input, textarea")
                    .not(".keep_me")
                    .val("");
                $("#" + formID)
                    .find("select")
                    .not(".keep_me")
                    .val("0");
                $("#doctor_info").html("");
                $("#doctor_ref1_info").html("");
                $("#doctor_ref2_info").html("");

                billingEngine.resetBillForm();
            },
            complete: function () {},
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText);
                error_messages = "";
                for (messages in errors) {
                    console.log(typeof errors[messages]);
                    if (typeof errors[messages] == "object") {
                        // test_data = JSON.parse(errors[messages]);
                        // console.log(test_data);
                        // test_data.forEach(function (item, index) {
                        //     console.log(item, index)
                        // })
                    } else {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }
                }

                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    error_messages
                );

                $.unblockUI();
            },
        }).done(function () {
            $.unblockUI();

            if (callback != "") callback(callbackparam);
        });
    }

    event.stopImmediatePropagation();
}

function btnSaveUpdateIndent(
    thisElement,
    customFunc = "",
    responesUrl = "",
    modalClass = "",
    modalTitle = "",
    callback = "",
    callbackparam = ""
) {
    event.preventDefault();

    var formID = $(thisElement).parents("form").attr("id");

    var formAction = $(thisElement).parents("form").attr("action");
    var formMethod = $(thisElement).parents("form").attr("method");
    console.log($(thisElement), formAction, formMethod);
    if (formValidation(formID) == false) {
        return false;
    }

    if (confirm("Are You Sure?")) {
        $.ajax({
            async: true,
            data: $("#" + formID).serialize(),
            url: formAction,
            type: formMethod,
            cache: false,
            beforeSend: function () {
                if (customFunc == "") {
                    if (isAModalOpen) $(".modal").modal("hide");
                }
                blockUI();
            },
            success: function (data) {
                if (customFunc == "") {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }
                } else {
                    var response_url = responesUrl + "/" + data.insert_id;
                    if (typeof data.sl != "undefined") {
                        var response_url =
                            responesUrl + "/" + data.insert_id + "/" + data.sl;
                    }

                    if (typeof data.trx_id != "undefined") {
                        var response_url =
                            responesUrl +
                            "/" +
                            data.insert_id +
                            "/" +
                            data.trx_id;
                    }

                    dynamicFunc[customFunc](
                        response_url,
                        modalClass,
                        modalTitle
                    );
                }

                $("#" + formID)
                    .find("input, textarea")
                    .not(".keep_me")
                    .val("");
                $("#" + formID)
                    .find("select")
                    .not(".keep_me")
                    .val("0");
                $("#doctor_info").html("");
                $("#doctor_ref1_info").html("");
                $("#doctor_ref2_info").html("");
                // $('#item_dis_ind').prop('checked', false);
                // $('input[name="item_dis_radio"]').prop('checked', false);

                billingEngine.resetBillForm();

                setTimeout(() => {
                    window.location.href = callbackparam;
                    window.history.pushState(
                        { path: callbackparam },
                        "",
                        callbackparam
                    );
                }, 3000);
            },
            complete: function () {},
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText);
                error_messages = "";
                for (messages in errors) {
                    console.log(typeof errors[messages]);
                    if (typeof errors[messages] == "object") {
                        // test_data = JSON.parse(errors[messages]);
                        // console.log(test_data);
                        // test_data.forEach(function (item, index) {
                        //     console.log(item, index)
                        // })
                    } else {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }
                }

                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    error_messages
                );

                $.unblockUI();
            },
        }).done(function () {
            $.unblockUI();

            if (callback != "") callback(callbackparam);
        });
    }

    event.stopImmediatePropagation();
}

function afterSaveCloseWin() {
    window.history.back();
    // window.close();
}
function btnSaveUpdatefile(
    thisElement,
    customFunc = "",
    responesUrl = "",
    modalClass = "",
    modalTitle = "",
    callback = "",
    callbackparam = ""
) {
    event.preventDefault();

    var formID = $(thisElement).parents("form").attr("id");

    var formAction = $(thisElement).parents("form").attr("action");
    var formMethod = $(thisElement).parents("form").attr("method");

    if (formValidation(formID) == false) {
        return false;
    }
    var formData = new FormData($("#" + formID)[0]);
    if (confirm("Are You Sure?")) {
        $.ajax({
            // async: true,
            data: formData,
            url: formAction,
            type: formMethod,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                if (customFunc == "") {
                    if (isAModalOpen) $(".modal").modal("hide");
                }
                blockUI();
            },
            success: function (data) {
                if (customFunc == "") {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }
                } else {
                    var response_url = responesUrl + "/" + data.insert_id;
                    if (typeof data.sl != "undefined") {
                        var response_url =
                            responesUrl + "/" + data.insert_id + "/" + data.sl;
                    }
                    if (typeof data.trx_id != "undefined") {
                        var response_url =
                            responesUrl +
                            "/" +
                            data.insert_id +
                            "/" +
                            data.trx_id;
                    }
                    console.log(response_url + "_url");

                    dynamicFunc[customFunc](
                        response_url,
                        modalClass,
                        modalTitle
                    );
                }

                $("#" + formID)
                    .find("input, textarea")
                    .not(".keep_me")
                    .val("");
                $("#" + formID)
                    .find("select")
                    .not(".keep_me")
                    .val("0");
                $("#doctor_info").html("");
                $("#doctor_ref1_info").html("");
                $("#doctor_ref2_info").html("");
                // $('#item_dis_ind').prop('checked', false);
                // $('input[name="item_dis_radio"]').prop('checked', false);

                billingEngine.resetBillForm();
            },
            complete: function () {},
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText);
                error_messages = "";
                for (messages in errors) {
                    console.log(typeof errors[messages]);
                    if (typeof errors[messages] == "object") {
                        // test_data = JSON.parse(errors[messages]);
                        // console.log(test_data);
                        // test_data.forEach(function (item, index) {
                        //     console.log(item, index)
                        // })
                    } else {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }
                }

                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    error_messages
                );

                $.unblockUI();
            },
        }).done(function () {
            $.unblockUI();

            if (callback != "") callback(callbackparam);
        });
    }

    event.stopImmediatePropagation();
}

function btnSaveUpdateUpload(
    thisElement,
    customFunc = "",
    responesUrl = "",
    modalClass = "",
    modalTitle = "",
    callback = "",
    callbackparam = ""
) {
    var formID = $(thisElement).parents("form").attr("id");

    if (formValidation(formID) == false) {
        return;
    }
    if (confirm("Are you sure?")) {
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var formData = new FormData($("#" + formID)[0]);

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                if (customFunc == "") {
                    if (isAModalOpen) $(".modal").modal("hide");

                    // $('.common-modal-notify').modal('show');
                    // $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                }
                blockUI();
            },
            success: (data) => {
                if (customFunc == "") {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                    }
                } else {
                    var response_url = responesUrl + "/" + data.insert_id;
                    if (typeof data.sl != "undefined") {
                        var response_url =
                            responesUrl + "/" + data.insert_id + "/" + data.sl;
                    }
                    if (typeof data.trx_id != "undefined") {
                        var response_url =
                            responesUrl +
                            "/" +
                            data.insert_id +
                            "/" +
                            data.trx_id;
                    }
                    console.log(response_url + "_url");

                    dynamicFunc[customFunc](
                        response_url,
                        modalClass,
                        modalTitle
                    );
                }
                $(this).find("input, textarea").not(".keep_me").val("");
                $(this).find("select").not(".keep_me").val("0");
            },
            error: function (data) {
                console.log(data);
            },
            complete: function () {
                $.unblockUI();
            },
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages)
                        .siblings("label")
                        .html();
                    error_messages +=
                        "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] +
                        "</div>";
                }

                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    error_messages
                );
                finished = false;
                $.unblockUI();
            },
        }).done(function () {
            $.unblockUI();

            if (callback != "") callback(callbackparam);
        });
    }
}

function generateReport(thisElement, formID, reportAction) {
    $.ajax({
        data: $("#" + formID).serialize(),
        url: reportAction,
        type: "post",
        beforeSend: function () {
            blockUI();
        },
        success: function (data) {
            $("#financial-list").html(data);
        },
        complete: function () {
            //$(".data-table").DataTable();
            $.unblockUI();
        },
    });
}

$(document).ready(function () {
    $(document).on("change", ".check_all", function (e) {
        var table = $(e.target).parents("table");
        $(".is_check", table).attr("checked", e.target.checked);
    });

    $("#accordian h3, span").click(function () {
        var link = $(this);
        var closest_ul = link.closest("ul");
        var parallel_active_links = closest_ul.find(".active");
        var closest_li = link.closest("li");
        var link_status = closest_li.hasClass("active");
        var count = 0;

        closest_ul.find("ul").slideUp(function () {
            if (++count == closest_ul.find("ul").length)
                parallel_active_links.removeClass("active");
        });

        if (!link_status) {
            closest_li.children("ul").slideDown();
            closest_li.addClass("active");
        }
    });

    $(document).on("keyup paste", ".number_only", function () {
        this.value = this.value.replace(/[^0-9.]/g, "");
    });
});

function getDropdownListByCondition(thisElement, action_url, target_element) {
    var element_id = $(thisElement).val();
    var option_list = "<option value='0'>Select</option>";
    $.ajax({
        async: true,
        url: action_url,
        data: { element_id: element_id },
        type: "post",
        beforeSend: function () {
            $("#" + target_element).html("");
            blockUI();
        },
        success: function (data) {
            data = $.parseJSON(data);
            $.each(data.list_arr, function (i, item) {
                option_list +=
                    "<option value='" + i + "'>" + item + "</option>";
            });
            $("#" + target_element).append(option_list);
        },
        complete: function (data) {
            $.unblockUI();
        },
    });
}

function getDropdownListByConditionArray(
    thisElement,
    action_url,
    target_element
) {
    var element_id = $(thisElement).val();
    var option_list = "<option value='0'>Select</option>";
    $.ajax({
        async: true,
        url: action_url,
        data: { element_id: element_id },
        type: "post",
        beforeSend: function () {
            $("#" + target_element).html("");
            blockUI();
        },
        success: function (data) {
            data = $.parseJSON(data);
            $.each(data.list_arr, function (i, item) {
                option_list +=
                    "<option value='" +
                    item.doctor_id +
                    "'>" +
                    item.doctor_name +
                    "</option>";
            });
            $("#" + target_element).append(option_list);
        },
        complete: function (data) {
            $.unblockUI();
        },
    });
}

function removeById(thisElement) {
    if (confirm("Are you sure?")) {
        var action_url = $(thisElement).attr("data-url");
        var data_id = $(thisElement).attr("data-id");

        $.ajax({
            async: true,
            url: action_url,
            data: { data_id: data_id },
            type: "get",
            beforeSend: function () {
                blockUI();
                $(".common-modal-notify").modal("show");
                $(".common-modal-notify .modal-body").html("");
            },
            success: function (data) {
                $(thisElement).parents("tr").remove();
                $(".common-modal-notify .modal-title").html(data.title);
                $(".common-modal-notify .modal-body").html(data.msg);
            },
            complete: function (data) {
                $.unblockUI();
            },
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(errors.msg);

                $.unblockUI();
            },
        });
    }
    return;
}

function cancelById(thisElement) {
    if (confirm("Are you sure?")) {
        var action_url = $(thisElement).attr("data-url");
        var data_id = $(thisElement).attr("data-id");

        $.ajax({
            async: true,
            url: action_url,
            data: { data_id: data_id },
            type: "post",
            beforeSend: function () {
                blockUI();
                $(".common-modal-notify").modal("show");
                $(".common-modal-notify .modal-body").html("");
            },
            success: function (data) {
                $(thisElement).parents("tr").remove();
                $(".common-modal-notify .modal-title").html(data.title);
                $(".common-modal-notify .modal-body").html(data.msg);
            },
            complete: function (data) {
                $.unblockUI();
            },
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(errors.msg);

                $.unblockUI();
            },
        });
    }
    return;
}

function removeTableRowOnly(thisElement) {
    var hospital_code = $("#hospital_code").val();

    if (hospital_code == "EWMCH") {
        $(thisElement).parents("tr").remove();
    } else {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        if (hospital_code == "UNICO" || hospital_code == "DMHL") {
            previewTab();
        }
        return;
    }
}

function removeParentElement(thisElement) {
    var hospital_code = $("#hospital_code").val();
    if (hospital_code == "EWMCH") {
        $(thisElement).parent().remove();
    } else {
        if (confirm("Are you sure?")) {
            $(thisElement).parent().remove();
        }
        if (hospital_code == "UNICO" || hospital_code == "DMHL") {
            previewTab();
        }
        return;
    }
}

/*#####present address and parmanent address same ##########  */

// $(document).on('input', '.same_as_pre_add', function() {

//     if ($(".same_pre_and_par").prop('checked') == true) {
//         $('.same_as_par_add').val($(this).val()).attr('readonly', true);
//     }
//     else {
//         $('.same_as_par_add').val().removeAttr('readonly');
//     }

// });

// $(document).on('change', '.same_pre_and_par', function() {
//     if (this.checked) {
//         var present_addres = $(".same_as_pre_add").val();
//         $(".same_as_par_add").val(present_addres).attr('readonly', true);
//     } else {
//         $('.same_as_par_add').val('').removeAttr('readonly');
//     }
// });
/*##### END present address and parmanent address same ##########  */

var appointmentEngine = {
    searchAppointment: function (thisElement) {
        var page_view_type = $("#page-view-type").val();
        var formID = $("#frmAppointmentSearch").attr("id");
        var formAction = $("#frmAppointmentSearch").attr("action");
        var formMethod = $("#frmAppointmentSearch").attr("method");

        $.ajax({
            data: $("#" + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function () {
                blockUI();
                // $('.data-table').DataTable().destroy();
            },
            success: function (data) {
                $(".container-fluid").html(data);
            },
            complete: function () {
                // $('.data-table').DataTable({
                //     "ordering": false
                // });
                $.unblockUI();
            },
        });
    },
    saveAppointment: function (thisElement) {
        // Validation
        let _checkValue = $("input[name=patient_type]:checked").val();
        if (_checkValue == "1") {
            let _hdn_patient_id = $("#hdn_patient_id").val();
            if (_hdn_patient_id == "") {
                alert("Plese select Patient ID for registered type");
                return;
            }
        }

        var action = $(thisElement).attr("data-response_action");
        var redirect_action = $(thisElement).attr("data-redirect-action");
        var is_pay_consultation = $("#is_pay_consultation").val();
        var hdn_doctor_id = $("#hdn_doctor_id").val();
        var pay = $("#sales_price").html();
        if (hdn_doctor_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Doctor"
            );
            return;
        }

        //formValidation("frmCreateAppointment");

        // if (pay != "") {
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Appointment Consultation Invoice",
            dynamicFunc.afterSaveLoadPage,
            redirect_action
        );
        // } else {
        //     alert("Doctor fee not available")
        //     // btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, redirect_action);
        // }
    },

    saveAppointmentForPatient: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var redirect_action = $(thisElement).attr("data-redirect_action");
        var is_pay_consultation = $("#is_pay_consultation").val();
        var hdn_doctor_id = $("#hdn_doctor_id").val();
        var pay = $("#sales_price").html();
        if (hdn_doctor_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Doctor"
            );
            return;
        }

        //formValidation("frmCreateAppointment");

        // if (pay != "") {
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Appointment Consultation Invoice",
            dynamicFunc.afterSaveLoadPage,
            redirect_action
        );
        // } else {
        //     alert("Doctor fee not available")
        //     // btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, redirect_action);
        // }
    },

    saveFirstRefferal: function (thisElement) {
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");

        $.ajax({
            data: $("#" + formID).serialize(),
            url: formAction,
            type: formMethod,
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $("#hdn_first_refer").val(data.insert_id);
                //$("#first_refer").val(data.last_name);
                alert(data.last_name);
                $("#first_refer").typeahead("val", data.last_name);

                $("#doctor_quick_reg_form")[0].reset();
                $("#exampleModal").modal("hide");
            },
        }).done(function () {
            $.unblockUI();
        });
    },
    cancelAppointment: function (thisElement) {
        btnSaveUpdate(
            thisElement,
            "",
            "",
            "",
            "",
            appointmentEngine.searchAppointment,
            thisElement
        );
    },
    payConsultationBill: function (thisElement) {
        var action = $(thisElement).attr("data-action");
        var response_action = $(thisElement).attr("data-response-action");

        if (confirm("Are You Sure?")) {
            $.ajax({
                url: action,
                type: "get",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    dynamicFunc.afterSaveModal(
                        response_action,
                        "common-modal-md",
                        "Consultation Invoice"
                    );
                },
                complete: function () {
                    appointmentEngine.searchAppointment($(thisElement));
                    $.unblockUI();
                },
            });
        }
    },
    printAppointmentCarrd: function (thisElement) {
        /*var printContents 		= document.getElementById("appointment_card").innerHTML;
        var originalContents 	= document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;*/

        var divContents = document.getElementById("appointment_card").innerHTML;
        var a = window.open("", "", "");
        a.document.write("<html>");
        a.document.write(
            '<body style="text-align:center; width:78mm; margin:0px;">'
        );
        a.document.write(divContents);
        a.document.write("</body></html>");
        a.document.close();
        a.print();
    },
};

$(document).on("change", ".patient_type", function () {
    var checkValue = $("input[name=patient_type]:checked").val();
    if (checkValue == "2") {
        $(".non_registered_patient").removeClass("d-none");
        $(".registered_patient").addClass("d-none");
    } else {
        $(".registered_patient").removeClass("d-none");
        $(".non_registered_patient").addClass("d-none");
    }
});

var prescriptionFunc = {
    savePrescription: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();
        var acup_item_name_1 = $("#acup_item_name_1").val();
        var et_item_name_1 = $("#et_item_name_1").val();
        var te_item_name_1 = $("#te_item_name_1").val();
        var investigation_item = $("#investigation_item").val();
        var investigation_findings = $("#investigation_findings").val();
        var procedure_item = $("#procedure_item").val();
        var disposal_item = $("#disposal_item").val();
        var advice = $("#advice").val();
        var instruction = $("#instruction_0").val();
        var medicine_item_0 = $("#medicine_item_0").val();
        if (acup_item_name_1) {
            alert("Please add TCM by clicking plus button");
            return false;
        }
        if (et_item_name_1) {
            alert("Please add Electro Therapy by clicking plus button");
            return false;
        }
        if (te_item_name_1) {
            alert("Please add Therapeutic Exercise by clicking plus button");
            return false;
        }
        if (te_item_name_1) {
            alert("Please add Therapeutic Exercise by clicking plus button");
            return false;
        }
        if (investigation_item) {
            alert(
                "Please add Investigation / Procedure by clicking 'Add for this Prescription only' on pop-up"
            );
            return false;
        }
        if (investigation_findings) {
            alert(
                "Please add Investigation Findings by clicking 'Add for this Prescription only' on pop-up"
            );
            return false;
        }
        if (procedure_item) {
            alert(
                "Please add Plan by clicking 'Add for this Prescription' on pop-up"
            );
            return false;
        }
        if (disposal_item) {
            alert(
                "Please add Disposal by clicking 'Add for this Prescription' on pop-up"
            );
            return false;
        }
        if (advice) {
            alert(
                "Please add Advice by clicking 'Add for this Prescription only' on pop-up"
            );
            return false;
        }

        // if (instruction) {
        //     alert(
        //         "Please add Instruction by clicking 'Add for this Prescription only' on pop-up"
        //     );
        //     return false;
        // }
        if (medicine_item_0) {
            alert("Please add Medicine by clicking plus button");
            return false;
        }
        if (patient_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Patient"
            );
            return;
        }

        /*var flag = false;
        $(".left-element").each(function () {
            if (this.value != '') {
                flag = true;
                return false;
            }
        });

        if (!flag) {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html("You did not select any Chief Complaints");
        }
        else
        {
            var action = $(thisElement).attr("data-response_action");
            var riderect_action = $("#hdn_current_url").val();
            var items = $('input[name="item_name[]"]');
            var appointment_date = $("#hdn_appointment_date").val();
            var hdn_eye_ind = $("#hdn_eye_ind").val();

            if(hdn_eye_ind == 1)
            {
                btnSaveUpdate($(thisElement),'afterSaveModal', action, 'common-modal-md','Prescription', dynamicFunc.afterSaveLoadPage,riderect_action);
            }
            else
            {
                btnSaveUpdate($(thisElement),'afterSaveModal', action, 'common-modal-md','Prescription', dynamicFunc.afterSaveLoadPage,riderect_action);
            }
        }*/

        var action = $(thisElement).attr("data-response_action");
        var riderect_action = $("#hdn_current_url").val();
        var items = $('input[name="item_name[]"]');
        var appointment_date = $("#hdn_appointment_date").val();
        var hdn_eye_ind = $("#hdn_eye_ind").val();
        console.log(action, riderect_action, $(thisElement));
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Prescription",
            dynamicFunc.afterSaveLoadPage,
            riderect_action
        );
    },
    savePrescriptionUhlv2: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();
        var validations = {
            acup_item_name_1: $("#acup_item_name_1").val(),
            et_item_name_1: $("#et_item_name_1").val(),
            te_item_name_1: $("#te_item_name_1").val(),
            investigation_item: $("#investigation_item").val(),
            investigation_findings: $("#investigation_findings").val(),
            procedure_item: $("#procedure_item").val(),
            disposal_item: $("#disposal_item").val(),
            advice: $("#advice").val(),
            medicine_item_0: $("#medicine_item_0").val(),
        };

        for (var key in validations) {
            if (validations[key]) {
                alert(
                    "Please add " +
                        key.replace(/_/g, " ") +
                        " by clicking the plus button"
                );
                return false;
            }
        }

        if (!patient_id) {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Patient"
            );
            return;
        }

        var action = $(thisElement).attr("data-response_action");
        var redirect_action = $("#hdn_current_url").val();

        // Save the prescription
        // btnSaveUpdateWithNewTab(
        //     $(thisElement),
        //     "afterSaveModal",
        //     action,
        //     "common-modal-md",
        //     "Prescription",
        //     dynamicFunc.afterSaveLoadPage,
        //     redirect_action
        // );
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Prescription",
            dynamicFunc.afterSaveLoadPage,
            redirect_action
        );
    },
    saveOpdNurseStationVitals: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();

        // if (patient_id == "") {
        //     $('.common-modal-notify-error').modal('show');
        //     $('.common-modal-notify-error .modal-title').html("Validation Error");
        //     $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
        //     return;
        // }

        var action = $(thisElement).attr("data-response_action");
        var riderect_action = $("#opd_nurse_vital_redirect_action").val(); //route('appointments.opd-nurse-station');
        var items = $('input[name="item_name[]"]');
        var appointment_date = $("#hdn_appointment_date").val();
        var hdn_eye_ind = $("#hdn_eye_ind").val();
        // btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, riderect_action);
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-sm",
            "Vitals",
            dynamicFunc.afterSaveLoadPage,
            riderect_action
        );
    },

    appointmentListByDate: function (appointment_date) {
        $.ajax({
            url: "get-appointment-list-by-date/" + appointment_date,
            type: "get",
            beforeSend: function () {
                //blockUI();
            },
            success: function (data) {
                $("#appointment-list").html(data);
            },
            complete: function (data) {
                //$.unblockUI();
            },
        });
    },
    patientPrescriptionDetails: function (thisElement) {
        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var prescription_type = $(thisElement).attr("data-presc-type");
        console.log(prescription_type);
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $.ajax({
            url: action,
            type: "get",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                var patient_id = data["patient_id"];
                var chronic = data["chronic_disease"];
                var allergy = data["allergie_data"];
                var investigation = data["investigation_data"];
                var chro_dis = "";
                var chor_hdn = "";
                var chor_text = "";
                var chor_hdn_text = "";
                var allergy_text = "";
                $("#chronic_con").html("");

                if (Array.isArray(chronic) && chronic.length > 0) {
                    chronic.forEach(function(item) {
                        var chor_text = item.chronic_dis_description || "";
                        $("#chronic_con").append(
                        `<span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1" style="font-size:10px;" onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm" data-action="${disease_action}">${item.chronic_dis_name}</span>`
                        );
                        chor_hdn += item.chronic_dis_item_pk_no_fk + "_" + item.chronic_dis_name + "*";
                        chor_hdn_text += item.chronic_dis_item_pk_no_fk + "_" + chor_text + "*";
                    });
                    } else {
                    // Optional: show placeholder or message when no records exist
                    $("#chronic_con").append(
                        '<small class="text-muted">No chronic diseases to show.</small>'
                    );
                    }

                // chronic.forEach(function (item) {
                //     var chor_text =
                //         item.chronic_dis_description != null
                //             ? item.chronic_dis_description
                //             : "";
                //     $("#chronic_con").append(
                //         `<span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1" style="font-size:10px;" onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm" data-action="${disease_action}">${item.chronic_dis_name}</span>`
                //     );
                //     chor_hdn +=
                //         item.chronic_dis_item_pk_no_fk +
                //         "_" +
                //         item.chronic_dis_name +
                //         "*";
                //     chor_hdn_text +=
                //         item.chronic_dis_item_pk_no_fk + "_" + chor_text + "*";
                // });
                allergy.forEach(function (aller) {
                    $("#allergy_con").append(
                        `<span><span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal" style="font-size:10px;" data-modal="common-modal-md" data-action=" route('add-allergy') ">${aller.allergies_name}</span> <sup><i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2" data-allergyid="${aller.pat_allergies_no_pk}"></i></sup></span></span>`
                    );
                });

                // investigation start
                investigation.forEach(function (item) {
                    $("#investigation").append(
                        `<span><span >${item.prescrition_data}</span></span>`
                    );
                });

                console.log("Age :" + data["appointments"].pat_age);
                // Investigation end

                $("#chrn-items").val(chor_hdn);
                $("#chronic_text").val(chor_hdn_text);

                //$("#patient_name").html('');
                var mobile = data["appointments"].mobile1 ?? "";
                var occupation = data["appointments"].occupation ?? "";
                $("#hdn_appointment_id").val(
                    data["appointments"].appoint_no_pk
                );
                $("#hdn_patient_id").val(data["appointments"].patient_no_pk);
                $("#hdn_patient_code").val(data["appointments"].patient_code);
                $("#patient_name").html(
                    "Name :" + data["appointments"].patient_name
                );
                $("#patient_age").html("Age :" + data["appointments"].pat_age);
                $("#maritial_status").html(
                    "Marritial Status :" +
                        data["appointments"].marital_status_txt
                );
                $("#patient_mobile").html("Mobile :" + mobile);
                $("#patient_occupation").html("Occupation :" + occupation);

                var today = moment().format("DD/MM/YYYY");
                var comp = moment(
                    data["vitals"].au_entry_at,
                    "YYYY-MM-DD"
                ).format("DD/MM/YYYY");
                var todayMoment = moment(today, "DD/MM/YYYY");
                var compMoment = moment(comp, "DD/MM/YYYY");

                // var pres_date = $("tr.bg-success").attr('data-date');
                // var prescrip_date = moment(pres_date, "YYYY-MM-DD").format("DD/MM/YYYY");
                //  prescrip_date = moment(prescrip_date, "DD/MM/YYYY");

                // if(todayMoment.isSame(prescrip_date)) {
                //     console.log('prev prescription')
                //     $("#txt_pulse").val(data["vitals"].pulse_val);
                //     $("#txt_bp_sys").val(data["vitals"].bp_val_sys);
                //     $("#txt_bp_dia").val(data["vitals"].bp_val_dia);
                //     $("#txt_bp").val(data["vitals"].bp_val_sys);
                //     $("#txt_temperature").val(data["vitals"].temp_val);
                //     $("#txt_height").val(data["vitals"].height_val);
                //     $("#txt_weight").val(data["vitals"].weight_val);
                //     $("#txt_ofc").val(data["vitals"].ofc);
                //     $("#txt_bmi").val(data["vitals"].bmi);
                //     $("#txt_heart_rate").val(data["vitals"].bmi);
                // }
                let vital_date = new Date(data["vitals"].au_entry_at);
                let dateObject = new Date();

                var day = String(dateObject.getDate()).padStart(2, "0");
                var month = String(dateObject.getMonth() + 1).padStart(2, "0");
                var year = dateObject.getFullYear();
                var formattedDate = day + "/" + month + "/" + year;

                var vitals_day = String(vital_date.getDate()).padStart(2, "0");
                var vitals_month = String(vital_date.getMonth() + 1).padStart(
                    2,
                    "0"
                );
                var vitals_year = vital_date.getFullYear();
                var vitals_formattedDate =
                    vitals_day + "/" + vitals_month + "/" + vitals_year;

                // console.log(formattedDate, vitals_formattedDate);
                // vital_date.getDate() == dateObject.getDate()
                if (
                    formattedDate == vitals_formattedDate &&
                    data["vitals"].patient_no_fk == patient_id
                ) {
                    $("#txt_pulse").val(data["vitals"].pulse_val);
                    $("#txt_bp_sys").val(data["vitals"].bp_val_sys);
                    $("#txt_bp_dia").val(data["vitals"].bp_val_dia);
                    $("#txt_bp").val(data["vitals"].bp_val_sys);
                    $("#txt_temperature").val(data["vitals"].temp_val);
                    $("#txt_height").val(data["vitals"].height_val);
                    $("#txt_weight").val(data["vitals"].weight_val);
                    $("#txt_ofc").val(data["vitals"].ofc);
                    $("#txt_bmi").val(data["vitals"].bmi);
                    $("#txt_heart_rate").val(data["vitals"].bmi);
                } else if (
                    formattedDate == vitals_formattedDate ||
                    data["vitals"].patient_no_fk == patient_id
                ) {
                } else {
                    $("#txt_pulse").val("");
                    $("#txt_bp_sys").val("");
                    $("#txt_bp_dia").val("");
                    $("#txt_bp").val("");
                    $("#txt_temperature").val("");
                    $("#txt_height").val("");
                    $("#txt_weight").val("");
                    $("#txt_ofc").val("");
                    $("#txt_bmi").val("");
                    $("#txt_heart_rate").val("");
                }

                // $("#txt_heart_rate").val(data["vitals"].heart_condition);
                $("#txt_lung_condition").val(data["vitals"].lung_condition);
                $("#txt_bowel_condition").val(data["vitals"].bowel_condition);
                $("#sfh").val(data["vitals"].sfh);
                $("#fm").val(data["vitals"].fm);
                $("#fhs").val(data["vitals"].fhs);
                $("#pr").val(data["vitals"].pr);
                $("#hq").val(data["vitals"].hq);
                $("#swelling").val(data["vitals"].swelling);
                $("#scar_work").val(data["vitals"].scar_work);
                $("#tenderness").val(data["vitals"].tenderness);
                $("#pae_note").val(data["vitals"].pae_note);

                $("#txt_bladder_condition").val(
                    data["vitals"].bladder_condition
                );

                // chronic hide show

                $("#c_diesease").hide();

                // if(temp == 'TEMP'){
                //     $("#hdn_prescription_id").val('');
                //   console.log(app_id+'bellal')
                //     $("#hdn_appointment_id").val(app_id);
                // }else{
                //     $("#hdn_prescription_id").val(
                //         data["vitals"].prescription_no_fk
                //     );
                // }

                if (temp == "TEMP") {
                    if (prescription_type == "pre") {
                        console.log($("#hdn_prescription_id").val());
                        $("#hdn_prescription_id").val(
                            $("#hdn_prescription_id").val()
                        );
                        console.log($("#hdn_prescription_id").val() + "test");
                        $("#hdn_appointment_id").val(app_id);
                    } else {
                        $("#hdn_prescription_id").val("");
                        console.log(app_id + "bellal");
                        $("#hdn_appointment_id").val(app_id);
                    }
                } else {
                    console.log(data["vitals"]);
                    $("#hdn_prescription_id").val(
                        data["vitals"].prescription_no_fk
                    );
                }
            },
            complete: function (data) {
                $(thisElement).parents("tr").addClass("bg-success");
                var prescription_id = $(thisElement).attr("data-presc");
                var dtls_action = $(thisElement).attr("data-dtls-action");
                var hdn_appointment_id = $("#hdn_appointment_id").val();

                // $.unblockUI();
                $.ajax({
                    data: {
                        hdn_su_no: hdn_su_no,
                        hdn_appointment_id: hdn_appointment_id,
                    },
                    url: dtls_action,
                    type: "get",
                    beforeSend: function () {
                        blockUI();
                    },
                    success: function (data) {
                        $("#presc_details").html("");
                        $("#presc_details").html(data);
                    },
                    complete: function (data) {
                        $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                        $.unblockUI();
                    },
                });
            },
        });
    },

    patientEmrgencyPrescriptionDetails: function (thisElement) {
        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var hdn_su_no = $("#hdn_su_no").val();

        $.ajax({
            url: action,
            type: "get",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                //  console.log(data)
                var chronic = data["chronic_disease"];
                var allergy = data["allergie_data"];
                var investigation = data["investigation_data"];
                //console.log(allergy);
                var chro_dis = "";
                var chor_hdn = "";
                var chor_text = "";
                var chor_hdn_text = "";
                var allergy_text = "";

                // chronic.forEach(function (item) {
                //     var chor_text = item.chronic_dis_description != null ? item.chronic_dis_description : "";
                //     $('#chronic_con').append(`<span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1" style="font-size:10px;" onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm" data-action="route(add-chronic-disease)">${item.chronic_dis_name}</span>`);
                //     chor_hdn += item.chronic_dis_item_pk_no_fk + "_" + item.chronic_dis_name + "*";
                //     chor_hdn_text += item.chronic_dis_item_pk_no_fk + "_" + chor_text + "*";
                // });
                //allergy.forEach(function (aller) {

                //$('#allergy_con').append(`<span><span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal" style="font-size:10px;" data-modal="common-modal-md" data-action=" route('add-allergy') ">${aller.allergies_name}</span> <sup><i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2" data-allergyid="${aller.pat_allergies_no_pk}"></i></sup></span></span>`);

                //});

                if (Array.isArray(allergy)) {
                    allergy.forEach(function (aller) {
                        $("#allergy_con").append(
                            `<span><span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal" style="font-size:10px;" data-modal="common-modal-md" data-action=" route('add-allergy') ">${aller.allergies_name}</span> <sup><i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2" data-allergyid="${aller.pat_allergies_no_pk}"></i></sup></span></span>`
                        );
                    });
                }

                // // investigation start
                // investigation.forEach(function(item){
                //     $('#investigation').append(`<span><span >${item.prescrition_data}</span></span>`);

                // })
                // Investigation end

                $("#chrn-items").val(chor_hdn);
                $("#chronic_text").val(chor_hdn_text);

                //$("#patient_name").html('');
                var mobile = data["prescription_dtl"].mobile1 ?? "";
                var occupation = data["prescription_dtl"].occupation_name ?? "";
                // $("#hdn_appointment_id").val(data['appointments'].appoint_no_pk);
                $("#hdn_patient_id").val(
                    data["prescription_dtl"].patient_no_pk
                );
                $("#hdn_patient_code").val(
                    data["prescription_dtl"].patient_code
                );
                $("#patient_name").html(
                    "Name :" + data["prescription_dtl"].patient_name
                );
                $("#patient_age").html("Age :" + data["prescription_dtl"].age);
                $("#patient_mobile").html("Mobile :" + mobile);
                $("#patient_occupation").html("Occupation :" + occupation);

                $("#hdn_prescription_id").val(
                    data["vitals"].prescription_no_fk
                );
                $("#txt_pulse").val(data["vitals"].pulse_val);
                $("#txt_bp").val(data["vitals"].bp_val_sys);
                $("#txt_temperature").val(data["vitals"].temp_val);
                $("#txt_height").val(data["vitals"].height_val);
                $("#txt_weight").val(data["vitals"].weight_val);
                $("#txt_ofc").val(data["vitals"].ofc);
                $("#txt_bmi").val(data["vitals"].bmi);
                $("#txt_heart_rate").val(data["vitals"].bmi);
                $("#txt_bp_sys").val(data["vitals"].bp_val_sys);
                $("#txt_bp_dia").val(data["vitals"].bp_val_dia);
                $("#txt_heart_rate").val(data["vitals"].heart_condition);
                $("#txt_lung_condition").val(data["vitals"].lung_condition);
                $("#txt_bowel_condition").val(data["vitals"].bowel_condition);
                $("#txt_bladder_condition").val(
                    data["vitals"].bladder_condition
                );
                console.log(data["vitals"]);
            },
            complete: function (data) {
                $(thisElement).parents("tr").addClass("bg-success");
                var prescription_id = $(thisElement).attr("data-presc");
                var dtls_action = $(thisElement).attr("data-dtls-action");
                var hdn_appointment_id = $("#hdn_appointment_id").val();

                // $.unblockUI();
                $.ajax({
                    data: {
                        hdn_su_no: hdn_su_no,
                        hdn_appointment_id: hdn_appointment_id,
                    },
                    url: dtls_action,
                    type: "get",
                    beforeSend: function () {
                        blockUI();
                    },
                    success: function (data) {
                        // console.log(data)
                        $("#presc_details").html("");
                        $("#presc_details").html(data);
                    },
                    complete: function (data) {
                        //   console.log('complete'+ data)
                        $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                        $.unblockUI();
                    },
                });
                // if (prescription_id != "") {
                // } else {
                //     $.unblockUI();
                // }
            },
        });
    },
    // This function no need just add here for purpose of when i will check Physcio Presciption
    // patientPrescriptionDetails: function (thisElement) {
    //     $(thisElement).parents('table').find('tr').removeClass("bg-light-blue");
    //     var action = $(thisElement).attr("data-action");
    //     var prescription_id = $(thisElement).attr("data-presc");
    //     var prescription_type = $(thisElement).attr("data-presc-type");
    //     var hdn_su_no = $("#hdn_su_no").val();
    //     $("#continue_med_con, #path_con, #rad_con, #patient_name_other, #patient_age_other, #chrn-items, #chronic_con, #allergy_con").html('');
    //     $.ajax({
    //         url: action,
    //         type: "get",
    //         beforeSend: function () {
    //             blockUI();
    //         },
    //         success: function (data) {

    //             $("#hdn_patient_id").val(data['appointments'].patient_no_fk);
    //             $("#hdn_service_id").val(data['appointments'].service_number);
    //             $("#patient_name").html(data['appointments'].patient_name_rank);
    //             $("#patient_age").html("Age: " + data['appointments'].age);

    //             if (data['appointments'].patient_photo != null) {
    //                 var patient_img_path = $("#patient_img").attr("data-path") + "/" + data['appointments'].patient_photo;
    //                 $("#patient_img").html("<img width='30' src='" + patient_img_path + "'>");
    //             }

    //             if (data['appointments'].ref_patient_photo != null) {
    //                 var ref_patient_img_path = $("#patient_img").attr("data-path") + "/" + data['appointments'].ref_patient_photo;
    //                 $("#ref_patient_img").html("<img width='30' src='" + ref_patient_img_path + "'>");
    //             }
    //             $("#patient_mobile").html(data['appointments'].mobile1);

    //             if (data['appointments'].patient_type != "SRV") {
    //                 $("#patient_name_other").html(data['appointments'].ref_patient_name_rank);
    //                 var ref_service_number_relation = data['appointments'].ref_service_number + ", " + data['appointments'].pat_relation;
    //                 $("#patient_age_other").html(ref_service_number_relation);
    //             }

    //             $("#hdn_prescription_id").val(prescription_id);

    //             if (prescription_type != 'pre') {
    //                 $("#hdn_appointment_id").val(data['appointments'].patapp_no_pk);
    //                 $("#hdn_doctor_id").val(data['appointments'].doctor_person_no_fk);
    //             }

    //             if (data['vitals'] != null) {
    //                 $("#txt_pulse").val(data['vitals'].pulse_val);
    //                 $("#txt_bp_sys").val(data['vitals'].bp_val_sys);
    //                 $("#txt_bp_dia").val(data['vitals'].bp_val_dia);
    //                 $("#txt_temperature").val(data['vitals'].temp_val);
    //                 $("#txt_height").val(data['vitals'].height_val);
    //                 $("#txt_weight").val(data['vitals'].weight_val);
    //                 $("#txt_ofc").val(data['vitals'].ofc);
    //                 $("#txt_bmi").val(data['vitals'].bmi);
    //             }
    //             else {
    //                 $("#txt_pulse, #txt_bp_sys, #txt_bp_dia, #txt_temperature, #txt_height, #txt_weight, #txt_ofc, #txt_bmi").val('');
    //             }

    //             if (data['chronic_rs'] != null) {
    //                 var chrn_item_str = chrn_item_hdn_str = "";
    //                 var chronic_action = $("#chronic-route").val();
    //                 var chronic_obj = data['chronic_rs'];
    //                 $.each(chronic_obj, function (index, item) {
    //                     var chrn_id = item.chronic_dis_item_pk_no_fk;
    //                     var chrn_name = item.chronic_dis_name;
    //                     chrn_item_hdn_str += chrn_id + "_" + chrn_name + "*";
    //                     chrn_item_str += "<span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1' style='font-size:10px;' onclick='prescriptionFunc.addChronicItem(this)' data-modal='common-modal-sm' data-action='" + chronic_action + "' >" + chrn_name + "</span>";
    //                 });
    //                 $("#chrn-items").val(chrn_item_hdn_str);
    //                 $("#chronic_con").html(chrn_item_str);
    //             }

    //             if (data['allergy_rs'] != null) {
    //                 var allergy_item_str = "";
    //                 var chronic_action = $("#chronic-route").val();
    //                 var allergy_obj = data['allergy_rs'];
    //                 $.each(allergy_obj, function (index, item) {
    //                     var pat_allergies_no_pk = item.pat_allergies_no_pk;
    //                     if (item.category_allergies == "DLRG") {
    //                         var allergies_name = item.item_name;
    //                     }
    //                     else {
    //                         var allergies_name = item.allergies_name;
    //                     }

    //                     allergy_item_str += "<span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1' style='font-size:10px;' >" + allergies_name + " &nbsp;<i class='fa fa-times text-danger' data-allergy-id='" + pat_allergies_no_pk + "' title='Click here to delete this Allergy item' onclick='prescriptionFunc.removeAllergyItem(this)' ></i></span>";
    //                 });
    //                 $("#allergy_con").html(allergy_item_str);
    //             }

    //             /*if(prescription_id == "")
    //             {

    //                 var med_obj = data['continue_med_arr'];
    //                 $.each(med_obj, function(index, item) {
    //                     $("#continue_med_con").append('<tr><td class="w-5"><input type="checkbox" class="float-left"></td><td>'+item.item_name+'</td><td>'+item.dosage+'</td><td class="w-15">'+item.duration+' '+item.duration_mu+'</td></tr>');
    //                 });

    //                 var path_obj = data['path_arr'];
    //                 $.each(path_obj, function(index, item) {
    //                     $("#path_con").append('<tr class="border-bottom"><td><a href="#">'+item+'</a></td><td class="w-5"></td></tr>');
    //                 });

    //                 var rad_obj = data['rad_arr'];
    //                 $.each(rad_obj, function(index, item) {
    //                     $("#rad_con").append('<tr><td><a href="#">'+item+'</a></td><td class="w-5"></td></tr>');
    //                 });
    //             }*/
    //         },
    //         complete: function (data) {
    //             $(thisElement).parents('tr').addClass("bg-light-blue");
    //             var dtls_action = $(thisElement).attr("data-dtls-action");
    //             $.ajax({
    //                 data: { hdn_su_no: hdn_su_no },
    //                 url: dtls_action,
    //                 type: "get",
    //                 beforeSend: function () {
    //                 },
    //                 success: function (data) {
    //                     $("#presc_details").html(data);
    //                 },
    //                 complete: function (data) {
    //                     $(thisElement).parents('tr').addClass("bg-light-blue");
    //                     $(".data-table-inv").DataTable({
    //                         "ordering": false,
    //                         "bLengthChange": false,
    //                         "bAutoWidth": false,
    //                         "pageLength": 5
    //                     });
    //                     $.unblockUI();
    //                 }
    //             });
    //         }
    //     });
    // },
    patientPrescriptionTemplateDetails: function (thisElement) {
        var template_id = $(thisElement).attr("data-template");
        var template_name = $(thisElement).attr("data-template-name");
        var patient_id = $("#hdn_patient_id").val();
        var hdn_su_no = $("#hdn_su_no").val();
        if (template_id != "") {
            var hdn_prescription_id = $("#hdn_prescription_id").val();

            if (hdn_prescription_id != "") {
                if (
                    !confirm(
                        "Are you sure to use this Template? All the previous data of this Prescription will not be found."
                    )
                ) {
                    return;
                }
            }

            var dtls_action = $(thisElement).attr("data-dtls-action");
            $.ajax({
                url: dtls_action,
                data: {
                    template_id: template_id,
                    patient_id: patient_id,
                    template_name: template_name,
                    hdn_su_no: hdn_su_no,
                },
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $("#presc_details").html(data);
                },
                complete: function (data) {
                    $.unblockUI();
                },
            });
        } else {
            $.unblockUI();
        }
    },

    patientPrescriptionTemplateDetailsUHL: function (thisElement) {
        var template_id = $(thisElement).attr("data-template");
        var template_name = $(thisElement).attr("data-template-name");
        var patient_id = $("#hdn_patient_id").val();
        var hdn_su_no = $("#hdn_su_no").val();
        if (template_id != "") {
            var hdn_prescription_id = $("#hdn_prescription_id").val();

            if (hdn_prescription_id != "") {
                if (
                    !confirm(
                        "Are you sure to use this Template? All the previous data of this Prescription will not be found."
                    )
                ) {
                    return;
                }
            }

            var dtls_action = $(thisElement).attr("data-dtls-action");
            $.ajax({
                url: dtls_action,
                data: {
                    template_id: template_id,
                    patient_id: patient_id,
                    template_name: template_name,
                    hdn_su_no: hdn_su_no,
                },
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                // success: function (data) {
                //     $("#presc_details").html(data);
                // },

                success: function (response) {
                    var doges = response["dose"];
                    var route = response["route"];
                    var duration = response["duration"];
                    var instructions = response["instructions"];
                    let pat_med_rs = response["pat_med_rs"];
                    let meddurmu = response["meddurmu"];
                    let cc_arr = response["cc_arr"];
                    let ch_arr = response["ch_arr"];
                    let icd_arr = response["icd_arr"];
                    let lmp = response["lmp"];
                    let in_arr = response["in_arr"];
                    let inf_arr = response["inf_arr"];
                    let find_arr = response["find_arr"];
                    let adv_arr = response["ad_arr"];
                    let pr_arr = response["pr_arr"];
                    let acup_arr = response["acup_arr"];
                    let ptet_arr = response["ptet_arr"];
                    let ptte_arr = response["ptte_arr"];
                    let duration_mu_phy = response["duration_mu_phy"];
                    console.log(pr_arr + "testing");
                // $("#data-append-to").html("");

                let tableBody = $("#data-append-to");
                // $('#data-append-to tr').not(':first').remove();
                // var selectElement='';
                $("#data-append-to tr").slice(1).remove();
                // var selectElement='';
                // var medicineDoseCount = [];
                let medicineDoseCount = {};
                $.each(pat_med_rs, function (index, med_row) {
                    selectDoseElement = `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${
                                                    index + 1
                                                }" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function (key, value) {
                        console.log(value.data);
                        const isDoseSelected =
                            med_row.dosage === value.data
                                ? `<option value="${value.data}" selected>${value.data}</option>`
                                : ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose =
                            med_row.dosage != value.data
                                ? `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>`
                                : "";
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${
                        index + 1
                    }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                    console.log(selectDoseElement);

                    selectRouteElement = `<div class="" id="routeId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 route_edit medicine_route select2 select2-hidden-accessible" id="medicine_route_${
                                                    index + 1
                                                }" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');" data-select2-id="medicine_route_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(route, function (key, value) {
                        const isRouteSelected =
                            med_row.route === value.data ? "selected" : "";
                        selectRouteElement += `<option value="${value.data}" ${isRouteSelected}>${value.data}</option>`;
                    });
                    selectRouteElement += `</select> </div>
                                                <div class="editRouteValue" id="medicine_route_${
                                                    index + 1
                                                }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectInstructionElement = `<div class="" id="instructionId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 instructionEdit medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                                                    index + 1
                                                }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(instructions, function (key, value) {
                        const isInstructionSelected =
                            med_row.instruction_take === value.data
                                ? "selected"
                                : "";
                        selectInstructionElement += `<option value="${value.data}" ${isInstructionSelected}>${value.data}</option>`;
                    });
                    selectInstructionElement += `</select></div>
                                                <div class="editInsButton" id="instruction_${
                                                    index + 1
                                                }"

                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                                    data-popup_header="Medicine Instruction"
                                                    data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectDurationElement = `<select class="form-control form-control-sm m-0 p-0 medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                        index + 1
                    }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(duration, function (key, value) {
                        const isDurationSelected =
                            med_row.duration === value.data ? "selected" : "";
                        selectDurationElement += `<option value="${value.data}" ${isDurationSelected}>${value.data}</option>`;
                    });
                    selectDurationElement += `</select>`;

                    selectDurationMuElement = `<select class="form-control medicine_duration_mu" id="medicine_duration_mu_${
                        index + 1
                    }" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">`;
                    $.each(meddurmu, function (key, value) {
                        const isDurationMuSelected =
                            med_row.duration_mu == value.data.toUpperCase()
                                ? "selected"
                                : "";
                        selectDurationMuElement += `<option value="${value.data}" ${isDurationMuSelected}>${value.data}</option>`;
                    });
                    selectDurationMuElement += `</select>`;

                    // if (med_row.item_no_fk > 0) {

                    // Initialize medicineDoseCount if it doesn't exist
                    // Initialize the medicineDoseCount object if it doesn't already exist
                    // window.medicineDoseCount = window.medicineDoseCount || {};

                    // // Extract medicine item name and ID, defaulting to 'Unknown' and 0 respectively if not provided
                    // var medicineItem = med_row.brand_name || 'Unknown';
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;

                    // // Convert itemId to a string to ensure consistent key handling
                    // var itemIdStr = String(itemId);

                    // // Increment the dose count for this itemId, initializing if necessary
                    // window.medicineDoseCount[itemIdStr] = (window.medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = window.medicineDoseCount[itemIdStr];

                    // // Log the dose number and item name, or indicate no doses to process
                    // if (doseNo > 0) {
                    //     console.log('Dose number for item ID ' + itemId + ' is: ' + doseNo);
                    //     console.log('Item Name: ' + medicineItem);
                    // } else {
                    //     console.log('No doses to process for item ID ' + itemId + '.');
                    // }

                    // var medicineItem = med_row.brand_name || "Unknown";
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;
                    // var itemIdStr = String(itemId);

                    // // Increment the dose count for the current item
                    // medicineDoseCount[itemIdStr] =
                    //     (medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = medicineDoseCount[itemIdStr];
                    // Initialize outside the loop

                    const medicineItem = med_row.brand_name
                        ? med_row.brand_name.trim()
                        : "Unknown";
                    const itemId = med_row.item_no_fk || 0;
                    const generic_name = med_row && med_row.generic_name ? med_row.generic_name : '';
                    // Clean the brand name (remove spaces, lowercase)
                    const normalizedName = medicineItem
                        .toLowerCase()
                        .replace(/\s+/g, "");

                    // Unique key: itemId + brandName
                    const doseKey = `${itemId}_${normalizedName}`;

                    // Initialize count if not exist
                    if (!medicineDoseCount[doseKey]) {
                        medicineDoseCount[doseKey] = 0;
                    }

                    // Increment dose number
                    medicineDoseCount[doseKey]++;
                    const doseNo = medicineDoseCount[doseKey];

                    let $row = `<tr class="border-0" id="tr_id_${index + 1}">


                             <td class="p-0 px-1 border-0" width="20%">
    ${
        doseNo === 1
            ? `
        <input type="text"
            class="form-control form-control-sm m-0 p-0 item_element bg-white"
            id="medicine_item_${index + 1}" name="medicine_item[]"
            placeholder="Generic / Brand" value="${medicineItem}"
            style="border: 0px none;" readonly="readonly">`
            : ""
    }

    <input type="hidden" id="hdn_medicine_item_id_${index + 1}"
        name="hdn_medicine_item_id[]" value="${itemId}">
<input type="hidden" id="hdn_genetic_id_${index + 1}"
                                        name="hdn_genetic_id[]" value="${generic_name}">
    <input type="hidden" id="hdn_report_serial_med_${index + 1}"
        name="hdn_report_serial_med[]" value="1">

    <input type="hidden" id="hidden_multidose_id_${index + 1}"
        name="multidose[]" value="${med_row.multidose_txt}">

    ${
        doseNo > 1
            ? `
        <input type="hidden"
            class="form-control form-control-sm m-0 p-0 item_element bg-white"
            id="medicine_item_${index + 1}" name="medicine_item[]"
            placeholder="Generic / Brand" value="${medicineItem}"
            style="border: 0px none;" readonly="readonly">

        <span class="dose-id-display"
            style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 8px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
            Dose No: ${doseNo}
        </span>
        `
            : ""
    }
</td>



                            <td class="p-0 border-0" id="alternative_id_${
                                index + 1
                            }" style="vertical-align: top;"></td>

                            <td class="p-0 border-0" id="med_favourit_${
                                index + 1
                            }" style="vertical-align: top;">
                                <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${med_row.item_no_fk}" data-name="${med_row.brand_name}" data-type="MED" data-duration="${med_row.duration}" data-route="${med_row.route}" data-dose="${med_row.dosage}" data-quantity="${med_row.quantity}" data-continue="${med_row.is_continue}" data-instruction="${med_row.instruction}" data-duration-type="${med_row.duration_type}"><i class="fa fa-star text-primary"></i></span>
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectDoseElement}
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectRouteElement}
                            </td>

                            <td class="p-0 px-1 border-0" hidden="">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${
                                    index + 1
                                }" name="medicine_quantity[]" value="${
                        med_row.item_qty
                    }">
                            </td>

                            <td class="p-0 px-1 border-0">
                                ${selectInstructionElement}
                            </td>

                            <td class="p-0 px-1 border-0" style="width: 127%;">
                            <div class="input-group" style="width: 127%;">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_${
                                    index + 1
                                }" name="medicine_duration_type[]" value="${
                        med_row.duration
                    }">
                               ${selectDurationMuElement}
                            </div>
                            </td>

                            <td class="p-0 px-1 border-0 text-center">
                            <input type="checkbox" id="is_continue_${
                                index + 1
                            }" name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)" value="${
                        med_row.continue_ind
                    }" ${med_row.continue_ind == 1 ? "checked" : ""}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <span class="btn btn-danger btn-md" onclick="removeTableRowOnly(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <button type="button" class="btn btn-primary btn-md add-multidose ml-3"
                                            style="${
                                                doseNo > 1
                                                    ? "cursor: not-allowed; background-color: rgb(204, 204, 204); pointer-events: none;"
                                                    : ""
                                            }"
                                            onclick="prescriptionFunc.addMultiDoseRow(this)">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </td>
                         </tr>`;

                    let tableBody = $("#data-append-to").append($row);
                    //  $('#dose_'+(index + 1)).html(selectElement);
                    $(".select2").select2();
                    $(".select2").removeClass("select2-hidden-accessible");
                    $(".select2-container").remove();
                    // $('.select2').select2({
                    //     // placeholder: "Select Value",
                    //     allowClear: true
                    // });

                    // from here
                    $(".select2").select2({
                        tags: true, // Enable adding new options
                        placeholder: "Select or type to add",
                        allowClear: true, // Allow clearing selection
                        templateResult: formatOption, // Format the display of options
                        templateSelection: formatOption, // Format the selected option
                    });
                    // Function to format the options with data attributes
                    function formatOption(option) {
                        if (!option.id) {
                            return option.text; // Return the text if it's a new tag
                        }
                        const $option = $(`<span>${option.text}</span>`);

                        // Accessing custom data attributes
                        const dataQnty = $(option.element).data("qnty");
                        if (dataQnty !== undefined) {
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here

                    //   }
                });

                    if (cc_arr["CHIEFCOM"] && cc_arr["CHIEFCOM"].length >= 1) {
                        $("#chfcom").html("");
                        $.each(cc_arr["CHIEFCOM"], function (index, cc_row) {
                            var chief_com = cc_row.split("_");
                            var cc_html_row = `<li id="item-${
                                chief_com[0]
                            }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                                chief_com[0] != 0 ? chief_com[0] : ""
                            }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                                chief_com[1]
                            }"><input type="hidden" name="lookup_id[]" value="${
                                chief_com[2]
                            }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="CHIEFCOM" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                                chief_com[3]
                            }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                            $("#chfcom").append(cc_html_row);
                        });
                    } else {
                        $("#chfcom").html("");
                    }

                    if (
                        ch_arr["CLINICHIST"] &&
                        ch_arr["CLINICHIST"].length >= 1
                    ) {
                        $("#ho").html("");
                        $.each(ch_arr["CLINICHIST"], function (index, ch_row) {
                            var clinical_his = ch_row.split("_");
                            var ch_html_row = `<li id="item-${
                                clinical_his[0]
                            }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                                clinical_his[0] != 0 ? clinical_his[0] : ""
                            }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                                clinical_his[1]
                            }"><input type="hidden" name="lookup_id[]" value="${
                                clinical_his[2]
                            }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="CLINICHIST" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                                clinical_his[3]
                            }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                            $("#ho").append(ch_html_row);
                        });
                    } else {
                        $("#ho").html("");
                    }

                    if (icd_arr["ICD"] && icd_arr["ICD"].length >= 1) {
                        $("#icd_con").html("");
                        $.each(icd_arr["ICD"], function (index, icd_row) {
                            var icd_his = icd_row.split("_");
                            var icd_html_row = `<li id="item-${
                                icd_his[0]
                            }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                                icd_his[0] != 0 ? icd_his[0] : ""
                            }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                                icd_his[1]
                            }"><input type="hidden" name="lookup_id[]" value="${
                                icd_his[2]
                            }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="ICD" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                                icd_his[3]
                            }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                            $("#icd_con").html(icd_html_row);
                        });
                    } else {
                        $("#icd_con").html("");
                    }

                    if (in_arr["INVFIND"] && in_arr["INVFIND"].length >= 1) {
                        $("#investigation").html("");
                        $.each(in_arr["INVFIND"], function (index, inv_row) {
                            var inv_his = inv_row.split("_");
                            var inv_html_row = `<li id="item-${inv_his[0]}"><input type="hidden" name="item_id[]" value="${inv_his[0]}" readonly="readonly"><input class="left-element" type="hidden" name="item_name[]" value="${inv_his[1]}" readonly="readonly"><input type="hidden" name="lookup_id[]" value="${inv_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="INVFIND" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${inv_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><i class="fa fa-angle-double-right"></i> ${inv_his[1]}&nbsp;&nbsp;<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                            $("#investigation").append(inv_html_row);
                        });
                    } else {
                        $("#investigation").html("");
                    }

                    // if (find_arr['FINDINGS'] && find_arr['FINDINGS'].length >= 1) {
                    //     $('#investigation_find_con').html('');
                    //     $.each(find_arr['FINDINGS'], function(index, find_row){
                    //     var find_his = find_row.split("_");
                    //     var find_html_row = `<li id="item-${find_his[0]}"><input type="hidden" name="item_id[]" value="${find_his[0]}" readonly="readonly"><input class="left-element" type="hidden" name="item_name[]" value="${find_his[1]}" readonly="readonly"><input type="hidden" name="lookup_id[]" value="${find_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="INVFIND" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${find_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><i class="fa fa-angle-double-right"></i> ${find_his[1]}&nbsp;&nbsp;<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                    //     $('#investigation_find_con').append(find_html_row);
                    //     });
                    // }else{
                    //     $('#investigation_find_con').html('');
                    // }

                    if (adv_arr["ADVICE"] && adv_arr["ADVICE"].length >= 1) {
                        $("#adv").html("");
                        $.each(adv_arr["ADVICE"], function (index, adv_row) {
                            var adv_his = adv_row.split("_");
                            var adv_html_row = `<li id="item-${adv_his[0]}"><input type="hidden" name="item_id[]" value="${adv_his[0]}" readonly="readonly"><input class="left-element" type="text" style="width:90%;" name="item_name[]" value="${adv_his[1]}"><input type="hidden" name="lookup_id[]" value="${adv_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="ADVICE" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${adv_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                            $("#adv").append(adv_html_row);
                        });
                    } else {
                        $("#adv").html("");
                    }

                    if (
                        pr_arr["PROCEDURE"] &&
                        pr_arr["PROCEDURE"].length >= 1
                    ) {
                        $("#proc").html("");
                        $.each(pr_arr["PROCEDURE"], function (index, proc_row) {
                            var proc_his = proc_row.split("_");
                            var proc_html_row = `<li id="item-${proc_his[0]}"><input type="hidden" name="item_id[]" value="${proc_his[0]}" readonly="readonly"><input class="left-element" type="text" style="width:90%;" name="item_name[]" value="${proc_his[1]}"><input type="hidden" name="lookup_id[]" value="${proc_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="PROCEDURE" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${proc_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                            $("#proc").append(proc_html_row);
                        });
                    } else {
                        $("#proc").html("");
                    }

                    // if (lmp.medical_history) {
                    //     $('#medical_history').val(lmp.medical_history);
                    // }else{
                    //     $('#medical_history').val('');
                    // }

                    // if (lmp.family_history) {
                    //     $('#family_history').val(lmp.family_history);
                    // }else{
                    //     $('#family_history').val('');
                    // }

                    // if (lmp.surgical_history) {
                    //     $('#surgical_history').val(lmp.surgical_history);
                    // }else{
                    //     $('#surgical_history').val('');
                    // }

                    // if (lmp.past_history) {
                    //     $('#past_history').val(lmp.past_history);
                    // }else{
                    //     $('#past_history').val('');
                    // }

                    // if (lmp.outcome_measurement){
                    //     $('#in_outcome_measurement').val(lmp.outcome_measurement);
                    // }else{
                    //     $('#in_outcome_measurement').val('');
                    // }

                    previewTab();
                },

                complete: function (data) {
                    $.unblockUI();
                },
            });
        } else {
            $.unblockUI();
        }
    },

    savePrescriptionAsTemplate: function (thisElement) {
        console.log("ok");
        event.preventDefault();
        if ($("#template_name").val() == "") {
            $("#template_msg").html("( This field is required )");
            $("#template_name").addClass("is-invalid");
            return false;
        }

        var formID = $(thisElement).parents("form").attr("id");
        var redirect = $(thisElement).attr("data-riderect_action");
        var formAction = $(thisElement).attr("data-action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                        window.location.href = redirect;
                        window.history.pushState(
                            { path: redirect },
                            "",
                            redirect
                        );
                    }
                    // window.history.pushState({ path: '../public/pres-opd-save-update-template' }, "", '../public/pres-opd-save-update-template');
                },
                complete: function () {
                    $.unblockUI();
                },
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }

                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        error_messages
                    );

                    $.unblockUI();
                },
            });
        }

        event.stopImmediatePropagation();
    },

    savePrescriptionAsTemplateV2: function (thisElement) {
        console.log("ok");
        event.preventDefault();
        if ($("#template_name").val() == "") {
            $("#template_msg").html("( This field is required )");
            $("#template_name").addClass("is-invalid");
            return false;
        }

        var formID = $(thisElement).parents("form").attr("id");
        var redirect = $(thisElement).attr("data-riderect_action");
        var formAction = $(thisElement).attr("data-action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                        // window.location.href = redirect;
                        // window.history.pushState({ path: redirect }, "", redirect);
                    }
                    $("#template_name").val("");
                    // window.history.pushState({ path: '../public/pres-opd-save-update-template' }, "", '../public/pres-opd-save-update-template');
                },
                complete: function () {
                    // dynamicFunc.afterSaveLoadPage("{{route('create-doctor-wise-uhl')}}")
                    $.unblockUI();
                },
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }

                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        error_messages
                    );

                    $.unblockUI();
                },
            });
        }

        event.stopImmediatePropagation();
    },
    addMoreDropdownOptionEMON: function (thisElement, dropdown_class) {
        var dropdown_option = $(thisElement)
            .parents("div")
            .find(dropdown_class + " option:selected")
            .attr("data-dropdown_option");
        var dropdown_option_edit = $(thisElement).data("dropdown_option_edit");

        if (dropdown_option == "add_more") {
            var popup_header = $(thisElement)
                .parents("div")
                .find(dropdown_class + " option:selected")
                .attr("data-popup_header");
            var input_label = $(thisElement)
                .parents("div")
                .find(dropdown_class + " option:selected")
                .attr("data-input_label");
            var input_placeholder = $(thisElement)
                .parents("div")
                .find(dropdown_class + " option:selected")
                .attr("data-input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");

            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else {
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
            $("#addMoreDropdownOption").modal("hide");
        }
    },

    addToDropdownEMON: function (thisElement) {
        var element_id = $("#thisElement_id").val();
        var new_option = $("#new_dropdown_opt").val();
        if (new_option) {
            $("#addMoreDropdownOption2").modal("hide");
            $("#" + element_id)
                .find("option:last")
                .before(
                    '<option data-qnty="" value="' +
                        new_option +
                        '" selected="selected" >' +
                        new_option +
                        "</option>"
                );
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
        } else {
            $("#new_dropdown_opt").css({
                "border-color": "red",
                "border-weight": "1px",
                "border-style": "solid",
            });
        }

        // console.log(element_id, new_option);
        // Add Lookup Data prescription
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var formData = $("#" + formID).serialize();
        $.ajax({
            async: true,
            data: { element_id: element_id, new_option: new_option },
            url: formAction,
            type: formMethod,
            cache: false,
            beforeSend: function () {
                blockUI();
            },
            // success: function (data) {
            // },
            complete: function () {
                $.unblockUI();
            },
        });
    },

    storeAllergyData: function (thisElement) {
        // var atter =$('#allergy-create').find('attr','required');
        // var data =atter['prevObject'][0];
        // event.preventDefault();
        event.preventDefault();

        // var formID = $(thisElement).parents("form").attr("id");
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("data-action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var formData = $("#" + formID).serialize();
        var doctor_id = $("#hdn_doctor_id").val();
        var patient_id = $("#hdn_patient_id").val();
        var cmb_type = $("#cmb_type").val();
        var medicine_item = $("#medicine_item").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        if (formValidation(formID) == false) {
            return;
        }

        if (cmb_type == "FLRG") {
            var allergy_name = $("#cmb_allergy :selected").text();
            // var allergy_name = $("#medicine_item").val();
        } else if (cmb_type == "OLRG") {
            var allergy_name = $("#free_text").val();
        } else {
            // var allergy_name = $('#cmb_allergy :selected').text();
            var allergy_name = $("#medicine_item").val();
        }

        var allergy_type = $("#cmb_type :selected").text();
        var severity_name = $("#cmb_severity :selected").text();

        if (confirm("Are You Sure?")) {
            // $('#' + formID).unbind().submit(function (e) {

            $.ajax({
                async: true,
                data:
                    formData +
                    "&doctor_id=" +
                    doctor_id +
                    "&patient_id=" +
                    patient_id +
                    "&allergy_name=" +
                    allergy_name +
                    "&allergy_type=" +
                    allergy_type +
                    "&severity_name=" +
                    severity_name +
                    "&hdn_appointment_id=" +
                    hdn_appointment_id,
                url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    var allergy_name_span =
                        "<span><span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal' style='font-size:10px;'  data-modal='common-modal-md' data-action=`${formAction}`>" +
                        allergy_name +
                        "</span> <sup><i class='fa fa-times remove_allergy cursor-pointer text-danger pr-2' data-allergyid='" +
                        data.last_insert_id +
                        "'></i></sup></span>";
                    $("#allergy_con").append(allergy_name_span);
                    $(".exampleModal ").modal("hide");
                },
                complete: function () {
                    $.unblockUI();
                },
            });
            // });
        }
    },

    storeAllergyDataUhl: function (thisElement) {
        // var atter =$('#allergy-create').find('attr','required');
        // var data =atter['prevObject'][0];
        // event.preventDefault();
        event.preventDefault();

        // var formID = $(thisElement).parents("form").attr("id");
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        console.log(formAction);
        var formMethod = $(thisElement).parents("form").attr("method");
        var formData = $("#" + formID).serialize();
        var doctor_id = $("#hdn_doctor_id").val();
        var patient_id = $("#hdn_patient_id").val();
        var cmb_type = $("#cmb_type").val();
        var medicine_item = $("#medicine_item").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        if (formValidation(formID) == false) {
            return;
        }

        if (cmb_type == "FLRG") {
            var allergy_name = $("#cmb_allergy :selected").text();
            // var allergy_name = $("#medicine_item").val();
        } else if (cmb_type == "OLRG") {
            var allergy_name = $("#free_text").val();
        } else {
            // var allergy_name = $('#cmb_allergy :selected').text();
            var allergy_name = $("#medicine_item").val();
        }

        var allergy_type = $("#cmb_type :selected").text();
        var severity_name = $("#cmb_severity :selected").text();

        if (confirm("Are You Sure?")) {
            // $('#' + formID).unbind().submit(function (e) {

            $.ajax({
                async: true,
                data:
                    formData +
                    "&doctor_id=" +
                    doctor_id +
                    "&patient_id=" +
                    patient_id +
                    "&allergy_name=" +
                    allergy_name +
                    "&allergy_type=" +
                    allergy_type +
                    "&severity_name=" +
                    severity_name +
                    "&hdn_appointment_id=" +
                    hdn_appointment_id,
                url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    var allergy_name_span =
                        "<span><span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal' style='font-size:10px;'  data-modal='common-modal-md' data-action=`${formAction}`>" +
                        allergy_name +
                        "</span> <sup><i class='fa fa-times remove_allergy cursor-pointer text-danger pr-2' data-allergyid='" +
                        data.last_insert_id +
                        "'></i></sup></span>";
                    $("#allergy_con").append(allergy_name_span);
                    $(".exampleModal ").modal("hide");
                },
                complete: function () {
                    $.unblockUI();
                },
            });
            // });
        }
    },

    removeAllergyItem: function (thisElement) {
        if (confirm("Are you sure?")) {
            var id = $(thisElement).attr("data-allergy-id");
            var action_url = $("#chronic-route-delete").val();
            $.ajax({
                async: true,
                data: { id: id },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $(thisElement).parent("span").remove();
                },
                complete: function () {
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-title").html("Success");
                    $(".common-modal-notify .modal-body").html(
                        "Allergy item removed successfully"
                    );
                    $.unblockUI();
                },
            });
        }
    },
    selectChronicItem: function (thisElement) {
        var chrn_item_str = (chrn_item_hdn_str = "");
        var action = $("#chronic-route").val();
        var action_save = $("#chronic-route-save").val();
        $(".chronic-item").each(function () {
            if (this.checked) {
                var chrn_id = $(this).val();
                var chrn_name = $(this).attr("data-name");
                chrn_item_hdn_str += chrn_id + "_" + chrn_name + "*";
                chrn_item_str +=
                    "<span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1' style='font-size:10px;' onclick='prescriptionFunc.addChronicItem(this)' data-modal='common-modal-sm' data-action='" +
                    action +
                    "' >" +
                    chrn_name +
                    "</span>";
            }
        });

        var doctor_id = $("#hdn_doctor_id").val();
        var patient_id = $("#hdn_patient_id").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();
        console.log(hdn_appointment_id);
        $.ajax({
            async: true,
            url: action_save,
            data: {
                chrn_item_hdn_str: chrn_item_hdn_str,
                doctor_id: doctor_id,
                patient_id: patient_id,
                hdn_appointment_id: hdn_appointment_id,
            },
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $("#chrn-items").val(chrn_item_hdn_str);
                $("#chronic_con").html(chrn_item_str);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });
    },
    saveChronicItem: function (thisElement) {
        var chrn_item_str = (chrn_item_hdn_str = chrn_text = "");
        var action = $("#chronic-route").val();
        var action_save = $("#chronic-route-save").val();
        blockUI();
        $(".chronic-item").each(function () {
            if (this.checked) {
                var chrn_id = $(this).val();
                chrn_text +=
                    chrn_id +
                    "_" +
                    $(this)
                        .parent()
                        .parent()
                        .parent("tr")
                        .find("#chrn_dtls_" + chrn_id)
                        .val() +
                    "*";
                console.log(chrn_text);
                var chrn_name = $(this).attr("data-name");
                chrn_item_hdn_str += chrn_id + "_" + chrn_name + "*";
                chrn_item_str +=
                    "<span class='btn btn-outline-primary bg-none btn-sm mr-1 mb-1' style='font-size:10px;' onclick='prescriptionFunc.addChronicItem(this)' data-modal='common-modal-sm' data-action='" +
                    action +
                    "' >" +
                    chrn_name +
                    "</span>";
                var doctor_id = $("#hdn_doctor_id").val();
                var patient_id = $("#hdn_patient_id").val();
                var hdn_appointment_id = $("#hdn_appointment_id").val();
                var chrn_dtls = $("#chrn_dtls_" + chrn_id).val();
                console.log(hdn_appointment_id);
                $.ajax({
                    async: true,
                    url: action_save,
                    data: {
                        chrn_dtls: chrn_dtls,
                        chrn_item_hdn_str: chrn_item_hdn_str,
                        doctor_id: doctor_id,
                        patient_id: patient_id,
                        hdn_appointment_id: hdn_appointment_id,
                        chrn_text: chrn_text,
                    },
                    type: "post",
                    beforeSend: function () {},
                    success: function (data) {
                        $("#chrn-items").val(chrn_item_hdn_str);
                        $("#chronic_con").html(chrn_item_str);
                        $("#chronic_text").val(chrn_text);
                    },
                    complete: function (data) {},
                });
            }
        });
        $.unblockUI();
    },
    setContinueDuration: function (thisElement) {
    const $row = $(thisElement).parents("tr");

    // Get dose and calculate total dose
    const dose = $row.find(".medicine_dose").val();
    console.log(dose);
    const doseArray = dose.split("+");
    let totalDose = 0;
    for (let i = 0; i < doseArray.length; i++) {
        totalDose += parseInt(doseArray[i]) || 0;
    }

    // Set is_continue value
    $row.find("[name='is_continue[]']").val(thisElement.checked ? 1 : 0);

    if (thisElement.checked) {
        // If checked => set Continue
      $row.find(".medicine_duration")
    .val("Continue")
    .prop("readonly", true); // ensure not disabled

        $row.find("[name='medicine_duration_mu[]']")
            .val("DAY")
            .prop("readonly", true);

        $row.find("[name='medicine_duration_type[]']").val("Continue");

    } else {
        // If unchecked => reset values
	$row.children('td').children().find(".medicine_duration").prop("readonly", false);
         $row.children('td').children().find(".medicine_duration").val(0);
		//

        $row.find("[name='medicine_duration_mu[]']")
            .val("DAY")
            .prop("readonly", false);

            }
},
    addChronicItem: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        if (patient_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Patient"
            );
            return;
        }
        var action = $(thisElement).attr("data-action");
        var title = $(thisElement).attr("title");
        var modal = $(thisElement).attr("data-modal");
        var chrn_item_hdn_str = $("#chrn-items").val();
        var chronic_text = $("#chronic_text").val();

        $.ajax({
            async: true,
            url: action,
            data: {
                chrn_item_hdn_str: chrn_item_hdn_str,
                hdn_appointment_id: hdn_appointment_id,
                chronic_text: chronic_text,
            },
            type: "post",
            beforeSend: function () {
                blockUI();
                $("." + modal).modal("show");
                $("." + modal + " .modal-body").html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                );
                $("." + modal + " .modal-title").html(title);
            },
            success: function (data) {
                $("." + modal + " .modal-body").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });
    },
    addToPresFavouritList: function (thisElement) {
        var hospital_code = $("#hospital_code").val();
        var item_id = $(thisElement).attr("data-id");
        var item_name = $(thisElement).attr("data-name");
        var item_type = $(thisElement).attr("data-type");
        var action_url = $(thisElement).attr("data-url");
        var data_duration = $(thisElement).attr("data-duration");
        var data_route = $(thisElement).attr("data-route");
        var data_dose = $(thisElement).attr("data-dose");
        var data_quantity = $(thisElement).attr("data-quantity");
        var data_continue = $(thisElement).attr("data-continue");
        var data_instruction = $(thisElement).attr("data-instruction");
        var data_duration_type = $(thisElement).attr("data-duration-type");
        console.log(action_url);
        // if (item_type == "INVFIND") {
        //     var append_id = "#pres-favourit-list-investigation";
        // }else if(item_type == "CHIEFCOM") {
        //     var append_id = "#pres-favourit-list-chief-complaint";
        // }else if(item_type == "CLINICHIST") {
        //     var append_id = "#pres-favourit-list-clinical-his";
        // }
        // else if(item_type == "ICD") {
        //     var append_id = "#pres-favourit-list-icd";
        // } else {
        //     const lowerCaseId = item_type.toLowerCase();
        //     var append_id = "#pres-favourit-list-" + lowerCaseId;
        // }
            switch (item_type) {
                case "INVFIND":
                    append_id = "#pres-favourit-list-investigation";
                    break;
                case "CHIEFCOM":
                    append_id = "#pres-favourit-list-chief-complaint";
                    break;
                case "CLINICHIST":
                    append_id = "#pres-favourit-list-clinical-his";
                    break;
                case "ICD":
                    append_id = "#pres-favourit-list-icd";
                    break;
                default:
                    append_id = "#pres-favourit-list-" + item_type.toLowerCase();
                    break;
            }
        // alert(append_id + " | " + item_type + " | " + item_type.toLowerCase() + "bellal");


        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    item_id: item_id,
                    item_name: item_name,
                    item_type: item_type,
                    data_duration: data_duration,
                    data_route: data_route,
                    data_dose: data_dose,
                    data_quantity: data_quantity,
                    data_continue: data_continue,
                    data_instruction: data_instruction,
                    data_duration_type: data_duration_type,
                },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    $(".loading-img").html(
                        '<i class="spinner-border spinner-border-sm float-right"></i>'
                    );
                },
                success: function (data) {
                    if (hospital_code == "DMHL") {
                        $("#pres-favourit-list").html(data);
                    } else {
                        $(append_id).html(data);
                    }
                    // $(append_id).html(data);
                },
                complete: function () {
                    $(".loading-img").html("");
                },
            });
        }
    },

    addMultidoseList: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();
        var item_id = $(thisElement).attr("data-id");
        var pres_id = $(thisElement).attr("pres-id");
        var data_route = $(thisElement).attr("data-route");
        var data_row_id = $(thisElement).attr("data-row-id");

        if (item_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Item"
            );
            return;
        }
        var action = $(thisElement).attr("data-action");
        var title = $(thisElement).attr("title");
        var modal = $(thisElement).attr("data-modal");

        $.ajax({
            async: true,
            url: action,
            data: {
                item_id: item_id,
                hdn_appointment_id: hdn_appointment_id,
                patient_id: patient_id,
                data_route: data_route,
                data_row_id: data_row_id,
                pres_id: pres_id,
            },
            type: "post",
            beforeSend: function () {
                blockUI();
                $("." + modal).modal("show");
                $("." + modal + " .modal-body").html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                );
                $("." + modal + " .modal-title").html(title);
            },
            success: function (data) {
                $("." + modal + " .modal-body").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });
    },

    alternativeMedicine: function (thisElement) {
        var patient_id = $("#hdn_patient_id").val();
        var hdn_appointment_id = $("#hdn_appointment_id").val();
        var item_id = $(thisElement).attr("data-id");
        var pres_id = $(thisElement).attr("pres-id");
        var data_route = $(thisElement).attr("data-route");
        var data_row_id = $(thisElement).attr("data-row-id");

        if (item_id == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Item"
            );
            return;
        }
        var action = $(thisElement).attr("data-action");
        var alternative = $(thisElement).attr("data-alternative-action");
        var title = $(thisElement).attr("title");
        var modal = $(thisElement).attr("data-modal");
        console.log(alternative);

        $.ajax({
            async: true,
            url: alternative,
            data: {
                item_id: item_id,
                hdn_appointment_id: hdn_appointment_id,
                patient_id: patient_id,
                data_route: data_route,
                data_row_id: data_row_id,
                pres_id: pres_id,
            },
            type: "post",
            beforeSend: function () {
                blockUI();
                $("." + modal).modal("show");
                $("." + modal + " .modal-body").html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                );
                $("." + modal + " .modal-title").html(title);
            },
            success: function (data) {
                $("." + modal + " .modal-body").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });
    },
    addNewPrescriptionLookup: function (thisElement) {
        var item_name = $(thisElement).val();
        console.log(item_name);
        var item_name = $(thisElement).attr("data-name");
        var item_type = $(thisElement).attr("data-type");
        var action_url = $(thisElement).attr("data-url");

        var data_duration = $(thisElement).attr("data-duration");
        var data_route = $(thisElement).attr("data-route");
        var data_dose = $(thisElement).attr("data-dose");
        var data_quantity = $(thisElement).attr("data-quantity");
        var data_continue = $(thisElement).attr("data-continue");
        var data_instruction = $(thisElement).attr("data-instruction");
        var data_duration_type = $(thisElement).attr("data-duration-type");

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    item_id: item_id,
                    item_name: item_name,
                    item_type: item_type,
                    data_duration: data_duration,
                    data_route: data_route,
                    data_dose: data_dose,
                    data_quantity: data_quantity,
                    data_continue: data_continue,
                    data_instruction: data_instruction,
                    data_duration_type: data_duration_type,
                },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    $(".loading-img").html(
                        '<i class="spinner-border spinner-border-sm float-right"></i>'
                    );
                },
                success: function (data) {
                    $("#pres-favourit-list").html(data);
                },
                complete: function () {
                    $(".loading-img").html("");
                },
            });
        }
    },
    loadToPresFavouritList: function (
        thisElement,
        item_type,
        title,
        append_to,
        action_url
    ) {
        $(thisElement)
            .parents("#cc-con")
            .find(".card-body")
            .removeClass("bg-light-blue");
        $(thisElement).parents("#cc-con .card-body").addClass("bg-light-blue");
        var hdn_su_no = $("#hdn_su_no").val();
        // console.log(hdn_su_no);
        $.ajax({
            async: true,
            data: { item_type: item_type, hdn_su_no: hdn_su_no },
            url: action_url,
            type: "post",
            beforeSend: function () {
                $(".loading-img").html(
                    '<i class="spinner-border spinner-border-sm float-right"></i>'
                );
            },
            success: function (data) {
                console.log(data);
                $("#favourit_list_title").html(title + " Favourite List ");
                $("#favourit_list_title").attr("data-append-to", append_to);
                $("#pres-favourit-list").html(data);
                $("#favListSearch").attr("searcAttrvalue", item_type);
            },
            complete: function () {
                $(".loading-img").html("");
            },
        });
    },
    prescriptionTemplateDelete: function (thisElement) {
        const templateId = $(thisElement).data("template");
        const templateName = $(thisElement).data("template-name");
        const patientId = $("#hdn_patient_id").val();
        const hdnSuNo = $("#hdn_su_no").val();

        if (templateId) {
            const hdnPrescriptionId = $("#hdn_prescription_id").val();

            if (hdnPrescriptionId) {
                if (
                    !confirm("Are you sure you want to delete this template?")
                ) {
                    return;
                }
            }

            const dtlsAction = $(thisElement).data("dtls-action");
            $.ajax({
                url: dtlsAction,
                type: "POST",
                data: {
                    template_id: templateId,
                    patient_id: patientId,
                    template_name: templateName,
                    hdn_su_no: hdnSuNo,
                },
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    // Replace alert with a notification/modal
                    alert(data.message);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(
                        "Error deleting template:",
                        textStatus,
                        errorThrown
                    );
                    alert(
                        "An error occurred while deleting the template. Please try again."
                    );
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        } else {
            $.unblockUI();
        }
    },

    prescriptionTemplateDeleteAlert: function (thisElement) {
        alert("You Cant't Delete This Template !");
        return false;
    },

    addFromFavouritList: function (thisElement) {
        var item_name = $(thisElement).attr("data-item-name");
        var lookup_id = $(thisElement).attr("data-lookup-id");
        var lookup_code = $(thisElement).attr("data-lookup-code");
        if (lookup_code == "INVFIND") {
            var lookup_data_code = "SERVICE";
            var item_id = item_name;
        } else {
            var lookup_data_code = $(thisElement).attr("data-lookup-data-code");
            var item_id = $(thisElement).val();
        }

        var append_to = $("#favourit_list_title").attr("data-append-to");
        console.log(
            item_name,
            lookup_id,
            lookup_code,
            lookup_data_code,
            item_id,
            append_to
        );
        if (thisElement.checked) {
            var lookup_data =
                "<li id='item-" +
                item_id +
                "'><input class='left-element' type='hidden' name='item_dtl_val[]' value=''><input class='left-element' type='hidden' name='item_id[]' value='" +
                item_id +
                "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                item_name +
                "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                lookup_id +
                "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                lookup_code +
                "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                lookup_data_code +
                "' readonly='readonly'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='session_duration[]'>  <input type='hidden' name='no_of_session[]'> <input type='hidden' name='session_mu[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
                item_name +
                "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' data-id='" +
                item_id +
                "' data-name='" +
                item_name +
                "'><i class='fa fa-star'></i></span></li>";

            $(append_to).append(lookup_data);
        } else {
            $(append_to + " #item-" + item_id).remove();
        }
    },
    addItemsDataMostUse: function (thisElement) {
        $(thisElement).addClass("bg-primary");
        var item_name = $(thisElement).attr("data-item-name");
        var lookup_id = $(thisElement).attr("data-lookup-id");
        var lookup_code = $(thisElement).attr("data-lookup-code");
        var lookup_data_code = $(thisElement).attr("data-lookup-data-code");
        var item_id = $(thisElement).attr("data-id-value");
        var append_to = $("#favourit_list_title").attr("data-append-to");
        console.log(
            item_name,
            lookup_id,
            lookup_code,
            lookup_data_code,
            item_id,
            append_to
        );
        // if (thisElement.checked) {
        var lookup_data =
            "<li id='item-" +
            item_id +
            "'><input class='left-element' type='hidden' name='item_dtl_val[]' value=''><input class='left-element' type='hidden' name='item_id[]' value='" +
            item_id +
            "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
            item_name +
            "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
            lookup_data_code +
            "' readonly='readonly'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='session_duration[]'> <input type='hidden' name='no_of_session[]'> <input type='hidden' name='session_mu[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
            item_name +
            "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' data-id='" +
            item_id +
            "' data-name='" +
            item_name +
            "'><i class='fa fa-star'></i></span></li>";
        console.log(lookup_data);
        $(append_to).append(lookup_data);

        $("#hidden_group_data").append(lookup_data);
        // } else {
        //     $(append_to + " #item-" + item_id).remove();
        // }
    },
    addItemsDataMostUseUhl: function (thisElement) {
        $(thisElement).addClass("bg-primary");
        var item_name = $(thisElement).attr("data-item-name");
        var lookup_id = $(thisElement).attr("data-lookup-id");
        var lookup_code = $(thisElement).attr("data-lookup-code");
        var lookup_data_code = $(thisElement).attr("data-lookup-data-code");
        var item_id = $(thisElement).attr("data-id-value");
        var append_to = $("#favourit_list_title").attr("data-append-to");
        console.log(
            item_name,
            lookup_id,
            lookup_code,
            lookup_data_code,
            item_id,
            append_to
        );
        // if (thisElement.checked) {
        var lookup_data =
            "<li id='item-" +
            item_id +
            "'><input class='left-element' type='hidden' name='item_dtl_val[]' value=''><input class='left-element' type='hidden' name='item_id[]' value='" +
            item_id +
            "' readonly='readonly'><input class='left-element' style='width:90%' type='text'  name='item_name[]' value='" +
            item_name +
            "' ><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
            lookup_data_code +
            "' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";
        console.log(lookup_data);
        $(append_to).append(lookup_data);

        $("#hidden_group_data").append(lookup_data);
        // } else {
        //     $(append_to + " #item-" + item_id).remove();
        // }
    },
    mosUsedIdPass: function (thisElement) {
        var id = $(thisElement).attr("data-append-id");
        $("#favourit_list_title").attr("data-append-to", id);
    },
    savePTPrescription: function (thisElement) {
        var flag = false;
        $(".left-element").each(function () {
            if (this.value != "") {
                flag = true;
                return false;
            }
        });

        if (!flag) {
            // old
            // alert("You did not select any Medication.")
            // new
            var action = $(thisElement).attr("data-response_action");
            var riderect_action = $(thisElement).attr("data-riderect_action");
            var items = $('input[name="item_name[]"]');
            var appointment_date = $("#hdn_appointment_date").val();
            btnSaveUpdate(
                $(thisElement),
                "afterSaveModal",
                action,
                "common-modal-md",
                "Prescription",
                dynamicFunc.afterSaveLoadPage,
                riderect_action
            );
            // End
        } else {
            var action = $(thisElement).attr("data-response_action");
            var riderect_action = $(thisElement).attr("data-riderect_action");
            var items = $('input[name="item_name[]"]');
            var appointment_date = $("#hdn_appointment_date").val();
            btnSaveUpdate(
                $(thisElement),
                "afterSaveModal",
                action,
                "common-modal-md",
                "Prescription",
                dynamicFunc.afterSaveLoadPage,
                riderect_action
            );
        }
    },
    calculateFollowupDate: function (thisElement) {
        $(".date_picker_app").datepicker({
            format: "mm-dd-yyyy",
            autoclose: true,
            clearBtn: true,
            // todayHighlight: true,
        });
        var followup_after = $("#followup_after").val() * 1;
        var followup_after_mu = $("#followup_after_mu").val();
        var num_of_days = 0;
        if (followup_after_mu == "DAY") {
            num_of_days = followup_after;
        }
        if (followup_after_mu == "MONTH") {
            num_of_days = followup_after * 30;
        }

        var nextFollowUpDate = new Date();
        nextFollowUpDate.setDate(nextFollowUpDate.getDate() + num_of_days);

        // var todayDate = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();

        // var date = new Date(todayDate);
        // var newdate = new Date(date);

        // newdate.setDate(newdate.getDate() + num_of_days);

        var dd = nextFollowUpDate.getDate();
        var mm = nextFollowUpDate.getMonth() + 1;
        var y = nextFollowUpDate.getFullYear();
        var someFormattedDate = dd + "-" + mm + "-" + y;

        // console.log($(".date_picker").datepicker().children('input'));
        // $("#next_followup").val(someFormattedDate);
        $(".date_picker_app").datepicker("update", someFormattedDate);
        // $(".date_picker").datepicker().children('input').val(someFormattedDate);
    },

    addMoreDropdownOption: function (thisElement, dropdown_class) {
        var dropdown_option = $(thisElement)
            .parents("tr")
            .find(dropdown_class + " option:selected")
            .attr("data-dropdown_option");
        var dropdown_option_edit = $(thisElement).data("dropdown_option_edit");

        if (dropdown_option == "add_more") {
            var popup_header = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-popup_header");

            var input_label = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-input_label");

            var input_placeholder = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-input_placeholder");

            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
            // console.log(
            //     "Header: " +
            //     popup_header +
            //     " label: " +
            //     input_label +
            //     " Placeholder: " +
            //     input_placeholder
            // );
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option") {
            // var instruction_val = $('.instructionEdit').val(); //previous
            var instruction_val = $(thisElement)
                .siblings("div")
                .find(".instructionEdit")
                .val(); //added by Emon
            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(instruction_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option_dose") {
            console.log(dropdown_option_edit + "__________nazmul");

            // var dose_val = $('.doseEdit').val(); //previous
            var dose_val = $(thisElement)
                .siblings("div")
                .find(".doseEdit")
                .val(); //added by Emon
            console.log(dose_val + "__________nazmul_dose");
            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(dose_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option_route") {
            // var route_val = $('.route_edit').val(); //previous
            var route_val = $(thisElement)
                .siblings("div")
                .find(".route_edit")
                .val(); //added by Emon
            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(route_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else {
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
            $("#addMoreDropdownOption").modal("hide");
        }
    },
     addMoreDropdownOptionV1: function (thisElement, dropdown_class) {
        var dropdown_option = $(thisElement)
            .parents("tr")
            .find(dropdown_class + " option:selected")
            .attr("data-dropdown_option");
        var dropdown_option_edit = $(thisElement).data("dropdown_option_edit");

        if (dropdown_option == "add_more") {
            var popup_header = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-popup_header");

            var input_label = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-input_label");

            var input_placeholder = $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:selected")
                .attr("data-input_placeholder");

            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
            // console.log(
            //     "Header: " +
            //     popup_header +
            //     " label: " +
            //     input_label +
            //     " Placeholder: " +
            //     input_placeholder
            // );
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option") {
            // var instruction_val = $('.instructionEdit').val(); //previous
            // var instruction_val = $(thisElement)
            //     .siblings("div")
            //     .find(".instructionEdit")
            //     .val(); //added by Emon

                var instruction_val = $(thisElement)
                    .parents("tr")
                    .find(".instructionEdit")
                    .val();
            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(instruction_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option_dose") {
            console.log(dropdown_option_edit + "__________nazmul");

            // var dose_val = $('.doseEdit').val(); //previous
            // var dose_val = $(thisElement)
            //     .siblings("div")
            //     .find(".doseEdit")
            //     .val(); //added by Emon

                 var dose_val = $(thisElement)
                    .parents("tr")
                    .find(".doseEdit")
                    .val();
        //    var route_text = $(thisElement)
        // .parents("tr")
        // .find(".route_edit option:selected")
        // .text();


            console.log(dose_val + "__________nazmul_dose");
            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(dose_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else if (dropdown_option_edit == "edit_option_route") {
                var route_val = $(thisElement)
                .parents("tr")
                .find(".route_edit")
                .val();
                var route_text = $(thisElement)
                .parents("tr")
                .find(".route_edit option:selected")
                .text();

    console.log("Selected Route Value: " + route_val); // এখানে value আসবে (oral)
    console.log("Selected Route Text: " + route_text); // এখানে টেক্সট আসবে (oral)

            var popup_header = $(thisElement).data("popup_header");
            var input_label = $(thisElement).data("input_label");
            var input_placeholder = $(thisElement).data("input_placeholder");
            $("#new_dropdown_opt").css({
                "border-color": "gray",
                "border-weight": "1px",
                "border-style": "solid",
            });
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val(route_val);
            $("#addMoreDropdownOptionHeader").text("Add New " + popup_header);
            $("#addMoreDropdownOptionLabel").text(input_label);
            $(thisElement)
                .parents("tr")
                .find(dropdown_class + " option:first")
                .prop("selected", true);
            $("#thisElement_id").val(thisElement.id);
            $("#new_dropdown_opt").attr("placeholder", input_placeholder);
            $("#addMoreDropdownOption").modal("show");
        } else {
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
            $("#addMoreDropdownOption").modal("hide");
        }
    },

    addToDropdown: function (thisElement) {
        var element_id = $("#thisElement_id").val();
        var new_option = $("#new_dropdown_opt").val();
        if (new_option) {
            $("#addMoreDropdownOption").modal("hide");
            $("#" + element_id)
                .find("option:last")
                .before(
                    '<option  data-qnty="" value="' +
                        new_option +
                        '" selected="selected" >' +
                        new_option +
                        "</option>"
                );
            $("#thisElement_id").val("");
            $("#new_dropdown_opt").val("");
        } else {
            $("#new_dropdown_opt").css({
                "border-color": "red",
                "border-weight": "1px",
                "border-style": "solid",
            });
        }

        // Add Lookup Data prescription
        // var formID = $(thisElement).parents("form").attr("id");
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var formData = $("#" + formID).serialize();

        //  $("#" + element_id)
        //             .siblings('[name="item_id[]"]')
        //             .val(data.id);
        // $.ajax({
        //     async: true,
        //     data: { element_id: element_id, new_option: new_option },
        //     url: formAction,
        //     type: formMethod,
        //     cache: false,
        //     beforeSend: function () {
        //         blockUI();
        //     },
        //     success: function (data) {
        //         $("#" + element_id)
        //             .siblings('[name="item_id[]"]')
        //             .val(data.id);
        //         console.log(data.id);
        //     },
        //     complete: function () {
        //         $.unblockUI();
        //     },
        // });
    },
    calculateMedicineQnty: function (thisElement) {
        var dose_other_qnty = $(thisElement)
            .parents("tr")
            .find(".medicine_dose option:selected")
            .attr("data-qnty");
        var dose = $(thisElement).parents("tr").find(".medicine_dose").val();
        var medicine_duration =
            $(thisElement).parents("tr").find(".medicine_duration").val() * 1;
        var medicine_duration_mu = $(thisElement)
            .parents("tr")
            .find(".medicine_duration_mu")
            .val();

        var dosearray = dose.split("+");

        var total_dose = 0;
        for (var i = 0; i < dosearray.length; i++) {
            total_dose += parseInt(dosearray[i]);
        }

        if (medicine_duration_mu == "DAY") {
            var net_duration = medicine_duration * 1;
        } else if (medicine_duration_mu == "WEEK") {
            var net_duration = medicine_duration * 7;
        } else {
            var net_duration = medicine_duration * 30;
        }

        if (dose_other_qnty == "" && dosearray.length > 1) {
            // console.log(dosearray, dose_other_qnty, dosearray.length);
            console.log(dose_other_qnty);
            $(thisElement)
                .parents("tr")
                .find(".medicine_quantity")
                .val(net_duration * total_dose);
        } else {
            $(thisElement).parents("tr").find(".medicine_quantity").val(1);
        }
    },
    selectNewItem: function (thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $(thisElement)
                        .parents("table")
                        .find("tbody tr#1 #hdn_item_id_1")
                        .val(data.item_id);
                    $(thisElement)
                        .parents("table")
                        .find("tbody tr#1 #hdn_item_name_1")
                        .val(data.item_name);
                    $(thisElement)
                        .parents("table")
                        .find("tbody tr#1 .item_element")
                        .val(data.item_name);
                },
                complete: function () {
                    $.unblockUI();
                    if (isAModalOpen) $(".modal").modal("hide");
                },
            });
        }

        event.stopImmediatePropagation();
    },
    addRow: function (thisElement, type) {
        var row = $(thisElement).parents("tr").clone();
        var newId =
            $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr("id", newId);
        if (type == "THRPEX") {
            row.find("#te_item_name_" + oldId).attr(
                "id",
                "te_item_name_" + newId
            );
            row.find("#te_session_mu_" + oldId).attr(
                "id",
                "te_session_mu_" + newId
            );
            row.find("#te_session_duration_" + oldId).attr(
                "id",
                "te_session_duration_" + newId
            );
            row.find("#te_session_unit_" + oldId).attr(
                "id",
                "te_session_unit_" + newId
            );
            row.find("#te_td_action_" + oldId).attr(
                "id",
                "te_td_action_" + newId
            );
            row.find("#te_hdn_item_id_" + oldId).attr(
                "id",
                "te_hdn_item_id_" + newId
            );
            row.find("#te_hdn_item_name_" + oldId).attr(
                "id",
                "te_hdn_item_name_" + newId
            );
            row.find("#te_hdn_lookup_id_" + oldId).attr(
                "id",
                "te_hdn_lookup_id_" + newId
            );
            row.find("#te_hdn_lookup_code_" + oldId).attr(
                "id",
                "te_hdn_lookup_code_" + newId
            );
            row.find("#te_hdn_lookupdata_code_" + oldId).attr(
                "id",
                "te_hdn_lookupdata_code_" + newId
            );
            row.find("#te_unit_intensity_mu_" + oldId).attr(
                "id",
                "te_unit_intensity_mu_" + newId
            );
            row.find("#te_unit_intensity_" + oldId).attr(
                "id",
                "te_unit_intensity_" + newId
            );
            row.find("#te_no_of_session_" + oldId).attr(
                "id",
                "te_no_of_session_" + newId
            );
            row.find("#ptte_favourit_" + oldId).attr(
                "id",
                "ptte_favourit_" + newId
            );
            row.find("#te_frequency_" + oldId).attr(
                "id",
                "te_frequency_" + newId
            );
            row.find("#te_mode_" + oldId).attr("id", "te_mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_t_repetition_" + oldId).attr(
                    "id",
                    "in_t_repetition_" + newId
                );
                row.find("#in_t_duration_" + oldId).attr(
                    "id",
                    "in_t_duration_" + newId
                );
                row.find("#in_e_location_for_thr_" + oldId).attr(
                    "id",
                    "in_e_location_for_thr_" + newId
                );
            }
            row.find("#te_session_mu_" + newId).val(
                $(thisElement).parents("tbody").find("#te_session_mu_1").val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#te_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_unit_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_unit_intensity_mu_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_t_repetition_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_t_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_for_thr_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#te_hdn_item_id_" + newId).val();
            var med_item_name = row.find("#te_hdn_item_name_" + newId).val();

            row.find("#ptte_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="PTTE"><i class="fa fa-star text-primary"></i></span>'
            );
        }

        if (type == "ETHER") {
            row.find("#et_item_name_" + oldId).attr(
                "id",
                "et_item_name_" + newId
            );
            row.find("#et_item_name_" + oldId).attr("readonly", "readonly");
            row.find("#et_unit_intensity_mu_" + oldId).attr(
                "id",
                "et_unit_intensity_mu_" + newId
            );
            row.find("#et_session_duration_" + oldId).attr(
                "id",
                "et_session_duration_" + newId
            );
            row.find("#et_unit_intensity_" + oldId).attr(
                "id",
                "et_unit_intensity_" + newId
            );
            row.find("#et_td_action_" + oldId).attr(
                "id",
                "et_td_action_" + newId
            );
            row.find("#et_hdn_item_id_" + oldId).attr(
                "id",
                "et_hdn_item_id_" + newId
            );
            row.find("#et_hdn_item_name_" + oldId).attr(
                "id",
                "et_hdn_item_name_" + newId
            );
            row.find("#et_hdn_lookup_id_" + oldId).attr(
                "id",
                "et_hdn_lookup_id_" + newId
            );
            row.find("#et_hdn_lookup_code_" + oldId).attr(
                "id",
                "et_hdn_lookup_code_" + newId
            );
            row.find("#et_hdn_lookupdata_code_" + oldId).attr(
                "id",
                "et_hdn_lookupdata_code_" + newId
            );
            row.find("#et_session_mu_" + oldId).attr(
                "id",
                "et_session_mu_" + newId
            );
            row.find("#et_no_of_session_" + oldId).attr(
                "id",
                "et_no_of_session_" + newId
            );
            row.find("#ptet_favourit_" + oldId).attr(
                "id",
                "ptet_favourit_" + newId
            );
            row.find("#et_frequency_" + oldId).attr(
                "id",
                "et_frequency_" + newId
            );
            row.find("#et_mode_" + oldId).attr("id", "et_mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_e_location_" + oldId).attr(
                    "id",
                    "in_e_location_" + newId
                );
                row.find("#in_e_duration_" + oldId).attr(
                    "id",
                    "in_e_duration_" + newId
                );
                row.find("#in_m_repetition_loc_" + oldId).attr(
                    "id",
                    "in_m_repetition_loc_" + newId
                );
            }
            row.find("#et_unit_intensity_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#et_unit_intensity_mu_" + oldId)
                    .val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#et_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_unit_intensity_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#et_unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#et_no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_repetition_loc_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#et_hdn_item_id_" + newId).val();
            var med_item_name = row.find("#et_hdn_item_name_" + newId).val();

            row.find("#ptet_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>'
            );
        }
        if (type == "ACUP") {
            row.find("#acup_item_name_" + oldId).attr(
                "id",
                "acup_item_name_" + newId
            );
            row.find("#acup_item_name_" + oldId).attr("readonly", "readonly");
            row.find("#unit_intensity_mu_" + oldId).attr(
                "id",
                "unit_intensity_mu_" + newId
            );
            row.find("#session_duration_" + oldId).attr(
                "id",
                "session_duration_" + newId
            );
            row.find("#unit_intensity_" + oldId).attr(
                "id",
                "unit_intensity_" + newId
            );
            row.find("#acup_td_action_" + oldId).attr(
                "id",
                "acup_td_action_" + newId
            );
            row.find("#hdn_item_id_" + oldId).attr(
                "id",
                "hdn_item_id_" + newId
            );
            row.find("#hdn_item_name_" + oldId).attr(
                "id",
                "hdn_item_name_" + newId
            );
            row.find("#hdn_lookup_id_" + oldId).attr(
                "id",
                "hdn_lookup_id_" + newId
            );
            row.find("#hdn_lookup_code_" + oldId).attr(
                "id",
                "hdn_lookup_code_" + newId
            );
            row.find("#hdn_lookupdata_code_" + oldId).attr(
                "id",
                "hdn_lookupdata_code_" + newId
            );
            row.find("#session_mu_" + oldId).attr("id", "session_mu_" + newId);
            row.find("#no_of_session_" + oldId).attr(
                "id",
                "no_of_session_" + newId
            );
            row.find("#acup_favourit_" + oldId).attr(
                "id",
                "acup_favourit_" + newId
            );
            row.find("#frequency_" + oldId).attr("id", "frequency_" + newId);
            row.find("#mode_" + oldId).attr("id", "mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_m_repetition_" + oldId).attr(
                    "id",
                    "in_m_repetition_" + newId
                );
                row.find("#in_m_duration_" + oldId).attr(
                    "id",
                    "in_m_duration_" + newId
                );
                row.find("#in_e_location_for_acup_" + oldId).attr(
                    "id",
                    "in_e_location_for_acup_" + newId
                );
            }
            row.find("#unit_intensity_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#unit_intensity_mu_" + oldId)
                    .val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#acup_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#unit_intensity_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_repetition_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_for_acup_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#hdn_item_id_" + newId).val();
            var med_item_name = row.find("#hdn_item_name_" + newId).val();

            row.find("#acup_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="ACUP"><i class="fa fa-star text-primary"></i></span>'
            );
        }

        $(thisElement).parents("#data-append-to").append(row);

        if (type == "THRPEX") {
            openItemAutocomplete(
                $("#te_item_name_" + newId),
                "PT",
                "#te_hdn_item_id_" + newId,
                "#te_hdn_item_name_" + newId,
                "203",
                "PTTE"
            ); // 3 = SERVICE ITEM TYPE
            $("#te_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('THRPEX');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#te_hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#te_hdn_item_name_" + newId).attr(
                    "name",
                    "item_name[]"
                );
                row.find("#te_hdn_lookup_id_" + newId).attr(
                    "name",
                    "lookup_id[]"
                );
                row.find("#te_hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#te_hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#te_unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#te_frequency_" + newId).attr("name", "frequency[]");
                row.find("#te_mode_" + newId).attr("name", "mode[]");
                row.find("#te_session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#te_no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#te_session_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_t_repetition_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_t_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
                row.find("#in_e_location_for_thr_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
            }
        }

        if (type == "ETHER") {
            openItemAutocomplete(
                $("#et_item_name_" + newId),
                "PT",
                "#et_hdn_item_id_" + newId,
                "#et_hdn_item_name_" + newId,
                "202",
                "PTET"
            ); // 3 = SERVICE ITEM TYPE
            $("#et_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#et_hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#et_hdn_item_name_" + newId).attr(
                    "name",
                    "item_name[]"
                );
                row.find("#et_hdn_lookup_id_" + newId).attr(
                    "name",
                    "lookup_id[]"
                );
                row.find("#et_hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#et_hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#et_no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#et_frequency_" + newId).attr("name", "frequency[]");
                row.find("#et_mode_" + newId).attr("name", "mode[]");
                row.find("#et_session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#et_unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#et_unit_intensity_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_e_location_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
                row.find("#in_m_repetition_loc_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_e_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
            }
        }
        if (type == "ACUP") {
            openItemAutocomplete(
                $("#acup_item_name_" + newId),
                "PT",
                "#hdn_item_id_" + newId,
                "#hdn_item_name_" + newId,
                "242",
                "ACUP"
            ); // 3 = SERVICE ITEM TYPE
            $("#acup_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#hdn_item_name_" + newId).attr("name", "item_name[]");
                row.find("#hdn_lookup_id_" + newId).attr("name", "lookup_id[]");
                row.find("#hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#frequency_" + newId).attr("name", "frequency[]");
                row.find("#mode_" + newId).attr("name", "mode[]");
                row.find("#session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#unit_intensity_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_m_repetition_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_m_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
                row.find("#in_e_location_for_acup_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
            }
        }
        console.log(type);
    },
    addMedRow: function (thisElement) {
        var checkEmpty = $("#medicine_item_0").val().trim();
        if (checkEmpty === "") {
            alert("Medichine Name is Empty!");
        } else {
            var hospital_code = $("#hospital_code").val();
            console.log("ok_nazmul");
            var lookup_code = $(thisElement).attr("data-lookup-code");
            var item_id = (item_name = "");
            if (lookup_code == "MED") {
                var item_id = $(thisElement).val();
                var item_name = $(thisElement).attr("data-item-name");

                var data_route_med = $(thisElement).attr("data-route-med");
                var data_dose_med = $(thisElement).attr("data-dose-med");
                var data_duration_med =
                    $(thisElement).attr("data-duration-med");
                var data_duration_mu_med = $(thisElement).attr(
                    "data-duration-mu-med"
                );
                var data_quantity_med =
                    $(thisElement).attr("data-quantity-med");
                var data_instruction_med = $(thisElement).attr(
                    "data-instruction-med"
                );

                thisElement = $("#med_td_action_0 span");
            }
            var hdn_item_id_alert = $("#hdn_medicine_item_id_0").val();
            // check med row
            var same_item = false;

            if (
                hdn_item_id_alert !== "" &&
                hdn_item_id_alert !== 0 &&
                hdn_item_id_alert !== "0" &&
                hdn_item_id_alert !== undefined
            ) {
                $("input.same-item-id").each(function (_, elem) {
                    if ($(elem).val() === hdn_item_id_alert) {
                        same_item = true;
                        return false;
                    }
                });
            } else {
                $("input.same-item-name").each(function (_, elem) {
                    console.log($(elem).val());
                    if ($(elem).val() === checkEmpty) {
                        same_item = true;
                        return false;
                    }
                });
            }

            if (same_item) {
                alert("You have already taken this item.");
                $("#hdn_medicine_item_id_0").val("");
                $("#medicine_item_0").val("");
                return false;
            }

            // var same_gen = false;
            // $("input[class=same-gen-id]").each(function (index, elem) {
            //     if ($(elem).val() == hdn_gen_name) {
            //         same_gen = true;
            //         return false;
            //     }
            // });
            // if (same_gen == true) {
            //     $("#hdn_medicine_item_id_0").val("");
            //     $("#hdn_gen_name_0").val("");
            //     $("#medicine_item_0").val("");
            //     return false;
            // }

            var row = $(thisElement).parents("tr").clone();
            var newId = $(thisElement)
                .parents("#data-append-to")
                .find("tr").length;
            var oldId = Number($(thisElement).parents("tr").attr("id"));

            row.attr("id", "tr_id_" + newId);

            row.find("#hdn_report_serial_med_" + oldId).attr(
                "id",
                "hdn_report_serial_med_" + newId
            );
            row.find("#hidden_multidose_id_" + oldId).attr(
                "id",
                "hidden_multidose_id_" + newId
            );
            row.find("#hdn_medicine_item_id_" + oldId).attr(
                "id",
                "hdn_medicine_item_id_" + newId
            );
            row.find("#medicine_item_" + oldId)
                .attr("id", "medicine_item_" + newId)
                .css({ "background-color": "#ffffff", border: "0px" });
            row.find("#med_favourit_" + oldId).attr(
                "id",
                "med_favourit_" + newId
            );
            row.find("#alternative_id_" + oldId).attr(
                "id",
                "alternative_id_" + newId
            );
            row.find("#medicine_dose_" + oldId).attr(
                "id",
                "medicine_dose_" + newId
            );
            row.find("#medicine_duration_mu_" + oldId).attr(
                "id",
                "medicine_duration_mu_" + newId
            );
            row.find("#medicine_duration_type_" + oldId).attr(
                "id",
                "medicine_duration_type_" + newId
            );
            row.find("#medicine_quantity_" + oldId).attr(
                "id",
                "medicine_quantity_" + newId
            );
            row.find("#instruction_" + oldId).attr(
                "id",
                "instruction_" + newId
            );
            row.find("#medicine_route_" + oldId).attr(
                "id",
                "medicine_route_" + newId
            );
            row.find("#is_continue_" + oldId).attr(
                "id",
                "is_continue_" + newId
            );
            //row.find('#is_chronic_' + oldId).attr('id', 'is_chronic_' + newId);
            row.find("#med_td_action_" + oldId).attr(
                "id",
                "med_td_action_" + newId
            );

            var interaction_route = $("#hdn_interaction_url").val();
            var hdn_patient_id = $("#hdn_patient_id").val();
            if (lookup_code == "MED") {
                row.find("#hdn_medicine_item_id_" + newId).val(item_id);
                row.find("#medicine_item_" + newId).val(item_name);
                row.find("#medicine_route_" + newId)
                    .val(data_route_med)
                    .change();
                // row.find('#medicine_quantity_' + newId).val(data_quantity_med);
                // row.find('#medicine_duration_type_' + newId).val(data_duration_med);
            }

            row.find("#is_continue_" + newId).val(newId);
            row.find("#hdn_report_serial_med_" + newId).val(newId);

            row.find("#hdn_report_serial_med_" + newId).val(newId);
            row.find("#hidden_multidose_id_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#hidden_multidose_id_" + oldId)
                    .val()
            );
            row.find("#medicine_dose_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_dose_" + oldId)
                    .val()
            );
            row.find("#medicine_duration_type_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_type_" + oldId)
                    .val()
            );
            row.find("#instruction_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#instruction_" + oldId)
                    .val()
            );
            row.find("#medicine_route_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_route_" + oldId)
                    .val()
            );
            row.find("#medicine_duration_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_mu_" + oldId)
                    .val()
            );

            row.find("#hdn_medicine_item_id_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#hdn_medicine_item_id_" + oldId)
                    .addClass("same-item-id")
            );
            // row.find("#medicine_item_" + newId).val(
            //     $(thisElement)
            //         .parents("tbody")
            //         .find("#medicine_item_" + oldId)
            //         .addClass("same-item-name")
            // );
            // row.find("#hdn_medicine_item_id_" + oldId)
            //     .attr("id", "hdn_medicine_item_id_" + newId)
            //     .addClass("same-item-id");

            $(thisElement)
                .parents("tbody")
                .find("#hdn_report_serial_med_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hidden_multidose_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_medicine_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_item_" + oldId)
                .val("");
            // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');

            // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).select2("val", "0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_mu_" + oldId)
                .val("DAY");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_type_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_quantity_" + oldId)
                .val("");

            // $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#instruction_' + oldId).select2("val", "0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_route_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#instruction_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#medicine_dose_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#is_continue_" + oldId)
                .prop("checked", false);

            // $(thisElement).parents('tbody').find('#medicine_route_' + oldId).select2("val", "0");

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var data_multidose_action = $(thisElement).attr(
                "data-multidose-action"
            );
            var data_alternative_action = $(thisElement).attr(
                "data-alternative-action"
            );
            var med_item_id = row.find("#hdn_medicine_item_id_" + newId).val();

            var med_item_name = row.find("#medicine_item_" + newId).val();

            var med_dose = row.find("#medicine_dose_" + newId).val();
            var med_route = row.find("#medicine_route_" + newId).val();
            var med_duration = row
                .find("#medicine_duration_type_" + newId)
                .val();
            var med_quantity = row.find("#medicine_quantity_" + newId).val();
            var med_continue = row.find("#is_continue_" + newId).val();
            var med_instruction = row.find("#instruction_" + newId).val();
            var med_duration_type = row
                .find("#medicine_duration_mu_" + newId)
                .val();

            row.find("#med_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this,\'#pres-favourit-list-med\')" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '"><i class="fa fa-star text-primary"></i></span> <br />  <span class="float-right text-secondary mr-1 cursor-pointer" data-modal="common-modal-xl" style="font-size:11px;" title="Add Multidose Medicine" onclick="prescriptionFunc.addMultidoseList(this)" data-action="' +
                    data_multidose_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '" data-row-id="' +
                    newId +
                    '"><i class="fa fa-medkit text-danger"></i></span>'
            );
            if (hospital_code != "UNICO") {
                row.find("#alternative_id_" + newId).html(
                    '<span class="float-right text-secondary cursor-pointer" data-modal="common-modal-md" style="font-size:11px;border: 1px solid aqua;padding: 4px;margin-top: 9px;border-radius: 5px;" title="Alternative Medicine" onclick="prescriptionFunc.alternativeMedicine(this)" data-action="' +
                        data_multidose_action +
                        '" data-id="' +
                        med_item_id +
                        '" data-name="' +
                        med_item_name +
                        '" data-type="MED" data-duration="' +
                        med_duration +
                        '" data-route="' +
                        med_route +
                        '" data-dose="' +
                        med_dose +
                        '" data-quantity="' +
                        med_quantity +
                        '" data-continue="' +
                        med_continue +
                        '" data-instruction="' +
                        med_instruction +
                        '" data-duration-type="' +
                        med_duration_type +
                        '" data-row-id="' +
                        newId +
                        '" data-alternative-action="' +
                        data_alternative_action +
                        '">ALT</span>'
                );
            }

            var item_id = row.find("#hdn_medicine_item_id_" + newId).val();
            var interaction_result = "";
            //Interaction hide
            // $.ajax({
            //     async: false,
            //     url: interaction_route,
            //     data: { item_id: item_id, hdn_patient_id: hdn_patient_id },
            //     type: "post",
            //     success: function (data) {
            //         if (data.result != '0') {
            //             interaction_result = '<blockquote class="blockquote"><p class="mb-0">' + data.msg + '</p><footer class="blockquote-footer"><div class="btn btn-outline-danger bg-none btn-md">' + data.seviriaty + '</div></footer></blockquote>';
            //             var msg = interaction_result + '<div class="modal-footer pl-0"><button type="button" class="btn btn-success btn-sm ml-0" id="modal-btn-si" data-dismiss="modal"><i class="fa fa-check"></i> Continue</button><button type="button" class="btn btn-danger btn-sm" id="modal-btn-no" data-dismiss="modal" onclick="prescriptionFunc.discardInteractedMedRow()"><i class="fa fa-times"></i> Discard</button></div>';

            //             $('.common-modal-notify-error').modal('show');
            //             $('.common-modal-notify-error .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            //             $('.common-modal-notify-error .modal-title').html(data.title);
            //             $('.common-modal-notify-error .modal-body').html(msg);
            //         }
            //     }
            // });

            $(thisElement).parents("#data-append-to").append(row);
            $("#medicine_item_0").typeahead("destroy");

            openItemAutocompleteWithStockPrescription(
                $("#medicine_item_0"),
                "MED",
                "#hdn_medicine_item_id_0",
                "#medicine_item_0"
            );

            $("#medicine_item_0").focus();
            // $("#med_td_action_" + newId).html(
            //     "<span class='btn btn-danger btn-sm remove_item' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            // );
            $("#med_td_action_" + newId).html(
                "<div class='btn-group' role='group' aria-label='Button group'>" +
                    "<span class='btn btn-danger btn-md remove_item' onclick='removeTableRowOnly(this)'>" +
                    "<i class='fa fa-times'></i>" +
                    "</span>" +
                    "<button type='button' class='btn btn-primary btn-md add-multidose ml-3' onclick='prescriptionFunc.addMultiDoseRow(this); previewTab()'>" +
                    "<i class='fa fa-clone'></i>" +
                    "</button>" +
                    "</div>"
            );

            $(".select2").select2();
            $(".select2").removeClass("select2-hidden-accessible");
            $(".select2-container").remove();
            // $('.select2').select2({
            //     // placeholder: "Select Value",
            //     allowClear: true
            // });

            // from here
            $(".select2").select2({
                tags: true, // Enable adding new options
                placeholder: "Select or type to add",
                allowClear: true, // Allow clearing selection
                templateResult: formatOption, // Format the display of options
                templateSelection: formatOption, // Format the selected option
            });
            // Function to format the options with data attributes
            function formatOption(option) {
                if (!option.id) {
                    return option.text; // Return the text if it's a new tag
                }
                const $option = $(`<span>${option.text}</span>`);

                // Accessing custom data attributes
                const dataQnty = $(option.element).data("qnty");
                if (dataQnty !== undefined) {
                    $option.append(`${dataQnty}`);
                }

                return $option;
            }

            // added new here
        }
    },

    addMedRowPres: function (thisElement) {
        var hdn_item_id_alert = $("#hdn_medicine_item_id_0").val();
        var same_item = false;
        $("input[class=same-item-id]").each(function (index, elem) {
            if ($(elem).val() == hdn_item_id_alert && hdn_item_id_alert != 0) {
                same_item = true;
                return false;
            }
        });
        if (same_item == true) {
            alert("You have already taken this item.");
            $("#hdn_medicine_item_id_0").val("");
            $("#medicine_item_0").val("");
            return false;
        }

        if (hdn_item_id_alert != "") {
            var lookup_code = $(thisElement).attr("data-lookup-code");
            var item_id = (item_name = "");
            if (lookup_code == "MED") {
                var item_id = $(thisElement).val();
                var item_name = $(thisElement).attr("data-item-name");

                var data_route_med = $(thisElement).attr("data-route-med");
                var data_dose_med = $(thisElement).attr("data-dose-med");
                var data_duration_med =
                    $(thisElement).attr("data-duration-med");
                var data_duration_mu_med = $(thisElement).attr(
                    "data-duration-mu-med"
                );
                var data_quantity_med =
                    $(thisElement).attr("data-quantity-med");
                var data_instruction_med = $(thisElement).attr(
                    "data-instruction-med"
                );

                thisElement = $("#med_td_action_0 span");
            }
            var row = $(thisElement).parents("tr").clone();
            var newId = $(thisElement)
                .parents("#data-append-to")
                .find("tr").length;
            var oldId = Number($(thisElement).parents("tr").attr("id"));

            row.attr("id", "tr_id_" + newId);

            row.find("#hdn_report_serial_med_" + oldId).attr(
                "id",
                "hdn_report_serial_med_" + newId
            );
            row.find("#hidden_multidose_id_" + oldId).attr(
                "id",
                "hidden_multidose_id_" + newId
            );
            row.find("#hdn_medicine_item_id_" + oldId).attr(
                "id",
                "hdn_medicine_item_id_" + newId
            );
            row.find("#medicine_item_" + oldId)
                .attr("id", "medicine_item_" + newId)
                .css({ "background-color": "#ffffff", border: "0px" });
            row.find("#med_favourit_" + oldId).attr(
                "id",
                "med_favourit_" + newId
            );
            row.find("#alternative_id_" + oldId).attr(
                "id",
                "alternative_id_" + newId
            );
            row.find("#medicine_dose_" + oldId).attr(
                "id",
                "medicine_dose_" + newId
            );
            row.find("#medicine_duration_mu_" + oldId).attr(
                "id",
                "medicine_duration_mu_" + newId
            );
            row.find("#medicine_duration_type_" + oldId).attr(
                "id",
                "medicine_duration_type_" + newId
            );
            row.find("#medicine_quantity_" + oldId).attr(
                "id",
                "medicine_quantity_" + newId
            );
            row.find("#instruction_" + oldId).attr(
                "id",
                "instruction_" + newId
            );
            row.find("#medicine_route_" + oldId).attr(
                "id",
                "medicine_route_" + newId
            );
            row.find("#is_continue_" + oldId).attr(
                "id",
                "is_continue_" + newId
            );
            row.find("#med_td_action_" + oldId).attr(
                "id",
                "med_td_action_" + newId
            );

            var interaction_route = $("#hdn_interaction_url").val();
            var hdn_patient_id = $("#hdn_patient_id").val();
            if (lookup_code == "MED") {
                row.find("#hdn_medicine_item_id_" + newId).val(item_id);
                row.find("#medicine_item_" + newId).val(item_name);
                row.find("#medicine_route_" + newId)
                    .val(data_route_med)
                    .change();
            }

            row.find("#is_continue_" + newId).val(newId);
            row.find("#hdn_report_serial_med_" + newId).val(newId);

            row.find("#hdn_report_serial_med_" + newId).val(newId);
            row.find("#hidden_multidose_id_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#hidden_multidose_id_" + oldId)
                    .val()
            );
            row.find("#medicine_dose_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_dose_" + oldId)
                    .val()
            );
            row.find("#medicine_duration_type_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_type_" + oldId)
                    .val()
            );
            row.find("#instruction_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#instruction_" + oldId)
                    .val()
            );
            row.find("#medicine_route_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_route_" + oldId)
                    .val()
            );
            row.find("#medicine_duration_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_mu_" + oldId)
                    .val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#hdn_report_serial_med_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hidden_multidose_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_medicine_item_id_" + oldId)
                .val("");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_item_" + oldId)
                .val("");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_mu_" + oldId)
                .val("DAY");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_type_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_quantity_" + oldId)
                .val("");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_route_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#instruction_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#medicine_dose_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#is_continue_" + oldId)
                .prop("checked", false);

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var data_multidose_action = $(thisElement).attr(
                "data-multidose-action"
            );
            var data_alternative_action = $(thisElement).attr(
                "data-alternative-action"
            );
            var med_item_id = row.find("#hdn_medicine_item_id_" + newId).val();
            var med_item_name = row.find("#medicine_item_" + newId).val();

            var med_dose = row.find("#medicine_dose_" + newId).val();
            var med_route = row.find("#medicine_route_" + newId).val();
            var med_duration = row
                .find("#medicine_duration_type_" + newId)
                .val();
            var med_quantity = row.find("#medicine_quantity_" + newId).val();
            var med_continue = row.find("#is_continue_" + newId).val();
            var med_instruction = row.find("#instruction_" + newId).val();
            var med_duration_type = row
                .find("#medicine_duration_mu_" + newId)
                .val();

            row.find("#hdn_medicine_item_id_" + newId).addClass("same-item-id");

            row.find("#med_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '"><i class="fa fa-star text-primary"></i></span> <br/> <span class="float-right text-secondary mr-1 cursor-pointer" data-modal="common-modal-xl" style="font-size:11px;" title="Add Multidose Medicine" onclick="prescriptionFunc.addMultidoseList(this)" data-action="' +
                    data_multidose_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '" data-row-id="' +
                    newId +
                    '"><i class="fa fa-medkit text-danger"></i></span>'
            );
            row.find("#alternative_id_" + newId).html(
                '<span class="float-right text-secondary cursor-pointer" data-modal="common-modal-md" style="font-size:11px;border: 1px solid aqua;padding: 4px;margin-top: 9px;border-radius: 5px;" title="Alternative Medicine" onclick="prescriptionFunc.alternativeMedicine(this)" data-action="' +
                    data_multidose_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '" data-row-id="' +
                    newId +
                    '" data-alternative-action="' +
                    data_alternative_action +
                    '">ALT</span>'
            );

            var item_id = row.find("#hdn_medicine_item_id_" + newId).val();
            var interaction_result = "";

            $(thisElement).parents("#data-append-to").append(row);
            // $("#instruction_" + newId).select2({});
            // $("#instruction_" + newId).attr('disabled',false);
            // $("#instruction_" + newId).attr('readonly',false);
            $(thisElement)
                .parents("#data-append-to")
                .children("tr")
                .last()
                .children("td")
                .last()
                .html(
                    "<span class='btn btn-danger btn-sm remove_item' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
                );
            $("#medicine_item_0").typeahead("destroy");
            openItemAutocompleteWithStockPrescription(
                $("#medicine_item_0"),
                "MED",
                "#hdn_medicine_item_id_0",
                "#medicine_item_0"
            );

            $("#medicine_item_0").focus();
            $("#hdn_medicine_item_id_0").val(0);
            $("#medicine_item_0").val("");
            // $("#med_td_action_" + newId).html(
            //     "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            // );

            $(".select2").select2();
            $(".select2").removeClass("select2-hidden-accessible");
            $(".select2-container").remove();
            // $('.select2').select2({
            //     // placeholder: "Select Value",
            //     allowClear: true
            // });

            // from here
            $(".select2").select2({
                tags: true, // Enable adding new options
                placeholder: "Select or type to add",
                allowClear: true, // Allow clearing selection
                templateResult: formatOption, // Format the display of options
                templateSelection: formatOption, // Format the selected option
            });
            // Function to format the options with data attributes
            function formatOption(option) {
                if (!option.id) {
                    return option.text; // Return the text if it's a new tag
                }
                const $option = $(`<span>${option.text}</span>`);

                // Accessing custom data attributes
                const dataQnty = $(option.element).data("qnty");
                if (dataQnty !== undefined) {
                    $option.append(`${dataQnty}`);
                }

                return $option;
            }

            // added new here
            // $('.select2-container').css('width','100%');
        } else {
            // console.log('Please Enter Item Name , Dose & Duration')
            alert("Please Enter Item Name");
            return false;
        }
    },
    addNotFoundItem: function (thisElement, typehead_element) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        var typehead_text_format = typehead_text.replace("'", "’");
        // console.log(typehead_text);
        var lookup_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-id");
        var lookup_code = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-code");

        // var lookup_data =
        //     "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" +
        //     typehead_text_format +
        //     "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
        //     lookup_id +
        //     "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
        //     lookup_code +
        //     "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><i class='fa fa-angle-double-right'></i> " +
        //     typehead_text +
        //     "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        var lookup_data =
            "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' style='width:90%' type='text' name='item_name[]' value='" +
            typehead_text_format +
            "'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        $(thisElement)
            .parents(".twitter-typeahead")
            .siblings()
            .find("ul")
            .append(lookup_data);
        $("#" + typehead_id).typeahead("val", "");

        // save advice
        if (lookup_code == "ADVICE") {
            console.log(
                lookup_code + "__nazmul" + typehead_text + "_" + lookup_id
            );
            // Save part
            $.ajax({
                async: true,
                data: {
                    element_id: lookup_code,
                    new_option: typehead_text,
                    lookup_id: lookup_id,
                },
                url: "../public/prescription-lookup/storeprescriptionlookupitem-doctor-chiefcomplain",
                type: "post",

                beforeSend: function () {
                    blockUI();
                },
                success: function (item) {
                    // $(element_id).typeahead('val', typehead_text);
                    // console.log(item)
                    $("#item_generic_id").val(item.insert_id);
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        }
        var hospital_code = $("#hospital_code").val();
        if (hospital_code == "UNICO" || hospital_code == "DMHL") {
            previewTab();
        }
    },

    addNotFoundItemV2: function (thisElement, typehead_element) {
        var hospital_code = $("#hospital_code").val();
        if (hospital_code == "DMHL") {
           var url = '../../../prescription-lookup/storeprescriptionlookupitem-doctor-chiefcomplain';
        }else{
             var url = '../../../../prescription-lookup/storeprescriptionlookupitem-doctor-chiefcomplain';
        }

        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        var typehead_text_format = typehead_text.replace("'", "’");
        // console.log(typehead_text);
        var lookup_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-id");
        var lookup_code = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-code");
            // alert(lookup_code)

        // var lookup_data =
        //     "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" +
        //     typehead_text_format +
        //     "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
        //     lookup_id +
        //     "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
        //     lookup_code +
        //     "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><i class='fa fa-angle-double-right'></i> " +
        //     typehead_text +
        //     "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        var lookup_data =
            "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' style='width:90%' type='text' name='item_name[]' value='" +
            typehead_text_format +
            "'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        $(thisElement)
            .parents(".twitter-typeahead")
            .siblings()
            .find("ul")
            .append(lookup_data);
        $("#" + typehead_id).typeahead("val", "");
        console.log(
            lookup_code + "__nazmul" + typehead_text + "_" + lookup_id
        );
        // save advice
        // if (lookup_code == "ADVICE" || lookup_code == "CHIEFCOM") {

            // Save part
            $.ajax({
                async: true,
                data: {
                    element_id: lookup_code,
                    new_option: typehead_text,
                    lookup_id: lookup_id,
                },
                url: window.routes.storeChiefComplain,
                type: "post",

                beforeSend: function () {
                    blockUI();
                },
                success: function (item) {
                    // $(append_id).html(item);
                    // $(element_id).typeahead('val', typehead_text);
                    // console.log(item)
                    $("#item_generic_id").val(item.insert_id);
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        // }
        var hospital_code = $("#hospital_code").val();
        if (hospital_code == "UNICO" || hospital_code == "DMHL") {
            previewTab();
        }
    },

    addNotFoundGenericItem: function (thisElement, typehead_element) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        // var action = '{{route("item.add-new-item")}}';
        // console.log(action);

        $.ajax({
            async: true,
            data: {
                generic_name: typehead_text,
            },
            url: "../add-new-item",
            type: "post",

            beforeSend: function () {
                blockUI();
            },
            success: function (item) {
                // $(element_id).typeahead('val', typehead_text);
                // console.log(item)
                $("#item_generic_id").val(item.insert_id);
            },
            complete: function () {
                $.unblockUI();
            },
        });
        // var lookup_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-id");
        // var lookup_code = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-code");

        // var lookup_data = "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" + typehead_text + "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + lookup_code + "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><i class='fa fa-angle-double-right'></i> " + typehead_text + "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        // $(thisElement).parents(".twitter-typeahead").siblings().find("ul").append(lookup_data);
        // $("#" + typehead_id).typeahead('val', '');
    },
    addNotFoundMedItem: function (event, thisElement, typehead_element) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        console.log(typehead_text, typehead_id);
        var element_id = $(thisElement).attr("data-element_id");
        var item_id_element = $(thisElement).attr("data-item_id_element");
        $(thisElement).parent().parent().parent("div").val("");
        $("#medicine_route_0").focus();
        //$("#" + typehead_id).typeahead('val', '');
        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hdn_medicine_item_id_0"))
            .val(0);
        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hdn_report_serial_med_0"))
            .val("");

        $("#medicine_item_0")
            .parent("span")
            .siblings($("#medicine_item_0"))
            .val(typehead_text);

        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hidden_multidose_id_0"))
            .val(0);
        $("#hdn_medicine_item_id_0").val(0);

        event.stopImmediatePropagation();
    },

    addNotFoundMedItemDischare: function (
        event,
        thisElement,
        typehead_element
    ) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        console.log(typehead_text, typehead_id);
        alert(typehead_text);
        $(thisElement).parent().parent().parent("div").val("");
        $("#medicine_route_0").focus();
        //$("#" + typehead_id).typeahead('val', '');
        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hdn_medicine_item_id_0"))
            .val(0);
        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hdn_report_serial_med_0"))
            .val("");

        $("#medicine_item_0").val(typehead_text);

        $("#medicine_item_0")
            .parent("span")
            .siblings($("#hidden_multidose_id_0"))
            .val(0);
        $("#hdn_medicine_item_id_0").val(0);

        event.stopImmediatePropagation();
    },

    addNotFoundAcupItem: function (event, thisElement, typehead_element) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        // console.log("typehead_text", thisElement.value);
        var element_id = $(thisElement).attr("data-element_id");
        var item_id_element = $(thisElement).attr("data-item_id_element");

        $(thisElement).parent().parent().parent("div").val("");
        // $("#session_duration_1").focus();
        $(".tt-menu").css("display", "none");
        //$("#" + typehead_id).typeahead('val', '');

        $("#acup_item_name_1")
            .parent("span")
            .siblings("#acup_item_name_1")
            .val(typehead_text);
        // $("#hdn_medicine_item_id_0").val(0);

        $("#acup_item_name_1").parent("span").siblings("#hdn_item_id_1").val(0);
        $("#acup_item_name_1")
            .parent("span")
            .siblings("#hdn_item_name_1")
            .val(typehead_text);
        $("#acup_item_name_1")
            .parent("span")
            .siblings("#hdn_lookup_id_1")
            .val(0);
        $("#acup_item_name_1")
            .parent("span")
            .siblings("#hdn_lookup_code_1")
            .val("ACUP");
        $("#acup_item_name_1")
            .parent("span")
            .siblings("#hdn_lookupdata_code_1")
            .val("ACUP");

        event.stopImmediatePropagation();
    },
    addNotFoundPhyElecItem: function (event, thisElement, typehead_element) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        console.log(typehead_text, typehead_id);
        var element_id = $(thisElement).attr("data-element_id");
        var item_id_element = $(thisElement).attr("data-item_id_element");

        $(thisElement).parent().parent().parent("div").val("");
        // $("#session_duration_1").focus();
        $(".tt-menu").css("display", "none");
        //$("#" + typehead_id).typeahead('val', '');
        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_item_name_1")
            .val(typehead_text);
        // $("#hdn_medicine_item_id_0").val(0);

        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_hdn_item_id_1")
            .val(0);
        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_hdn_item_name_1")
            .val(typehead_text);
        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_hdn_lookup_id_1")
            .val(0);
        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_hdn_lookup_code_1")
            .val("PTET");
        $("#et_item_name_1")
            .parent("span")
            .siblings("#et_hdn_lookupdata_code_1")
            .val("PTET");

        event.stopImmediatePropagation();
    },
    addNotFoundPhyTheraputItem: function (
        event,
        thisElement,
        typehead_element
    ) {
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        console.log(typehead_text, typehead_id);
        var element_id = $(thisElement).attr("data-element_id");
        var item_id_element = $(thisElement).attr("data-item_id_element");

        $(thisElement).parent().parent().parent("div").val("");
        // $("#te_item_name_1").parent("span").parent('td').siblings('td').find("#te_session_duration_1").focus();
        $(".tt-menu").css("display", "none");
        //$("#" + typehead_id).typeahead('val', '');
        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_item_name_1")
            .val(typehead_text);
        // $("#hdn_medicine_item_id_0").val(0);

        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_hdn_item_id_1")
            .val(0);
        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_hdn_item_name_1")
            .val(typehead_text);
        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_hdn_lookup_id_1")
            .val(0);
        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_hdn_lookup_code_1")
            .val("PTTE");
        $("#te_item_name_1")
            .parent("span")
            .siblings("#te_hdn_lookupdata_code_1")
            .val("PTTE");

        event.stopImmediatePropagation();
    },
    addNotFoundInvItem: function (event, thisElement, typehead_element) {
        console.log($("#hdn_pres_route_inv").val());
        var lookup_code = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("lookup-code");
        var lookupdata_codes = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("lookupdata-code");
        if (lookupdata_codes == "FOOD") {
            var lookupdata_code = "FOOD";
        } else if ((lookupdata_codes = "PROCEDURE")) {
            var lookupdata_code = "SUR";
        } else {
            var lookupdata_code = "LAB";
        }

        if (lookup_code === "INVFIND") {
            var lookupdata_code = "SERVICE";
        }
        var typehead_id = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");
        var append_to = $(thisElement)
            .parents(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-append-id");

        console.log(append_to + "_" + "bellal");
        var typehead_text = $("#" + typehead_id).typeahead("val");
        console.log(typehead_text, typehead_id);

        var action_url = $("#hdn_pres_route_inv").val();
        const lookup_data = `
            <li id="item-${typehead_text}">
                <input type="hidden" name="item_id[]" value="0">
                <input type="hidden" name="item_name[]" value="${typehead_text}">
                <input type="hidden" name="session_duration[]" value="">
                <input type="hidden" name="lookup_code[]" value="${lookup_code}">
                <input type="hidden" name="lookupdata_code[]" value="${lookupdata_code}">
                <input type="hidden" class="" id="" name="unit_intensity[]">
                <input type="hidden" class="" id="" name="session_duration[]">
                <input type="hidden" class="" id="" name="no_of_session[]">
                <input type="hidden" class="" id="" name="session_mu[]">
                <input type="hidden" class="" id="" name="frequency[]">
                <input type="hidden" class="" id="" name="mode[]">
                <input type="hidden" name="in_m_duration[]">
                <input type="hidden" name="in_m_repetition[]">
                <input type="hidden" name="in_e_location[]">
                <i class="fa fa-angle-double-right"></i> ${typehead_text}
                &nbsp;&nbsp;
                <span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)">
                <i class="fa fa-times"></i>
                </span>
                &nbsp;
                <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Bookmark" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="${action_url}" data-id="${typehead_text}" data-name="${typehead_text}" data-type="${lookup_code}">
                <i class="fa fa-star"></i>
                </span>
            </li>`;

        $("#" + append_to).append(lookup_data);
        $("#" + typehead_id).typeahead("val", "");
        event.stopImmediatePropagation();
    },
    removeFromPresFavouritList: function (thisElement) {
        if (confirm("Are You Sure?")) {
            var favourit_id = $(thisElement).attr("data-favourit-id");
            var favourit_type = $(thisElement).attr("data-lookup-code");
            var action_url = $(thisElement).attr("data-action");

            $.ajax({
                async: true,
                data: {
                    favourit_id: favourit_id,
                    favourit_type: favourit_type,
                },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    $(".loading-img").html(
                        '<i class="spinner-border spinner-border-sm float-right"></i>'
                    );
                },
                success: function (data) {
                    // $(append_id).html(data);
                    $("#pres-favourit-list").html(data);
                },
                complete: function () {
                    $(".loading-img").html("");
                },
            });
        }
    },
    addSelectedTeeth: function (thisElement) {
        var selected_teeth_txt = $(thisElement).attr("id");
        var hidden_fields =
            "<input type='hidden' class='left-element' name='item_id[]' id='item_id' value='' readonly='readonly'><input type='hidden' name='lookup_id[]' id='lookup_id' value='' readonly='readonly'><input type='hidden' name='lookup_code[]' id='lookup_code' value='TEETHFIND' readonly='readonly'><input type='hidden' name='lookupdata_code[]' id='lookupdata_code' value='" +
            selected_teeth_txt +
            "' readonly='readonly'>";
        var ac_buttons =
            "<span class='text-danger cursor-pointer' title='Remove This Item' onclick='prescriptionFunc.removeSelectedTeeth(this)'><i class='fa fa-times'></i></span>";
        var selected_item =
            "<div class='selected-teeth-item' id='selected-teeth-item-" +
            selected_teeth_txt +
            "'><div class='form-group form-row mb-0'><label class='col-sm-4 col-form-label col-form-label-sm'>" +
            selected_teeth_txt +
            "</label><div class='col-sm-6'><input type='text' class='form-control mb-0 teeth_find' id='item_name' name='item_name[]' onclick='prescriptionFunc.loadToPresFavouritListTeeth(this)' data-lookup-code='TEETHFIND'>" +
            hidden_fields +
            "</div><div class='col-sm-2 ac_button_con'><span class='fav_btn'></span>" +
            ac_buttons +
            "</div></div><div class='form-group'></div></div>";

        if (selected_teeth_txt == "Teeth-All") {
            $("#selected-teeth").html("");
        }

        if ($(thisElement).hasClass("list-group-item-selected")) {
            $("#selected-teeth")
                .find("#selected-teeth-item-" + selected_teeth_txt)
                .remove();
            $(thisElement)
                .removeClass("list-group-item-selected")
                .addClass("list-group-item-navy");
        } else {
            $("#selected-teeth").append(selected_item);
            $(thisElement)
                .addClass("list-group-item-selected")
                .removeClass("list-group-item-navy");
        }
        teeth_autocomplete.destroy();
        teeth_autocomplete.init();
    },
    removeSelectedTeeth: function (thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents(".selected-teeth-item").remove();
        }
        return;
    },
    selectOccuExamElements: function (thisElement) {
        var thisValue = $(thisElement).val();
        if (thisValue == 0) {
            $("#new_dropdown_opt").on("keyup", function () {
                var newValue = $(this).val();
                $(thisElement)
                    .parent(".form-group")
                    .find("input[name='item_name[]']")
                    .val(newValue);
                $(thisElement)
                    .parent(".form-group")
                    .find("input[name='lookup_id[]']")
                    .val("");
                $(thisElement)
                    .parent(".form-group")
                    .find("input[name='lookupdata_code[]']")
                    .val(newValue);
                $(thisElement)
                    .parent(".form-group")
                    .find("input[name='item_id[]']")
                    .val("");
            });
        } else {
            var lkp_id = $(thisElement)
                .children("option")
                .filter(":selected")
                .attr("data-lkp-id");
            var lkpdatacode = $(thisElement)
                .children("option")
                .filter(":selected")
                .attr("data-lkpdatacode");
            var thisValueItem = $(thisElement)
                .children("option")
                .filter(":selected")
                .text();
            $(thisElement)
                .parent(".form-group")
                .find("input[name='item_id[]']")
                .val(thisValue);

            $(thisElement)
                .parent(".form-group")
                .find("input[name='item_name[]']")
                .val(thisValueItem);
            $(thisElement)
                .parent(".form-group")
                .find("input[name='lookup_id[]']")
                .val(lkp_id);
            $(thisElement)
                .parent(".form-group")
                .find("input[name='lookupdata_code[]']")
                .val(lkpdatacode);
        }
    },
    loadToPresFavouritListTeeth: function (
        thisElement,
        item_type,
        title,
        append_to,
        action_url
    ) {
        var item_type = "TEETHFIND";
        var title = "TEETH";
        var append_to = $(thisElement);
        var action_url = $("#hdn_favourite_route").val();
        $(thisElement)
            .parents("#cc-con")
            .find(".card-body")
            .removeClass("bg-light-blue");
        $(thisElement).parents("#cc-con .card-body").addClass("bg-light-blue");
        var hdn_su_no = $("#hdn_su_no").val();

        $.ajax({
            async: true,
            data: { item_type: item_type, hdn_su_no: hdn_su_no },
            url: action_url,
            type: "post",
            beforeSend: function () {
                $(".loading-img").html(
                    '<i class="spinner-border spinner-border-sm float-right"></i>'
                );
            },
            success: function (data) {
                $("#favourit_list_title").html(title + " Favourite List ");
                $("#favourit_list_title").attr("data-append-to", append_to);
                $("#pres-favourit-list").html(data);
            },
            complete: function () {
                $(".loading-img").html("");
            },
        });
    },
    addIPDMedRow: function (thisElement) {
        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = (item_name = "");
        if (lookup_code == "MED") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");
            thisElement = $("#med_td_action_0 span");
        }
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr("id", newId);
        row.find("#hdn_report_serial_med_" + oldId).attr(
            "id",
            "hdn_report_serial_med_" + newId
        );
        row.find("#hdn_medicine_item_id_" + oldId).attr(
            "id",
            "hdn_medicine_item_id_" + newId
        );
        row.find("#medicine_item_" + oldId)
            .attr("id", "medicine_item_" + newId)
            .css({ "background-color": "#ffffff", border: "0px" });
        row.find("#med_favourit_" + oldId).attr("id", "med_favourit_" + newId);
        row.find("#medicine_dose_" + oldId).attr(
            "id",
            "medicine_dose_" + newId
        );
        row.find("#medicine_duration_mu_" + oldId).attr(
            "id",
            "medicine_duration_mu_" + newId
        );
        row.find("#medicine_duration_type_" + oldId).attr(
            "id",
            "medicine_duration_type_" + newId
        );
        row.find("#medicine_quantity_" + oldId).attr(
            "id",
            "medicine_quantity_" + newId
        );
        row.find("#instruction_" + oldId).attr("id", "instruction_" + newId);
        row.find("#med_td_action_" + oldId).attr(
            "id",
            "med_td_action_" + newId
        );
        var hdn_patient_id = $("#hdn_patient_id").val();

        if (lookup_code == "MED") {
            row.find("#hdn_medicine_item_id_" + newId).val(item_id);
            row.find("#medicine_item_" + newId).val(item_name);
        }

        row.find("#hdn_report_serial_med_" + newId).val(
            $(thisElement)
                .parents("tbody")
                .find("#hdn_report_serial_med_" + oldId)
                .val()
        );
        row.find("#medicine_dose_" + newId).val(
            $(thisElement)
                .parents("tbody")
                .find("#medicine_dose_" + oldId)
                .val()
        );
        row.find("#instruction_" + newId).val(
            $(thisElement)
                .parents("tbody")
                .find("#instruction_" + oldId)
                .val()
        );
        row.find("#medicine_duration_mu_" + newId).val(
            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_mu_" + oldId)
                .val()
        );

        $(thisElement)
            .parents("tbody")
            .find("#hdn_report_serial_med_" + oldId)
            .val("");
        $(thisElement)
            .parents("tbody")
            .find("#hdn_medicine_item_id_" + oldId)
            .val("");
        $(thisElement)
            .parents("tbody")
            .find("#medicine_item_" + oldId)
            .val("");
        $(thisElement)
            .parents("tbody")
            .find("#medicine_dose_" + oldId)
            .val("0");
        $(thisElement)
            .parents("tbody")
            .find("#medicine_duration_mu_" + oldId)
            .val("DAY");
        $(thisElement)
            .parents("tbody")
            .find("#medicine_duration_type_" + oldId)
            .val("");
        $(thisElement)
            .parents("tbody")
            .find("#medicine_quantity_" + oldId)
            .val("");
        $(thisElement)
            .parents("tbody")
            .find("#instruction_" + oldId)
            .val("0");

        var add_fav_list_action = $(thisElement).attr("data-favourit-action");
        var med_item_id = row.find("#hdn_medicine_item_id_" + newId).val();
        var med_item_name = row.find("#medicine_item_" + newId).val();
        row.find("#med_favourit_" + newId).html(
            '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action +
                '" data-id="' +
                med_item_id +
                '" data-name="' +
                med_item_name +
                '" data-type="MED"><i class="fa fa-star text-primary"></i></span>'
        );

        var item_id = row.find("#hdn_medicine_item_id_" + newId).val();

        $(thisElement).parents("#data-append-to").append(row);
        $("#medicine_item_0").typeahead("destroy");
        openItemAutocomplete(
            $("#medicine_item_0"),
            "MED",
            "#hdn_medicine_item_id_0",
            "#medicine_item_0"
        );
        $("#medicine_item_0").focus();
        $("#med_td_action_" + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );
    },

    getPatientDetails: function (patient_id, patient_info_route, dtls_action) {
        $.ajax({
            url: patient_info_route,
            data: { patient_id: patient_id },
            type: "post",
            beforeSend: function () {},
            success: function (data) {
                $("#hdn_patient_id").val(data["patient_info"].patient_no_pk);
                // $("#hdn_service_id").val(data['patient_info'].service_number);
                $("#patient_name").html(
                    "Name : " + data["patient_info"].patient_name
                );
                $("#patient_age").html("Age : " + data["patient_info"].age);
                $("#patient_gender").html(
                    "Gender : " + data["patient_info"].gender_txt
                );

                if (data["patient_info"].patient_photo != null) {
                    var patient_img_path =
                        $("#patient_img").attr("data-path") +
                        "/" +
                        data["patient_info"].patient_photo;
                    $("#patient_img").html(
                        "<img width='30' src='" + patient_img_path + "'>"
                    );
                }

                // if(data['patient_info'].ref_patient_photo !=null)
                // {
                // 	var ref_patient_img_path = $("#patient_img").attr("data-path")+"/"+data['patient_info'].ref_patient_photo;
                // 	$("#ref_patient_img").html("<img width='30' src='"+ref_patient_img_path+"'>");
                // }
                $("#patient_mobile").html(
                    "Mobile No : " + data["patient_info"].mobile1
                );
                $("#blood_group").html(
                    data["patient_info"].blood_group_txt != null
                        ? "Blood Group : " +
                              data["patient_info"].blood_group_txt
                        : "Blood Group : "
                );

                // if(data['patient_info'].patient_type != "SRV")
                // {
                // 	$("#patient_name_other").html(data['patient_info'].ref_patient_name_rank);
                // 	var ref_service_number_relation = data['patient_info'].ref_service_number + ", " + data['patient_info'].pat_relation;
                // 	$("#patient_age_other").html(ref_service_number_relation);
                // }
            },
            complete: function (data) {
                $("#service_id").typeahead("val", "");
                var hdn_su_no = $("#hdn_su_no").val();
                prescriptionFunc.prescriptionDetails(hdn_su_no, dtls_action);
            },
        });
    },

    addDataFuncWithoutAutocomplete: function (
        thisElement,
        item_type,
        title,
        append_to,
        action_url
    ) {
        // var presDt = $(thisElement).parent('div').siblings('div').children('span').children('#cheif_complaint').val();
        // console.log(presDt)
        var typehead_id = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");

        var typehead_text = $("#" + typehead_id).typeahead("val");
        var typehead_text_format = typehead_text.replace("'", "’");
        // var typehead_text_format = typehead_text ? typehead_text.replace("'", "’") : '';

        var lookup_id = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-id");

        var lookup_code = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-code");
        // console.log(lookup_id, lookup_code)
        // var lookup_data =
        //     "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" +
        //     typehead_text_format +
        //     "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
        //     lookup_id +
        //     "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
        //     lookup_code +
        //     "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><i class='fa fa-angle-double-right'></i> " +
        //     typehead_text +
        //     "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        // new_option
        // lookup_id
        var lookup_data =
            "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' style='width:90%;' type='text' name='item_name[]' value='" +
            typehead_text_format +
            "'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        if (lookup_code == "CHIEFCOM") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#chfcom")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "ICD") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#icd_con")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "PASTHI") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#pasthi")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "TREATMENTHISTORY") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#treatmenthis")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "CLINICHIST") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#ho")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        }

        //Save part

        $.ajax({
            async: true,
            data: {
                element_id: lookup_code,
                new_option: typehead_text,
                lookup_id: lookup_id,
            },
            url: "../public/prescription-lookup/storeprescriptionlookupitem-doctor-chiefcomplain",
            type: "post",

            beforeSend: function () {
                blockUI();
            },
            success: function (item) {
                // $(element_id).typeahead('val', typehead_text);
                // console.log(item)
                $("#item_generic_id").val(item.insert_id);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
};

var billingEngine = {
    patientQuickReg: function (thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $("#hdn_patient_id").val(data.insert_id);
                    $("#patient_id").val(data.patient_name);
                    $("#prescription_id").focus();

                    $("#" + formID + " input[name=hdn_patient_id]").val(
                        data.insert_id
                    );
                    var p_code = data.patient_code
                        ? "<strong>Patient Code:  </strong>" +
                          data.patient_code +
                          ","
                        : "";
                    var p_name = data.patient_name
                        ? "Name: " + data.patient_name + ","
                        : "";
                    var p_gander = data.gender
                        ? "<strong>Gender : </strong>" + data.gender + ","
                        : "";
                    var p_age =
                        data.age != ""
                            ? "<strong>Age : </strong>" + data.age + ","
                            : "";
                    var p_phone = data.phone_mobile
                        ? " <strong>Phone : </strong>" + data.phone_mobile
                        : "";
                    var patient_info =
                        p_code + p_name + p_gander + p_age + p_phone;
                    $("#patient_info").html(patient_info);
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $(".common-modal-notify .modal-title").html(data.title);
                    $(".common-modal-notify .modal-body").html(data.msg);

                    // alert($("#prescription_id").attr('id'));
                    // $("#" + formID).find("#prescription_id").focus();
                    $("#" + formID)
                        .find("input, textarea")
                        .not(".keep_me")
                        .val("");
                    $("#" + formID)
                        .find("select")
                        .not(".keep_me")
                        .val("0");
                },
                complete: function () {
                    if (isAModalOpen) $(".modal").modal("hide");
                    $("#prescription_id").focus();

                    $.unblockUI();
                },
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }

                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );

                    $.unblockUI();
                },
            });
        }

        event.stopImmediatePropagation();
    },

    titleCase: function (str) {
        return str.replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    },

    doctorQuickReg: function (thisElement) {
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var doc_type = $(thisElement).parents("form").find("#doc_type").val();

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    var last_name =
                        data.last_name != null ? data.last_name : "";
                    if (doc_type == 1) {
                        $("#hdn_doctor_id").val(data.insert_id);
                        $("#doctor_code").val(data.last_name);
                        var name =
                            data.last_name != null
                                ? "<strong>Name: </strong>" + last_name + ","
                                : "";
                        var doc_phone =
                            data.doctor_mobile != ""
                                ? " ,<strong> Phone : </strong>" +
                                  data.doctor_mobile
                                : "";
                        var doctor_info =
                            "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong>" +
                            name +
                            doc_phone +
                            " " +
                            "(1st)</div>";
                        $("#doctor_info").html(doctor_info);
                    }
                    if (doc_type == 2) {
                        $("#hdn_first_refer").val(data.insert_id);
                        $("#first_refer").val(data.last_name);
                        var name =
                            data.last_name != null
                                ? "<strong>Name: </strong>" + last_name + ","
                                : "";
                        var doc_phone =
                            data.doctor_mobile != ""
                                ? " ,<strong> Phone : </strong>" +
                                  data.doctor_mobile
                                : "";
                        var doctor_info =
                            "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong>" +
                            name +
                            doc_phone +
                            " " +
                            "(2nd)</div>";
                        $("#doctor_ref1_info").html(doctor_info);
                    }
                    if (doc_type == 3) {
                        $("#hdn_second_refer").val(data.insert_id);
                        $("#second_refer").val(data.last_name);
                        var name =
                            data.last_name != null
                                ? "<strong>Name: </strong>" + last_name + ","
                                : "";
                        var doc_phone =
                            data.doctor_mobile != ""
                                ? " ,<strong> Phone : </strong>" +
                                  data.doctor_mobile
                                : "";
                        var doctor_info =
                            "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong>" +
                            name +
                            doc_phone +
                            " " +
                            "(3rd)</div>";
                        $("#doctor_ref2_info").html(doctor_info);
                    }
                    if (doc_type == "EMERG") {
                        $("#hdn_doctor_id").val(data.insert_id);
                        $("#doctor_name").val(data.last_name);
                    }
                },
                complete: function () {
                    if (isAModalOpen)
                        if (doc_type == 1) {
                            // $('.modal').modal('hide');

                            $("#first_refer").focus();
                        }
                    if (doc_type == 2) {
                        $("#second_refer").focus();
                    }
                    if (doc_type == 3) {
                        $("#item_code").focus();
                    }

                    $.unblockUI();
                    $(".exampleModal").modal("hide");
                    console.log("bellal doctor create");
                },
            });
        }
        event.stopImmediatePropagation();
    },

    deleteDoc: function (element) {
        var id = $(element).parent("div").attr("id");

        $("#doctorRef").remove();
        $("#hdn_doctor_id").val("");
    },

    deleteFirstRef: function (element) {
        var id = $(element).parent("div").attr("id");

        $("#firstRef").remove();
        $("#hdn_first_refer").val("");
    },

    deleteSecRef: function (element) {
        var id = $(element).parent("div").attr("id");
        $("#secondRef").remove();
        $("#hdn_second_refer").val("");
    },

    calculateTotal: function (thisElement) {
        var itemT_pay =
            parseFloat($("#item_total").html()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var h_amt =
            $("#discount_amount_hospital").val() != ""
                ? parseFloat($("#discount_amount_hospital").val())
                : 0;
        var d_amt =
            $("#discount_amount_doctor").val() != ""
                ? parseFloat($("#discount_amount_doctor").val())
                : 0;

        if (h_amt + d_amt > itemT_pay) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            alert("Invalid Discount");
            billingEngine.calculateTotal(thisElement);
        } else {
            var item_total = 0;
            var vat = 0;
            var default_dis = 0;
            var total_qty = 0;
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            // var urgent_fee = urgent_fee_total;

            let _summation_of_auto_discount = 0;

            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    if (
                        $(this).find(".item_total_amt").attr("data-dis-ind") ==
                        0
                    ) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;

                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    // console.log(item_total +"_"+"Bellal");
                    // var vat_item=$(this).find(".vat_pers").val() !=null ? $(this).find(".vat_pers").val() : 0;
                    // vat += vat_item * 1;
                    vat += parseFloat(
                        $(this).find(".vat_pers").val() * parseFloat(total_qty)
                    );
                    var auto_dis = parseFloat(
                        $(this).find(".auto_discount").val() != ""
                            ? $(this).find(".auto_discount").val()
                            : 0
                    );
                    default_dis += auto_dis * parseFloat(total_qty);
                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    if (delivery_status == 2) {
                        if (
                            $(this)
                                .children("td")
                                .find(".hdn_item_urgent_fee")
                                .val() != "null"
                        ) {
                            var urgent = parseFloat(
                                $(this)
                                    .children("td")
                                    .find(".hdn_item_urgent_fee")
                                    .val()
                            );
                            urgent_fee += urgent * parseFloat(total_qty);
                        }
                    }

                    _summation_of_auto_discount +=
                        $(this).find(".auto_discount").val() * 1;
                });

                console.log(
                    item_gross_amt,
                    item_total,
                    vat,
                    default_dis + "item",
                    total_qty + "qty"
                );
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                $("#item_vat").val(vat.toFixed(2));
                total_vat_amt =
                    $("#item_vat").val() != "" ? $("#item_vat").val() : 0;

                var discount_percent_hospital =
                    $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                }

                var discount_amt_hospital = (
                    ((item_total - vat) * discount_percent_hospital) /
                    100
                ).toFixed(2);

                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }

                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor =
                    $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val("");
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount =
                    discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    $("#discount_percent_doctor").val("");
                    $("#discount_amount_hospital").val("");
                    $("#discount_amount_doctor").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (
                    ((item_total - vat) * discount_percent_doctor) /
                    100
                ).toFixed(2);

                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {
                } else {
                    $("#discount_percent").val("");
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total =
                    ((item_total - vat) * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = "";
                } else {
                    discount_amt_total;
                }
                $("#total_discount_amount").val(
                    discount_amt_total + default_dis
                );
                if (
                    discount_percent_hospital != 0 ||
                    discount_percent_doctor != 0
                )
                    $("#discount_percent").val(
                        discount_percent_hospital + discount_percent_doctor
                    );
                else $("#discount_percent").val("");

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount =
                        discount_amt_doctor + discount_amt_hospital;
                    if (total_discount_amount == 0) {
                        total_discount_amount = "";
                    }

                    if (
                        discount_percent_hospital + discount_percent_doctor ==
                        0
                    ) {
                        $("#discount_percent").val("");
                    } else {
                        $("#discount_percent").val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    }

                    // $("#total_discount_amount").val(
                    //     total_discount_amount + default_dis
                    // );
                    $("#total_discount_amount").val(
                        _summation_of_auto_discount.toFixed(2)
                    );

                    // after_disc_amt =
                    //     item_gross_amt -
                    //     vat -
                    //     (total_discount_amount + default_dis);
                    after_disc_amt =
                        item_gross_amt - vat - _summation_of_auto_discount;
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total =
                        ((item_total - vat) * discount_percent) / 100;
                    // $("#total_discount_amount").val(
                    //     discount_amt_total + default_dis
                    // );
                    $("#total_discount_amount").val(
                        _summation_of_auto_discount.toFixed(2)
                    );

                    total_discount_amount = discount_amt_total;
                    // after_disc_amt =
                    //     item_gross_amt -
                    //     vat -
                    //     (discount_amt_total + default_dis);
                    after_disc_amt =
                        item_gross_amt - vat - _summation_of_auto_discount;
                }

                var item_vat =
                    $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0; //$("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;

                var total_payable = after_disc_amt + item_vat + s_charge;
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));

                var pay_amount = $("#pay_amount").val() * 1;
                $("#total_due_data").html(
                    (total_payable - pay_amount).toFixed(2)
                );

                billingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
                return;
            }
            // e.stopImmediatePropagation();
            billingEngine.billSubTotal(this);
        }
    },
    calculateTotalV1: function (thisElement) {
        var itemT_pay =
            parseFloat($("#item_total").html()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var h_amt =
            $("#discount_amount_hospital").val() != ""
                ? parseFloat($("#discount_amount_hospital").val())
                : 0;
        var d_amt =
            $("#discount_amount_doctor").val() != ""
                ? parseFloat($("#discount_amount_doctor").val())
                : 0;
        // auto_discount_perc_
        if (h_amt + d_amt > itemT_pay) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            alert("Invalid Discount");
            billingEngine.calculateTotal(thisElement);
        } else {
            var item_total = 0;
            var item_rate_total = 0;
            var vat = 0;
            var default_dis = 0;
            var service_charge = 0;
            var total_qty = 0;
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            // var urgent_fee = urgent_fee_total;

            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    service_charge +=
                        $(this).find(".service_charge").val() != ""
                            ? parseFloat(
                                  $(this).find(".service_charge").val()
                              ) * 1
                            : 0;
                    item_id = $(this).find(".item_id").val();
                    item_qty =
                        $(this)
                            .find("#hdn_item_qnty_" + item_id)
                            .val() * 1;
                    item_rate_total +=
                        $(this)
                            .find("#item_rate_" + item_id)
                            .val() * item_qty;
                    console.log(item_id + "_item_rate_amt");
                    if (
                        $(this).find(".item_total_amt").attr("data-dis-ind") ==
                        0
                    ) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                        // $(this).find(".item_total_amt").val(parseFloat($(this).find(".service_charge").val() *1) + ( $(this).find(".item_total_amt").val() * 1));
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;

                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    // console.log(item_total +"_"+"Bellal");
                    // var vat_item=$(this).find(".vat_pers").val() !=null ? $(this).find(".vat_pers").val() : 0;
                    // vat += vat_item * 1;

                    vat +=
                        $(this).find(".vat_pers").val() != ""
                            ? parseFloat($(this).find(".vat_pers").val())
                            : 0; //* parseFloat(total_qty);
                    var auto_dis = parseFloat(
                        $(this).find(".auto_discount").val() != ""
                            ? $(this).find(".auto_discount").val()
                            : 0
                    );
                    var auto_doc_dis = parseFloat(
                        $(this).find(".auto_discount_doc").val() != ""
                            ? parseFloat(
                                  $(this).find(".auto_discount_doc").val()
                              )
                            : 0
                    );
                    default_dis += auto_dis + auto_doc_dis; // * parseFloat(total_qty);

                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    if (delivery_status == 2) {
                        if (
                            $(this)
                                .children("td")
                                .find(".hdn_item_urgent_fee")
                                .val() != "null"
                        ) {
                            var urgent =
                                parseFloat(
                                    $(this)
                                        .children("td")
                                        .find(".hdn_item_urgent_fee")
                                        .val()
                                ) * total_qty;
                            urgent_fee += urgent;
                        }
                    }
                });

                console.log(
                    item_gross_amt,
                    item_total,
                    vat,
                    default_dis + "item",
                    total_qty + "_qty_" + item_rate_total
                );
                $("#item_rate_total").html(item_rate_total.toFixed(2));
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                $("#item_vat").val(vat.toFixed(2));
                total_vat_amt =
                    $("#item_vat").val() != "" ? $("#item_vat").val() : 0;

                var discount_percent_hospital =
                    $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                }

                var discount_amt_hospital = (
                    ((item_total - vat) * discount_percent_hospital) /
                    100
                ).toFixed(2);

                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }

                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor =
                    $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val("");
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount =
                    discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    $("#discount_percent_doctor").val("");
                    $("#discount_amount_hospital").val("");
                    $("#discount_amount_doctor").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (
                    ((item_total - vat) * discount_percent_doctor) /
                    100
                ).toFixed(2);

                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {
                } else {
                    $("#discount_percent").val("");
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total =
                    ((item_total - vat) * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = "";
                } else {
                    discount_amt_total;
                }
                $("#total_discount_amount").val(
                    discount_amt_total + default_dis
                );
                if (
                    discount_percent_hospital != 0 ||
                    discount_percent_doctor != 0
                )
                    $("#discount_percent").val(
                        discount_percent_hospital + discount_percent_doctor
                    );
                else $("#discount_percent").val("");

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount =
                        discount_amt_doctor + discount_amt_hospital;
                    if (total_discount_amount == 0) {
                        total_discount_amount = "";
                    }

                    if (
                        discount_percent_hospital + discount_percent_doctor ==
                        0
                    ) {
                        $("#discount_percent").val("");
                    } else {
                        $("#discount_percent").val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    }

                    $("#total_discount_amount").val(
                        total_discount_amount + default_dis
                    );

                    after_disc_amt =
                        item_gross_amt -
                        vat -
                        (total_discount_amount + default_dis);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total =
                        ((item_total - vat) * discount_percent) / 100;
                    $("#total_discount_amount").val(
                        discount_amt_total + default_dis
                    );
                    total_discount_amount = discount_amt_total;
                    after_disc_amt =
                        item_gross_amt -
                        vat -
                        (discount_amt_total + default_dis);
                }

                var item_vat =
                    $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0; //$("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = service_charge; // $("#s_charge").val() * 1;
                $("#s_charge").val(s_charge);

                if (default_dis > 0) {
                    var total_payable = after_disc_amt + default_dis + item_vat;
                } else {
                    var total_payable = after_disc_amt + item_vat;
                }

                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));

                var pay_amount = $("#pay_amount").val() * 1;
                $("#total_due_data").html(
                    (total_payable - pay_amount).toFixed(2)
                );

                billingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
                return;
            }
            // e.stopImmediatePropagation();
            billingEngine.billSubTotal(this);
        }
    },

    billSubTotal: function (element) {
        var item_id = "";
        var qty = 0;
        var rate = 0;
        var dis = 0;
        var service_charge = 0;
        var urgent_fee = 0;
        var auto_discount_perc = 0;
        var auto_discount_doc_perc = 0;
        var auto_discount_doc = 0;
        var total_amt = 0;
        jQuery(".item_list").each(function () {
            item_id = $(this).children("td").find(".item_id").val();
            qty += parseFloat(
                $(this)
                    .children("td")
                    .find("#hdn_item_qnty_" + item_id)
                    .val()
            );
            rate += parseFloat(
                $(this)
                    .children("td")
                    .find("#item_rate_" + item_id)
                    .val()
            );

            service_charge +=
                $(this)
                    .children("td")
                    .find("#service_charge_" + item_id)
                    .val() != ""
                    ? parseFloat(
                          $(this)
                              .children("td")
                              .find("#service_charge_" + item_id)
                              .val() * 1
                      )
                    : 0;
            urgent_fee += parseFloat(
                $(this)
                    .children("td")
                    .find("#urgent_fee_amt_" + item_id)
                    .val() * 1
            );
            dis +=
                $(this)
                    .children("td")
                    .find("#auto_discount_" + item_id)
                    .val() != ""
                    ? parseFloat(
                          $(this)
                              .children("td")
                              .find("#auto_discount_" + item_id)
                              .val()
                      )
                    : 0;
            auto_discount_perc +=
                $(this)
                    .children("td")
                    .find("#auto_discount_perc_" + item_id)
                    .val() != ""
                    ? parseFloat(
                          $(this)
                              .children("td")
                              .find("#auto_discount_perc_" + item_id)
                              .val()
                      )
                    : 0;
            auto_discount_doc_perc +=
                $(this)
                    .children("td")
                    .find("#auto_discount_doc_perc_" + item_id)
                    .val() != ""
                    ? parseFloat(
                          $(this)
                              .children("td")
                              .find("#auto_discount_doc_perc_" + item_id)
                              .val()
                      )
                    : 0;
            auto_discount_doc += parseFloat(
                $(this)
                    .children("td")
                    .find("#auto_discount_doc_" + item_id)
                    .val()
            );
            total_amt += parseFloat(
                $(this)
                    .children("td")
                    .find("#hdn_item_total_qnty_" + item_id)
                    .val()
            );
            console.log(
                $(this)
                    .children("td")
                    .find("#urgent_fee_amt_" + item_id)
                    .attr("id") + "_urgent_fee_total"
            );
        });

        $("#total_sub_qty").val(qty);
        $("#total_sub_rate").val(rate);
        $("#total_sub_dis").val(dis);
        $("#total_service_charge").val(service_charge);
        $("#total_urgent_fee").val(urgent_fee);
        $("#total_sub_dis_perc").val(auto_discount_perc);
        $("#total_sub_doc_dis_perc").val(auto_discount_doc_perc);
        $("#total_sub_doc_dis").val(auto_discount_doc);

        $("#total_sub_amt").val(total_amt);

        console.log(qty + "_subQty_" + dis);
    },
    posCalculateTotal: function (thisElement) {
        var itemT_pay =
            parseFloat($("#item_total").html()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var h_amt =
            $("#discount_amount_hospital").val() != ""
                ? parseFloat($("#discount_amount_hospital").val())
                : 0;
        var d_amt =
            $("#discount_amount_doctor").val() != ""
                ? parseFloat($("#discount_amount_doctor").val())
                : 0;

        if (h_amt + d_amt > itemT_pay) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            alert("Invalid Discount");
            billingEngine.calculateTotal(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            // var urgent_fee = urgent_fee_total;

            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    console.log(
                        $(this).children("td").find(".urgent_fee").val() +
                            "bbbb"
                    );
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    // if (delivery_status == 2) {
                    if (
                        $(this).children("td").find(".urgent_fee").val() != ""
                    ) {
                        var urgent = parseFloat(
                            $(this).children("td").find(".urgent_fee").val()
                        );
                        urgent_fee += urgent;
                    }
                    // }
                });

                item_total = Math.round(item_total);
                console.log("ITEM total" + item_total);
                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val((item_total + urgent_fee).toFixed(2));

                var discount_percent_hospital =
                    $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                }

                var discount_amt_hospital = (
                    (item_total * discount_percent_hospital) /
                    100
                ).toFixed(2);

                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }

                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor =
                    $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val("");
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount =
                    discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    $("#discount_percent_doctor").val("");
                    $("#discount_amount_hospital").val("");
                    $("#discount_amount_doctor").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (
                    (item_total * discount_percent_doctor) /
                    100
                ).toFixed(2);

                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {
                } else {
                    $("#discount_percent").val("");
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total = (item_total * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = "";
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total);
                if (
                    discount_percent_hospital != 0 ||
                    discount_percent_doctor != 0
                )
                    $("#discount_percent").val(
                        discount_percent_hospital + discount_percent_doctor
                    );
                else $("#discount_percent").val("");

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount =
                        discount_amt_doctor + discount_amt_hospital;
                    if (total_discount_amount == 0) {
                        total_discount_amount = "";
                    }

                    if (
                        discount_percent_hospital + discount_percent_doctor ==
                        0
                    ) {
                        $("#discount_percent").val("");
                    } else {
                        $("#discount_percent").val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    }

                    $("#total_discount_amount").val(total_discount_amount);

                    after_disc_amt = item_total - total_discount_amount;
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = (item_total * discount_percent) / 100;
                    $("#total_discount_amount").val(
                        discount_amt_total.toFixed(2)
                    );
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

                var item_vat = $("#item_vat").val() * 1;
                var sd = $("#sd").val() !=null ? $("#sd").val()* 1 :0;
                console.log(sd+'____sd amount___'+ item_vat)
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;

                var total_payable =
                    after_disc_amt + urgent_fee + item_vat + sd + s_charge;
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));

                var pay_amount = $("#pay_amount").val() * 1;
                var adj_amt = total_payable - Math.floor(total_payable);
                // $('#dis_adj_amt').val(adj_amt.toFixed(2));
                if ($("#hospital_code").val() == "JKMH") {
                    if (adj_amt > 0.5) {
                        var pay_amount = $("#pay_amount").val() * 1;
                        var minus_adj_discount =
                            total_payable - Math.round(total_payable);
                        $("#dis_adj_amt").val(minus_adj_discount.toFixed(2));
                        $("#total_due_data").html(
                            (
                                Math.round(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (
                                Math.floor(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                    } else {
                        $("#dis_adj_amt").val(adj_amt.toFixed(2));
                        var pay_amount = $("#pay_amount").val() * 1;

                        $("#total_due_data").html(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                    }
                } else {
                    var adj_dis_amt =
                        $("#dis_adj_amt").val() != ""
                            ? parseFloat($("#dis_adj_amt").val())
                            : 0;

                    $("#total_due_data").html(
                        (
                            Math.floor(total_payable.toFixed(2)) - pay_amount
                        ).toFixed(2)
                    );
                    $("#cash_amount").val(
                        (
                            Math.floor(total_payable.toFixed(2)) - pay_amount
                        ).toFixed(2)
                    );
                }

                billingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    },
    posCalculateTotalV2: function (thisElement) {
        console.log("posCalculateTotalV2");
        var itemT_pay =
            parseFloat($("#item_total").html()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var h_amt =
            $("#discount_amount_hospital").val() != ""
                ? parseFloat($("#discount_amount_hospital").val())
                : 0;
        var d_amt =
            $("#discount_amount_doctor").val() != ""
                ? parseFloat($("#discount_amount_doctor").val())
                : 0;

        if (h_amt + d_amt > itemT_pay) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            alert("Invalid Discount");
            billingEngine.calculateTotal(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            // var urgent_fee = urgent_fee_total;

            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    console.log(
                        $(this).children("td").find(".urgent_fee").val() +
                            "bbbb"
                    );
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    // if (delivery_status == 2) {
                    if (
                        $(this).children("td").find(".urgent_fee").val() != ""
                    ) {
                        var urgent = parseFloat(
                            $(this).children("td").find(".urgent_fee").val()
                        );
                        urgent_fee += urgent;
                    }
                    // }
                });

                item_total = Math.round(item_total);
                console.log("ITEM total" + item_total);
                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val((item_total + urgent_fee).toFixed(2));

                var discount_percent_hospital =
                    $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                }

                var discount_amt_hospital = (
                    (item_total * discount_percent_hospital) /
                    100
                ).toFixed(2);

                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }

                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor =
                    $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val("");
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount =
                    discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    $("#discount_percent_doctor").val("");
                    $("#discount_amount_hospital").val("");
                    $("#discount_amount_doctor").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = (
                    (item_total * discount_percent_doctor) /
                    100
                ).toFixed(2);

                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {
                } else {
                    $("#discount_percent").val("");
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total = (item_total * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = "";
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total);
                if (
                    discount_percent_hospital != 0 ||
                    discount_percent_doctor != 0
                )
                    $("#discount_percent").val(
                        discount_percent_hospital + discount_percent_doctor
                    );
                else $("#discount_percent").val("");

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount =
                        discount_amt_doctor + discount_amt_hospital;
                    if (total_discount_amount == 0) {
                        total_discount_amount = "";
                    }

                    if (
                        discount_percent_hospital + discount_percent_doctor ==
                        0
                    ) {
                        $("#discount_percent").val("");
                    } else {
                        $("#discount_percent").val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    }

                    $("#total_discount_amount").val(total_discount_amount);

                    after_disc_amt = item_total - total_discount_amount;
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = (item_total * discount_percent) / 100;
                    $("#total_discount_amount").val(
                        discount_amt_total.toFixed(2)
                    );
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

                $("#billing_table-body tr").each(function () {
                    var itemId = $(this).find(".item_id").val();
                    var item_amt = parseFloat(
                        $(this).find(".item_total_amt").val()
                    );
                    var discount_amt_ratio =
                        (item_amt / item_total) * discount_amt_total;
                    $(this)
                        .find(".item_dis_amt")
                        .val(discount_amt_ratio.toFixed(2));
                    $(this)
                        .find(".item_dis")
                        .val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    $(this)
                        .find("#exp_item_total" + itemId)
                        .html(item_amt - discount_amt_ratio);
                    console.log(
                        itemId,
                        item_amt,
                        discount_amt_ratio + "_______dis percent all"
                    );
                });

                var item_vat = $("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;

                var total_payable =
                    after_disc_amt + urgent_fee + item_vat + s_charge;
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));

                var pay_amount = $("#pay_amount").val() * 1;
                var adj_amt = total_payable - Math.floor(total_payable);
                $('#dis_adj_amt').val(adj_amt.toFixed(2));
                if ($("#hospital_code").val() == "JKMH") {
                    if (adj_amt > 0.5) {
                        var pay_amount = $("#pay_amount").val() * 1;
                        var minus_adj_discount =
                            total_payable - Math.round(total_payable);
                        $("#dis_adj_amt").val(minus_adj_discount.toFixed(2));
                        $("#total_due_data").html(
                            (
                                Math.round(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (
                                Math.floor(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                    } else {
                        $("#dis_adj_amt").val(adj_amt.toFixed(2));
                        var pay_amount = $("#pay_amount").val() * 1;

                        $("#total_due_data").html(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                    }
                } else {
                    var adj_dis_amt =
                        $("#dis_adj_amt").val() != ""
                            ? parseFloat($("#dis_adj_amt").val())
                            : 0;

                    $("#total_due_data").html(
                        (
                            Math.floor(total_payable.toFixed(2)) - pay_amount
                        ).toFixed(2)
                    );
                    $("#cash_amount").val(
                        (
                            Math.floor(total_payable.toFixed(2)) - pay_amount
                        ).toFixed(2)
                    );
                }

                billingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    },

    posCalculateTotalItemWise: function (thisElement) {
        var item_total_amt =
            $("#item_total").html() != ""
                ? parseFloat($("#item_total").html())
                : 0;
        var pay_total_amount =
            $("#pay_amount").html() != ""
                ? parseFloat($("#pay_amount").html())
                : 0;
        var itemT_pay = item_total_amt - pay_total_amount;
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var total_item_dis =
            $("#total_discount_amount").val() != ""
                ? parseFloat($("#total_discount_amount").val())
                : 0;

        if (total_item_dis > itemT_pay) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            $("#item_dis").val("");
            $("#discount_percent").val("");
            alert("Invalid Discount");
            billingEngine.posCalculateTotalItemWise(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    if (
                        $(this).children("td").find(".urgent_fee").val() != ""
                    ) {
                        var urgent = parseFloat(
                            $(this).children("td").find(".urgent_fee").val()
                        );
                        urgent_fee += urgent;
                    }
                });
                item_total = Math.round(item_total);
                $("#item_total").html(item_total.toFixed(2));

                $("#total_payable").val((item_total + urgent_fee).toFixed(2));

                if (discount_percent == 0) {
                    after_disc_amt = item_total - total_item_dis;
                } else {
                    after_disc_amt = item_total - total_item_dis;
                }

                var item_vat = $("#item_vat").val() * 1;
                var sd = $("#sd").val() !=null ? $("#sd").val() * 1 :0;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable =
                    after_disc_amt + urgent_fee + item_vat + sd+ s_charge;
                $("#total_payable").val(total_payable.toFixed(2));
                var adj_amt = total_payable - Math.floor(total_payable);

                if ($("#hospital_code").val() == "JKMH") {
                    if (adj_amt > 0.5) {
                        var pay_amount = $("#pay_amount").val() * 1;
                        var minus_adj_discount =
                            total_payable - Math.round(total_payable);
                        $("#dis_adj_amt").val(minus_adj_discount.toFixed(2));
                        $("#total_due_data").html(
                            (
                                Math.floor(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (
                                Math.floor(total_payable) +
                                1 -
                                pay_amount
                            ).toFixed(2)
                        );
                    } else {
                        $("#dis_adj_amt").val(adj_amt.toFixed(2));
                        var pay_amount = $("#pay_amount").val() * 1;

                        $("#total_due_data").html(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                        $("#cash_amount").val(
                            (Math.floor(total_payable) - pay_amount).toFixed(2)
                        );
                    }
                } else {
                    $("#dis_adj_amt").val(adj_amt.toFixed(2));
                    var pay_amount = $("#pay_amount").val() * 1;

                    $("#total_due_data").html(
                        (Math.floor(total_payable) - pay_amount).toFixed(2)
                    );
                    $("#cash_amount").val(
                        (Math.floor(total_payable) - pay_amount).toFixed(2)
                    );
                }
                billingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    },
    calculatePosTotal: function (thisElement) {
        var item_total = 0;
        if ($("#billing_table-body tr").length > 0) {
            $("#billing_table-body tr").each(function () {
                item_total += $(this).find(".item_total_amt").val() * 1;
            });
            $("#item_total").html(item_total.toFixed(2));
            $("#total_payable").val(item_total.toFixed(2));

            var vat_perc = $("#vat_perc").val() * 1;
            var vat_amt = (item_total * vat_perc) / 100;
            $("#vat_amt").val(vat_amt.toFixed(2)).attr("readonly", "readonly");

            var discount_percent = $("#discount_percent").val() * 1;
            var discount_amt = (item_total * discount_percent) / 100;
            $("#discount_amt")
                .val(discount_amt.toFixed(2))
                .attr("readonly", "readonly");

            var other_discount = $("#other_discount").val() * 1;
            var vat_amt = $("#vat_amt").val() * 1;
            var discount_amt = $("#discount_amt").val() * 1;

            $("#sub_total").html(item_total.toFixed(2));
            var sub_total = $("#sub_total").val() * 1;
            var net_payable = (item_total - discount_amt) * 1;
            $("#net_payable").html(net_payable.toFixed(2));
            // $("#pay_amount").val(net_payable.toFixed(2));

            var item_vat = $("#item_vat").val() * 1;
            var urgent_fee = $("#urgent_fee").val() * 1;
            var s_charge = $("#s_charge").val() * 1;
        } else {
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();
    },
    calculateItemTotal: function (thisElement) {
        var item_id = $(thisElement).parents("tr").find(".item_id").val();

        var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
        var item_rate = $("#hdn_item_rate_" + item_id).val() * 1;
        $("#hdn_item_total_qnty_" + item_id).val(item_qnty * item_rate);
        $("#exp_item_total" + item_id).html("");
        $("#exp_item_total" + item_id).html(item_qnty * item_rate);
    },
    calculatePayment: function (thisElement) {
        var pay_amount = $("#cash_bd_amount").val() * 1; // Given Amount
        var total_amount = $("#cash_amount").val() * 1; // Paid Amount

        if (total_amount >= pay_amount) {
            $("#change_amount").val("");
        } else {
            if (total_amount > 0) {
                $("#change_amount").val(pay_amount - total_amount);
            } else {
                $("#change_amount").val("");
            }
        }
    },
    calculatePosPayment: function (thisElement) {
        var net_payable = $("#net_payable").html().trim() * 1;
        var pay_amount = $("#pay_amount").val() * 1;
        if (net_payable > 0) {
            if (pay_amount > net_payable) {
                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    "Payment Amount can not be greater than Net Payable Amount"
                );
                $("#total_due, #total_due_con, #pay_amount").val("");
                return;
            }

            var given_amount = $("#given_amount").val() * 1;

            if (pay_amount > 0) {
                if (given_amount > 0)
                    $("#change_amount").val(given_amount - pay_amount);
                else $("#change_amount").val("");
            } else {
                $("#change_amount").val("");
            }
            $("#total_due").val((net_payable - pay_amount).toFixed(2));
            $("#total_due_con").html((net_payable - pay_amount).toFixed(2));
        } else {
            $("#pay_amount, #given_amount").val("");
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not selected any Item."
            );
            return;
        }
    },
    createBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var formID = $(thisElement).parents("form").attr("id");
        var url = $(thisElement).attr("data-response-url");
        console.log(action, url);

        // var url = '{{ route("billing.service-billing") }}';
        // formValidation("frmBilling");
        if (formValidation(formID) == false) {
            return;
        }
        console.log("user", $("#hdn_ipd_doctor_id").val());
        if (
            $("#hdn_doctor_id").val() != "" ||
            $("#hdn_ipd_doctor_id").val() != ""
        ) {
            if ($("#billing_table-body tr").length == 0) {
                alert("You did not select any Service Item");
                event.preventDefault();
                return;
            }
            var payable =
                $("#total_payable").val() != null
                    ? parseFloat($("#total_payable").val())
                    : 0;
            var paid =
                $("#pay_amount").val() != null
                    ? parseFloat($("#pay_amount").val())
                    : 0;
            var paid_limit_amt = (payable * 60) / 100;
            if (paid < paid_limit_amt) {
                alert("Needed paid minimum 60% amount of bill amount");
            }
            btnSaveUpdate(
                $(thisElement),
                "afterSaveModal",
                action,
                "common-modal-md",
                "Bill Invoice",
                dynamicFunc.afterSaveLoadPage,
                url
            );

            $(".button5").html(0);
            $(".buttonAdmission").html(0);
        } else {
            alert("Please Select a Referral Doctor");
            $("#doctor_code").focus();
            return false;
        }
        // billingEngine.resetBillForm();
    },
    createBillV2: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var formID = $(thisElement).parents("form").attr("id");
        var url = $(thisElement).attr("data-response-url");

        if ($("#bill_type").val() != "PKG" && $("#bill_type").val() != "app") {
            if ($("#billing_table-body tr").length > 0) {
                var reter = 0;
                $(".item_rate").each(function () {
                    if ($(this).val() == "" || $(this).val() <= 0) {
                        let item_name = $(this)
                            .parents("tr")
                            .find(".hdn_item_name")
                            .val();
                        alert("Set Price of " + item_name);
                        $(this).focus();
                        event.preventDefault();
                        reter = 1;
                    }
                });
                if (reter == 1) {
                    event.preventDefault();
                    return false;
                }
            }
        }
        console.log(action, url);

        // var url = '{{ route("billing.service-billing") }}';
        // formValidation("frmBilling");
        if (formValidation(formID) == false) {
            return;
        }
        console.log("user", $("#hdn_ipd_doctor_id").val());
        if (
            $("#hdn_doctor_id").val() != "" ||
            $("#hdn_ipd_doctor_id").val() != ""
        ) {
            if ($("#billing_table-body tr").length == 0) {
                alert("You did not select any Service Item");
                event.preventDefault();
                return;
            }
            var payable =
                $("#total_payable").val() != null
                    ? parseFloat($("#total_payable").val())
                    : 0;
            var paid =
                $("#pay_amount").val() != null
                    ? parseFloat($("#pay_amount").val())
                    : 0;
            var paid_limit_amt = (payable * 60) / 100;
            if (paid < paid_limit_amt) {
                alert("Needed paid minimum 60% amount of bill amount");
            }
            // btnSaveUpdate(
            //     $(thisElement),
            //     "afterSaveModal",
            //     action,
            //     "common-modal-md",
            //     "Bill Invoice",
            //     dynamicFunc.afterSaveLoadPage,
            //     url
            // );
            billingEngine.btnSaveUpdateServiceBill(
                $(thisElement),
                "",
                action,
                "",
                "",
                dynamicFunc.afterSaveLoadPage,
                url
            );

            $(".button5").html(0);
            $(".buttonAdmission").html(0);
        } else {
            alert("Please Select a Referral Doctor");
            $("#doctor_code").focus();
            return false;
        }
        // billingEngine.resetBillForm();
    },
    btnSaveUpdateServiceBill: function (
        thisElement,
        customFunc = "",
        responesUrl = "",
        modalClass = "",
        modalTitle = "",
        callback = "",
        callbackparam = ""
    ) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");

        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        console.log($(thisElement), formAction, formMethod);
        if (formValidation(formID) == false) {
            return false;
        }
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    var response_url =
                        responesUrl +
                        "/" +
                        data.insert_id +
                        "/" +
                        data.bill_ind +
                        "/" +
                        data.trx_id;
                    window.open(response_url, "_blank");
                    // window.location.href = routeUrl;
                },
                complete: function () {},
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText);
                    error_messages = "";
                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        error_messages
                    );

                    $.unblockUI();
                },
            }).done(function () {
                $.unblockUI();

                if (callback != "") callback(callbackparam);
            });
        }

        event.stopImmediatePropagation();
    },
    backHistory: function () {
        // billingEngine

        window.history.back();
    },

    createIPDServiceBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var redirect_action = $(thisElement).attr("data-redirect-action");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "IPD Invoice",
            dynamicFunc.afterSaveLoadPage,
            redirect_action
        );
        // billingEngine.resetBillForm();
    },
    createIpdPayment: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var redirect_action = $(thisElement).attr("data-redirect-action");
        var payment = $("#total_payment_amt").val();
        var total_payment_amt = payment ? payment : "";

        // if ($("#billing_table-body tr").length == 0) {
        //     alert("You did not select any Service Item");
        //     event.preventDefault();
        //     return;
        // }

        formValidation("ipdpaymentform");
        // console.log(action);

        if (total_payment_amt != "") {
            btnSaveUpdate(
                $(thisElement),
                "afterSaveModal",
                action,
                "common-modal-md",
                "IPD Invoice",
                dynamicFunc.afterSaveLoadPage,
                redirect_action
            );
        } else {
            btnSaveUpdate(
                $(thisElement),
                "",
                "",
                "",
                "",
                dynamicFunc.afterSaveLoadPage,
                redirect_action
            );
        }

        // billingEngine.resetBillForm();
    },

    createPosBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var url = $(thisElement).attr("data-url");
        if ($("#billing_table-body tr").length == 0) {
            alert("You did not select any Service Item");
            event.preventDefault();
            return;
        }
        if ($("#billing_table-body tr").length > 0) {
            var reter = 0;
            $(".hdn_item_qnty").each(function () {
                if ($(this).val() == "" || $(this).val() <= 0) {
                    alert("Enter Qty");
                    $(this).focus();
                    event.preventDefault();
                    reter = 1;
                }
            });
            if (reter == 1) {
                return false;
            }
        }
         var internalBatch = false;
       
        $(".internal_batch").each(function () {
            if ($(this).val() == "" ) {
                alert("Empty  Batch");               
                internalBatch = true;               
                 console.log($(this).val());
                event.preventDefault();
                // return false;
            }
        });
      
       
        if (internalBatch == true) {
                    return false;        
        }

        formValidation("posBilling");
        $(".button5").html(0);
        $(".admissionButton").html(0);
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "POS Bill Invoice",
            "",
            url
        );
        // billingEngine.btnSaveUpdatePosBill(
        //     $(thisElement),
        //     '',
        //     action,
        //    "",
        //    "",
        //    dynamicFunc.afterSaveLoadPage,
        //    url,

        // );

        // billingEngine.resetBillForm();
    },
    createPosBillV2: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var url = $(thisElement).attr("data-url");
        if ($("#billing_table-body tr").length == 0) {
            alert("You did not select any Service Item");
            event.preventDefault();
            return;
        }
        if ($("#billing_table-body tr").length > 0) {
            var reter = 0;
            $(".hdn_item_qnty").each(function () {
                if ($(this).val() == "" || $(this).val() <= 0) {
                    alert("Enter Qty");
                    $(this).focus();
                    event.preventDefault();
                    reter = 1;
                }
            });
            if (reter == 1) {
                return false;
            }
        }
         var internalBatch = false;
       
        $(".internal_batch").each(function () {
            if ($(this).val() == "" ) {
                alert("Empty  Batch");               
                internalBatch = true;               
                 console.log($(this).val());
                event.preventDefault();
                // return false;
            }
        });
      
       
        if (internalBatch == true) {
                    return false;        
        }

        formValidation("posBilling");
        $(".button5").html(0);
        $(".admissionButton").html(0);
        // btnSaveUpdate(
        //     $(thisElement),
        //     "afterSaveModal",
        //     action,
        //     "common-modal-md",
        //     "POS Bill Invoice",
        //     "",
        //     url
        // );
        billingEngine.btnSaveUpdatePosBill(
            $(thisElement),
            "",
            action,
            "",
            "",
            dynamicFunc.afterSaveLoadPage,
            url
        );

        // billingEngine.resetBillForm();
    },
    createPosBillV3: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var url = $(thisElement).attr("data-redirect_action_bill_generate");
        var admission_id = $("#admission_id").val();

        if ($("#billing_table-body tr").length == 0) {
            alert("You did not select any Service Item");
            event.preventDefault();
            return;
        }
        if ($("#billing_table-body tr").length > 0) {
            var reter = 0;
            $(".hdn_item_qnty").each(function () {
                if ($(this).val() == "" || $(this).val() <= 0) {
                    alert("Enter Qty");
                    $(this).focus();
                    event.preventDefault();
                    reter = 1;
                }
            });
            if (reter == 1) {
                return false;
            }
        }
         var internalBatch = false;
       
        $(".internal_batch").each(function () {
            if ($(this).val() == "" ) {
                alert("Empty  Batch");               
                internalBatch = true;               
                 console.log($(this).val());
                event.preventDefault();
                // return false;
            }
        });
      
       
        if (internalBatch == true) {
                    return false;        
        }

        formValidation("posBilling");
        $(".button5").html(0);
        $(".admissionButton").html(0);
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "POS Bill Invoice",
            "",
            url
        );

        setTimeout(() => {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = url;
                window.history.pushState({ path: url }, "", url);
            }
        }, 4000);
    },
    createPosIndentBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var url = $(thisElement).attr("data-redirect_indent_action");
        var admission_id = $("#admission_id").val();

        if ($("#billing_table-body tr").length == 0) {
            alert("You did not select any Service Item");
            event.preventDefault();
            return false;
        }

        var reter = false;
        var stock = 0;
        $(".hdn_item_qnty").each(function () {
            if ($(this).val() == "" || $(this).val() <= 0) {
                alert("Enter Qty");
                $(this).focus();
                reter = true;
                event.preventDefault();
                return false;
            }
        });
        

        if (reter == true) {
            return false;
        }
       

        $(".current_qty").each(function (index, item) {
            let salesQty = parseFloat($(".hdn_item_qnty").eq(index).val()) || 0;
            let stock = parseFloat($(this).val()) || 0;
            if (salesQty > stock) {
                alert("Sales Qty cannot be greater than Stock Qty.");
                $(this).focus();
                reter = true;
                event.preventDefault();
                return false;
            }
        });

        if (reter == true) {
            return false;
        }

        $(".current_qty").each(function () {
            if ($(this).val() == "" || $(this).val() <= 0) {
                alert("Stock Not Available!");
                $(this).focus();
                reter = true;
                event.preventDefault();
                return false;
            }
        });

        if (reter == true) {
            return false;
        }
         var internalBatch = false;
       
        $(".internal_batch").each(function () {
            if ($(this).val() == "" ) {
                alert("Empty  Batch");               
                internalBatch = true;               
                 console.log($(this).val());
                event.preventDefault();
                // return false;
            }
        });
      
       
        if (internalBatch == true) {
                    return false;        
        }

        formValidation("posBilling");
        $(".button5").html(0);
        $(".admissionButton").html(0);

        btnSaveUpdateIndent(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "POS Bill Invoice",
            "",
            url
        );
    },

    btnSaveUpdatePosBill: function (
        thisElement,
        customFunc = "",
        responesUrl = "",
        modalClass = "",
        modalTitle = "",
        callback = "",
        callbackparam = ""
        // url
    ) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");

        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        console.log($(thisElement), formAction, formMethod);
        if (formValidation(formID) == false) {
            return false;
        }
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    var response_url =
                        responesUrl +
                        "/" +
                        data.insert_id +
                        "/" +
                        data.bill_ind +
                        "/" +
                        data.trx_id;
                    window.open(response_url, "_blank");
                    // window.location.href = url;
                },
                complete: function () {},
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText);
                    error_messages = "";
                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        error_messages
                    );

                    $.unblockUI();
                },
            }).done(function () {
                $.unblockUI();

                if (callback != "") callback(callbackparam);
            });
        }

        event.stopImmediatePropagation();
    },
    createAmbulanceBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        var formID = $(thisElement).parents("form").attr("id");
        var url = $(thisElement).attr("data-response-url");
        console.log(action, url);

        // var url = '{{ route("billing.service-billing") }}';
        // formValidation("frmBilling");
        if (formValidation(formID) == false) {
            return;
        }
        console.log("user", $("#hdn_ipd_doctor_id").val());
        if (
            $("#hdn_doctor_id").val() != "" ||
            $("#hdn_ipd_doctor_id").val() != ""
        ) {
            if ($("#billing_table-body tr").length == 0) {
                alert("You did not select any Service Item");
                event.preventDefault();
                return;
            }
            var payable =
                $("#total_payable").val() != null
                    ? parseFloat($("#total_payable").val())
                    : 0;
            var paid =
                $("#pay_amount").val() != null
                    ? parseFloat($("#pay_amount").val())
                    : 0;
            var paid_limit_amt = (payable * 60) / 100;
            if (paid < paid_limit_amt) {
                alert("Needed paid minimum 60% amount of bill amount");
            }
            btnSaveUpdate(
                $(thisElement),
                "afterSaveModal",
                action,
                "common-modal-md",
                "Bill Invoice",
                dynamicFunc.afterSaveLoadPage,
                url
            );

            $(".button5").html(0);
            $(".buttonAdmission").html(0);
        } else {
            alert("Please Select a Referral Doctor");
            $("#doctor_code").focus();
            return false;
        }
        // billingEngine.resetBillForm();
    },

    createDueCollection: function (thisElement, callback) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#voucher_no").val() == "") {
            alert("You did not enter invoice no");
            event.preventDefault();
            return;
        }

        formValidation("due_collection");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Due Collection Invoice",
            callback
        );
        // btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md', 'Service Bill Invoice');

        // billingEngine.resetBillForm();
    },
    editInvoice: function (thisElement, callback) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#voucher_no").val() == "") {
            alert("You did not enter invoice no");
            event.preventDefault();
            return;
        }
        console.log(action);
        formValidation("inviceEdit");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Edit Invoice",
            callback
        );
        // btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md', 'Service Bill Invoice');

        // billingEngine.resetBillForm();
    },
    createIpdDueCollection: function (thisElement, callback) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#admission_id").val() == "") {
            alert("You did not enter admission no");
            event.preventDefault();
            return;
        }

        formValidation("idpPayment");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Ipd Due Collection",
            afterPaymentSearch
        );
        // btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md', 'Service Bill Invoice');

        // billingEngine.resetBillForm();
    },
    createCancellation: function (thisElement, callback) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#voucher_no").val() == "") {
            alert("You did not enter invoice no");
            event.preventDefault();
            return;
        }

        formValidation("billing_cancelation");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Bill Cancellation Invoice",
            callback
        );
        // btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md', 'Service Bill Invoice');

        // billingEngine.resetBillForm();
    },

    createPosCancellation: function (thisElement, callback) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#voucher_no").val() == "") {
            alert("You did not enter invoice no");
            event.preventDefault();
            return;
        }

        formValidation("pos_billing_cancelation");
        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Bill Cancellation Invoice",
            callback
        );
        // btnSaveUpdate($(thisElement), 'afterSaveModal', action, 'common-modal-md', 'Service Bill Invoice');

        // billingEngine.resetBillForm();
    },

    resetBillForm: function () {
        $("#frmBilling").find("input, textarea").not(".keep_me").val("");
        $("#frmBilling").find("select").not(".keep_me").val("0");
        $("#net_payable").html("00.00");
        $("#total_due_con").html("00.00");
        $("#total_due_data").html("00.00");
        $("#item_total").html("00.00");
        $("#initial_payment").html(" ");
        $("#initial_payment").html("00.00");
        $("#auto_dis_ind").attr("disabled", false);
        $("#auto_dis_ind").prop("checked", true);
        $("#cmb_discount").attr("disabled", true);
        $("#discount_percent_hospital").attr("disabled", true);
        $("#discount_amount_hospital").attr("disabled", true);
        $("#discount_percent_doctor").attr("disabled", true);
        $("#discount_amount_doctor").attr("disabled", true);

        $("#discount_percent_hospital").val(0);
        $("#discount_amount_hospital").val(0);
        $("#discount_percent_doctor").val(0);
        $("#discount_amount_doctor").val(0);

        //$("#frmBilling").find("select").val(0);
        $(
            "#billing_table-body, #tfoot, #tbody, #patient_info, #doctor_info, #p_info, .item_list, #total_item_amount"
        ).html("");
    },
    receiveItemCalculateTotal: function (thisElement) {
        var return_amt = parseFloat($("#adj_discount_amount").val());
        console.log(return_amt + "_______________return_amt");
        if ($("#items_to_receive tr").length == 0) {
            $(thisElement).val("");
            $("#total_vat_amount").val("");
            $("#vat_percent").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $("#total_payable").val("");
            alert("Please add one item");
            return;
        } else {
            $("#items_to_receive tr").each(function () {
                item_total += $(this).find(".total_price").val() * 1;
            });
        }

        //console.log($(thisElement).attr('id'));
        if ($(thisElement).attr("id") == "total_vat_amount") {
            $("#vat_percent").val("");
            // $('#return_adj_amt').val(0);
            // $('#adj_hdn_data').html('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid VAT/Tax");
                $(thisElement).val("");
                return;
            }
        }
        if ($(thisElement).attr("id") == "vat_percent") {
            $("#total_vat_amount").val("");
            // $('#return_adj_amt').val(0);
            // $('#adj_hdn_data').html('');
            if ($(thisElement).val() > 100) {
                alert("Invalid VAT/Tax");
                $(thisElement).val("");
                return;
            }
        }
        if ($(thisElement).attr("id") == "discount_percent") {
            $("#total_discount_amount").val("");
            // $('#return_adj_amt').val(0);
            // $('#adj_hdn_data').html('');
            //console.log("discount Percent",$(thisElement).val());
            if ($(thisElement).val() > 100) {
                alert("Invalid Discount");
                $(thisElement).val("");
                return;
            }
        }
        if ($(thisElement).attr("id") == "total_discount_amount") {
            $("#discount_percent").val("");
            // $('#return_adj_amt').val(0);
            // $('#adj_hdn_data').html('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid Discount");
                $(thisElement).val("");
                return;
            }
        }
        var itemT_pay =
            parseFloat($("#item_total").html()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var discount_percent =
            $("#discount_percent").val() != ""
                ? parseFloat($("#discount_percent").val())
                : 0;
        var total_discount_amount =
            $("#total_discount_amount").val() != ""
                ? parseFloat($("#total_discount_amount").val())
                : 0;

        console.log(discount_percent, total_discount_amount, "Anik");

        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#items_to_receive tr").length > 0) {
            $("#items_to_receive tr").each(function () {
                item_total += $(this).find(".total_price").val() * 1;
            });
            console.log(urgent_fee);
            $("#item_total").html(item_total.toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            var total_vat_amount = 0;
            console.log("disc", vat_percent);
            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total + total_vat_amount;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;

                    // $("#vat_percent").val(total_vat_amount.toFixed(2));
                }
                final_total = item_total + vat_amount;
            }
            var discount_percent = $("#discount_percent").val() * 1;
            var total_discount_amount = 0;
            console.log("disc", vat_percent);
            if (discount_percent != 0) {
                total_discount_amount = (item_total * discount_percent) / 100;
                $("#total_discount_amount").val(
                    total_discount_amount.toFixed(2)
                );
                final_total = final_total - total_discount_amount;
            } else {
                var vat_amount = parseFloat(
                    $("#total_discount_amount").val() * 1
                );
                if (vat_amount != 0) {
                    total_discount_amount = (vat_amount / item_total) * 100;

                    // $("#discount_percent").val(total_discount_amount.toFixed(2));
                }
                final_total = final_total - vat_amount;
            }

            $("#total_payable").val((final_total + urgent_fee).toFixed(2));
            var adj_amt =
                final_total.toFixed(2) - Math.floor(final_total.toFixed(2));
            var return_adj = parseFloat($("#return_adj_amt").val());
            console.log(
                final_total,
                Math.floor(final_total) +
                    "_itemReceive____" +
                    $("#session_id").val() +
                    adj_amt +
                    "_________" +
                    return_adj
            );
            if (
                jQuery.inArray($("#session_id").val(), [
                    "IMPALA",
                    "GMC",
                    "JKMH",
                    "EWMCH",
                    "SSG",
                    "ALLIED",
                ]) !== -1
            ) {
                $("#adj_discount_amount").val(adj_amt.toFixed(2));
            }

            $("#total_due_data").text(
                (final_total - (adj_amt + return_adj)).toFixed(2)
            );

            $("#total_due").val(
                (final_total - (adj_amt + return_adj)).toFixed(2)
            );

            // billingEngine.receiveItemCalculateTotal(thisElement);
        } else {
            $("#items_to_receive tr").html("");
            $("#total_payable").val(0);
            $("#pay_amount").val(0);
            $("#given_amount").val(0);
            $("#item_total").html(0.0);
            $("#change_amount").val(0.0);
            $("#vat_percent").val("");
            $("#total_vat_amount").val("");
            $("#total_vat_amount").val("");
            $("#total_discount_amount").val("");
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();
    },
    poItemCalculateTotal: function (thisElement) {
        var item_total = 0;
        if ($("#demand_items tr").length == 0) {
            alert("Please add one item");
            return;
        } else {
            $("#demand_items tr").each(function () {
                item_total += $(this).find(".total_price").val() * 1;
            });
        }

        //console.log($(thisElement).attr('id'));
        if ($(thisElement).attr("id") == "total_vat_amount") {
            $("#vat_percent").val("");
            if ($(thisElement).val() > item_total) {
                alert("Invalid VAT/Tax");
                $(thisElement).val("");
                return;
            }
        }
        if ($(thisElement).attr("id") == "vat_percent") {
            $("#total_vat_amount").val("");
            if ($(thisElement).val() > 100) {
                alert("Invalid VAT/Tax");
                $(thisElement).val("");
                return;
            }
        }

        if ($(thisElement).attr("id") == "discount_percent") {
            $("#total_discount_amount").val("");
            //console.log("discount Percent",$(thisElement).val());
            if ($(thisElement).val() > 100) {
                alert("Invalid Discount");
                $(thisElement).val("");
                return;
            }
        }
        if ($(thisElement).attr("id") == "total_discount_amount") {
            $("#discount_percent").val("");
            if ($(thisElement).val() > item_total) {
                alert("Invalid Discount");
                $(thisElement).val("");
                return;
            }
        }
        var itemT_pay =
            parseFloat($("#item_total").val()) -
            parseFloat($("#pay_amount").val());
        var urgent_fee_total =
            $("#urgent_fee").val() != ""
                ? parseFloat($("#urgent_fee").val())
                : 0;
        var discount_percent =
            $("#discount_percent").val() != ""
                ? parseFloat($("#discount_percent").val())
                : 0;
        var total_discount_amount =
            $("#total_discount_amount").val() != ""
                ? parseFloat($("#total_discount_amount").val())
                : 0;

        console.log(discount_percent, total_discount_amount, "Anik2");

        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function () {
                item_total += $(this).find(".total_price").val() * 1;
            });
            console.log(urgent_fee);
            $("#item_total").val(item_total.toFixed(2));
            $("#total_payable").val((item_total + urgent_fee).toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            var total_vat_amount = 0;
            //console.log('disc', vat_percent);
            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total + total_vat_amount;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;

                    // $("#vat_percent").val(total_vat_amount.toFixed(2));
                }
                final_total = item_total + vat_amount;
            }

            var discount_percent = $("#discount_percent").val() * 1;
            var total_discount_amount = 0;
            // console.log('disc', vat_percent);
            if (discount_percent != 0) {
                total_discount_amount = (item_total * discount_percent) / 100;
                $("#total_discount_amount").val(
                    total_discount_amount.toFixed(2)
                );
                final_total = final_total - total_discount_amount;
            } else {
                var vat_amount = parseFloat(
                    $("#total_discount_amount").val() * 1
                );
                if (vat_amount != 0) {
                    total_discount_amount = (vat_amount / item_total) * 100;

                    // $("#discount_percent").val(total_discount_amount.toFixed(2));
                }
                final_total = final_total - vat_amount;
            }

            $("#total_due_data").html(Math.floor(final_total).toFixed(2));
            $("#discount_adj_amt").val(
                (final_total - Math.floor(final_total)).toFixed(2)
            );

            // billingEngine.receiveItemCalculateTotal(thisElement);
        } else {
            $("#items_to_receive tr").html("");
            $("#total_payable").val(0);
            $("#pay_amount").val(0);
            $("#given_amount").val(0);
            $("#item_total").val(0.0);
            $("#change_amount").val(0.0);
            $("#vat_percent").val("");
            $("#total_vat_amount").val("");
            $("#total_vat_amount").val("");
            $("#total_discount_amount").val("");
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();
    },
};

function generateSearch(thisElement, formID, reportAction, placeholder) {
    if (formID != "") {
        $(".data-table").DataTable().destroy();
        $.ajax({
            data: $("#" + formID).serialize(),
            url: reportAction,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $("#" + placeholder).html(data);
            },
            complete: function () {
                $.fn.dataTable.ext.search.push(function (
                    settings,
                    searchData,
                    index,
                    rowData,
                    counter
                ) {
                    var offices = $(
                        'input:checkbox[name="deli_status"]:checked'
                    )
                        .map(function () {
                            return this.value;
                        })
                        .get();

                    if (offices.length === 0) {
                        return true;
                    }

                    if (offices.indexOf(searchData[10]) !== -1) {
                        return true;
                    }

                    return false;
                });
                var table = $(".data-table").DataTable({
                    ordering: false,
                    bPaginate: false,
                    bLengthChange: false,
                    bAutoWidth: false,
                });
                $("input:checkbox").on("change", function () {
                    table.draw();
                });
                $.unblockUI();
            },
        });
    }
}

var pathologyFunc = {
    selectSampleCheckbox: function (thisElement) {
        var lab_no = $(thisElement).val();

        if (thisElement.checked) {
            $("#sample_item tr")
                .find(".chk_sample_item_" + lab_no)
                .prop("checked", true);
        } else {
            $("#sample_item tr")
                .find(".chk_sample_item_" + lab_no)
                .prop("checked", false);
        }
    },
    searchSampleCollectionListByPresc: function (thisElement) {
        var prescription_id = $("#prescription_uid").val();
        var admission_id = $("#admission_id").val();
        var lab_id = $("#hdn_lab_id").val();

        var from_date = $("#search_date_from").val();
        var to_date   = $("#search_date_to").val();

        // if (prescription_id == "") {
        //     $('.common-modal-notify-error').modal('show');
        //     $('.common-modal-notify-error .modal-title').html("Validation Error");
        //     $('.common-modal-notify-error .modal-body').html("You did not select any Invoice");
        //     return;
        // }

        var action = $(thisElement).attr("data-action");
        var type = $(thisElement).attr("data-type");
        $.ajax({
            data: {
                prescription_id: prescription_id,
                type: type,
                admission_id: admission_id,
                lab_id: lab_id,
                search_date_from: from_date,
                search_date_to: to_date
            },
            url: action,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                console.log($("#prescription_uid").val());
                $("#sample-container").html(data);

                if ($("#prescription_uid").val() != null) {
                    $("#all_print").removeClass("disabled");
                }

                if ($("#prescription_uid").val() == "") {
                    $("#all_print").addClass("disabled");
                }
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
    getPendingSamples: function (thisElement) {
        var prescription_uid = $("#prescription_uid").val();
        var action = $(thisElement).attr("data-action");
        $.ajax({
            data: { prescription_uid: prescription_uid },
            url: action,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $(".sample_content").html(data);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
    getCollectedSamples: function (thisElement) {
        var prescription_uid = $("#prescription_uid").val();
        var action = $(thisElement).attr("data-action");
        $.ajax({
            data: { prescription_uid: prescription_uid },
            url: action,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $(".sample_content").html(data);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
    searchSampleReceiveListByPresc: function (thisElement) {
        var lab_no = $("#lab_no").val();
        var invoice_no = $("#invoice_no").val();

        var action = $(thisElement).attr("data-action");
        var type = $(thisElement).attr("data-type");
        $.ajax({
            data: { lab_no: lab_no, type: type, invoice_no: invoice_no },
            url: action,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $(".sample_content").html(data);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
    getReceiveSamples: function (thisElement) {
        var lab_no = $("#lab_no").val();
        if (lab_no == "") {
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not select any Lab No"
            );
            return;
        }
        var action = $(thisElement).attr("data-action");
        $.ajax({
            data: { lab_no: lab_no },
            url: action,
            type: "post",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $(".sample_content").html(data);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },
    storeReceiveSamples: function (thisElement) {
        // var lab_no = $("#lab_no").val();
        var lab_id = $(thisElement).attr("data-lab-id");
        var itemArray = $(".receive_item")
            .map(function () {
                if ($(this).is(":checked")) {
                    return this.value;
                }
            })
            .get();
        if (itemArray == "" && lab_id == "") {
            alert("Select Item");
            return;
        }
        if (confirm("Are you sure?")) {
            var action = $(thisElement).attr("data-action");
            $.ajax({
                data: { lab_id: lab_id, itemArray: itemArray },
                url: action,
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    console.log(data.item + "_bellal");
                    if (data.item != null) {
                        for (let i = 0; i < data.item.length; i++) {
                            $(".receive_item").map(function () {
                                console.log(data.item);

                                if ($(this).val() == data.item[i]) {
                                    $(this).parents("tr").remove();
                                }
                            });
                        }
                    } else {
                        $(thisElement).parents("tr").remove();
                    }

                    if (data.title == "Success") {
                        $(".common-modal-notify").modal("show");
                        $(".common-modal-notify .modal-body").html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                        $(".common-modal-notify .modal-title").html(data.title);
                        $(".common-modal-notify .modal-body").html(data.msg);
                    }
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        }
    },
    collectPendingSamples: function (thisElement) {
        event.preventDefault();
        var pageurl = $(thisElement).attr("href");
        var prescription_uid = $(thisElement).attr("data-pres");

        $.ajax({
            async: true,
            data: { prescription_uid: prescription_uid },
            type: "get",
            url: pageurl,
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                $("#page-content").html(data);
            },
            complete: function (data) {
                $.unblockUI();
            },
        });

        if (pageurl != window.location) {
            window.history.pushState({ path: pageurl }, "", pageurl);
        }
        event.stopImmediatePropagation();
        return false;
    },
    storeResultEntry: function (thisElement) {
        var riderect_action = $(thisElement).attr("data-redirect");
        var type = $(thisElement).attr("data-type");
        $("#action_type").val(type);
        // btnSaveUpdate  btnSaveUpdatefile  btnSaveUpdateUpload
        btnSaveUpdatefile(
            $(thisElement),
            "",
            "",
            "",
            "",
            pathologyFunc.redirectHistory
            // dynamicFunc.afterSaveLoadPage,
            // riderect_action
        );
    },

    redirectHistory: function () {
        window.history.back();
    },
    searchResultEntry: function (thisElement) {
        var formID = "frm-result-search";
        var reportAction = $("#frm-result-search").attr("action");
        generateReport(thisElement, formID, reportAction, "result-container");
    },
    sendLabReportMail: function (
        thisElement,
        patientId = "",
        reportId = "",
        sendUrl,
        clickSearch = ""
    ) {
        if (confirm("Are You Sure ?")) {
            $.ajax({
                data: {
                    pat_id: patientId,
                    report_id: reportId,
                },
                url: sendUrl, //  "{{route('send-mail-lab-report')}}",
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    // $("#search_data").html(data);
                    if (clickSearch != "") {
                        clickSearch.click();
                    }

                    // EMRFunc.getCurrentMedicalUsages($('#nav-lab-report-tab'));
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        }ppa
    },

    sendLabReportSms: function (
        thisElement,
        mobileNo = "",
        text = "",
        id,
        sendUrl = "",
        clickSearch = ""
    ) {
        if (confirm("Are You Sure ?")) {
            $.ajax({
                data: {
                    mobileNo: mobileNo,
                    text: text,
                    id: id,
                },
                url: sendUrl, //  "{{route('send-mail-lab-report')}}",
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    // $("#search_data").html(data);
                    if (clickSearch != "") {
                        clickSearch.click();
                    }

                    // EMRFunc.getCurrentMedicalUsages($('#nav-lab-report-tab'));
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        }
    },
    sendRadReportSms: function (
        thisElement,
        mobileNo = "",
        text = "",
        id,
        sendUrl = "",
        clickSearch = ""
    ) {
        console.log(id + sendUrl);
        if (confirm("Are You Sure ?")) {
            $.ajax({
                data: {
                    mobileNo: mobileNo,
                    text: text,
                    id: id,
                },
                url: sendUrl, //  "{{route('send-mail-lab-report')}}",
                type: "post",
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    // $("#search_data").html(data);
                    if (clickSearch != "") {
                        clickSearch.click();
                    }

                    // EMRFunc.getCurrentMedicalUsages($('#nav-lab-report-tab'));
                },
                complete: function () {
                    $.unblockUI();
                },
            });
        }
    },
};

var ipdbillingEngine = {
    patientQuickReg: function (thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $("#hdn_patient_id").val(data.insert_id);
                    $("#patient_id").val(data.patient_name);
                    $("#" + formID + " input[name=hdn_patient_id]").val(
                        data.insert_id
                    );

                    var patient_info =
                        "<strong>Patient Code: " +
                        data.patient_code +
                        " : </strong>Name: " +
                        data.patient_name +
                        ", <strong>Gender : </strong>" +
                        data.gender +
                        ", <strong>Age : </strong>" +
                        data.age +
                        ", <strong>Phone : </strong>" +
                        data.phone_mobile;
                    $("#patient_info").html(patient_info);

                    $("#" + formID)
                        .find("input, textarea")
                        .not(".keep_me")
                        .val("");
                    $("#" + formID)
                        .find("select")
                        .not(".keep_me")
                        .val("0");
                },
                complete: function () {
                    if (isAModalOpen) $(".modal").modal("hide");

                    $.unblockUI();
                },
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages)
                            .siblings("label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] +
                            "</div>";
                    }

                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );

                    $.unblockUI();
                },
            });
        }

        event.stopImmediatePropagation();
    },
    doctorQuickReg: function (thisElement) {
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var doc_type = $(thisElement).parents("form").find("#doc_type").val();

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    if (doc_type == 1) {
                        $("#hdn_doctor_id").val(data.insert_id);
                        $("#doctor_code").val(data.last_name);
                        var doctor_info =
                            "<strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong><strong><strong>Name: </strong>" +
                            data.last_name +
                            ", <strong>Gender: </strong>" +
                            data.gender +
                            "<strong>, Phone : </strong>" +
                            data.doctor_mobile;
                        $("#doctor_info").html(doctor_info);
                    }
                    if (doc_type == 2) {
                        $("#hdn_first_refer").val(data.insert_id);
                        $("#first_refer").val(data.last_name);
                        var doctor_info =
                            "<strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong><strong><strong>Name: </strong>" +
                            data.last_name +
                            ", <strong>Gender: </strong>" +
                            data.gender +
                            "<strong>, Phone : </strong>" +
                            data.doctor_mobile;
                        $("#doctor_ref1_info").html(doctor_info);
                    }
                    if (doc_type == 3) {
                        $("#hdn_second_refer").val(data.insert_id);
                        $("#second_refer").val(data.last_name);
                        var doctor_info =
                            "<strong>Doctor Code: " +
                            data.doctor_code +
                            " : </strong><strong><strong>Name: </strong>" +
                            data.last_name +
                            ", <strong>Gender: </strong>" +
                            data.gender +
                            "<strong>, Phone : </strong>" +
                            data.doctor_mobile;
                        $("#doctor_ref2_info").html(doctor_info);
                    }
                },
                complete: function () {
                    if (isAModalOpen) $(".modal").modal("hide");
                    $.unblockUI();
                },
            });
        }
        event.stopImmediatePropagation();
    },

    calculateTotal: function (thisElement) {
        if (
            parseFloat($("#total_discount_amount").val()) >
            parseFloat($("#item_total").html())
        ) {
            $("#discount_percent_hospital").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            alert("discount amount is over");
            ipdbillingEngine.calculateTotal(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;

            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function () {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this)
                        .find(".item_delivery_status")
                        .val();
                    if (delivery_status == 2) {
                        if (
                            $(this).find(".hdn_item_urgent_fee").val() != "null"
                        ) {
                            urgent_fee += parseFloat(
                                $(this).find(".hdn_item_urgent_fee").val()
                            );
                        }
                    }
                });

                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val(item_total.toFixed(2));

                var discount_percent_hospital =
                    $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                }

                var discount_amt_hospital =
                    (item_total * discount_percent_hospital) / 100;

                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = 0;
                } else {
                    discount_amt_hospital.toFixed(2);
                }

                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor =
                    $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val("");
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount =
                    discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {
                } else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val("");
                    $("#discount_percent_doctor").val("");
                    $("#discount_amount_hospital").val("");
                    $("#discount_amount_doctor").val("");
                    discount_percent_hospital =
                        $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor =
                        $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor =
                    (item_total * discount_percent_doctor) / 100;

                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = 0;
                } else {
                    discount_amt_doctor.toFixed(2);
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {
                } else {
                    $("#discount_percent").val("");
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total = (item_total * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = "";
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total);
                if (
                    discount_percent_hospital != 0 ||
                    discount_percent_doctor != 0
                )
                    $("#discount_percent").val(
                        discount_percent_hospital + discount_percent_doctor
                    );
                else $("#discount_percent").val("");

                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount =
                        discount_amt_doctor + discount_amt_hospital;
                    if (total_discount_amount == 0) {
                        total_discount_amount = "";
                    }

                    if (
                        discount_percent_hospital + discount_percent_doctor ==
                        0
                    ) {
                        $("#discount_percent").val("");
                    } else {
                        $("#discount_percent").val(
                            discount_percent_hospital + discount_percent_doctor
                        );
                    }

                    $("#total_discount_amount").val(total_discount_amount);

                    after_disc_amt = item_total - total_discount_amount;
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = (item_total * discount_percent) / 100;
                    $("#total_discount_amount").val(
                        discount_amt_total.toFixed(2)
                    );
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

                var item_vat = $("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;

                var total_payable = after_disc_amt + item_vat + s_charge;
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));

                var pay_amount = $("#pay_amount").val() * 1;
                $("#total_due_data").html(
                    (total_payable - pay_amount).toFixed(2)
                );

                ipdbillingEngine.calculatePayment(thisElement);
            } else {
                $("#billing_table-body tr").html("");
                $("#total_payable").val(0);
                $("#pay_amount").val(0);
                $("#given_amount").val(0);
                $("#item_total").html(0.0);
                $("#change_amount").val(0.0);
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    },
    calculatePosTotal: function (thisElement) {
        var item_total = 0;
        if ($("#billing_table-body tr").length > 0) {
            $("#billing_table-body tr").each(function () {
                item_total += $(this).find(".item_total_amt").val() * 1;
            });
            $("#item_total").html(item_total.toFixed(2));

            var vat_perc = $("#vat_perc").val() * 1;
            var vat_amt = (item_total * vat_perc) / 100;
            $("#vat_amt").val(vat_amt.toFixed(2)).attr("readonly", "readonly");

            var discount_percent = $("#discount_percent").val() * 1;
            var discount_amt = (item_total * discount_percent) / 100;
            $("#discount_amt")
                .val(discount_amt.toFixed(2))
                .attr("readonly", "readonly");

            var other_discount = $("#other_discount").val() * 1;
            var vat_amt = $("#vat_amt").val() * 1;
            var discount_amt = $("#discount_amt").val() * 1;

            $("#sub_total").html(item_total.toFixed(2));
            var sub_total = $("#sub_total").val() * 1;
            var net_payable = (item_total - discount_amt) * 1;
            $("#net_payable").html(net_payable.toFixed(2));
            // $("#pay_amount").val(net_payable.toFixed(2));

            var item_vat = $("#item_vat").val() * 1;
            var urgent_fee = $("#urgent_fee").val() * 1;
            var s_charge = $("#s_charge").val() * 1;
        } else {
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();
    },
    calculateItemTotal: function (thisElement) {
        var item_id = $(thisElement).parents("tr").find(".item_id").val();
        var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
        var item_rate = $("#hdn_item_rate_" + item_id).val() * 1;
        $("#hdn_item_total_qnty_" + item_id).val(item_qnty * item_rate);
    },
    calculatePayment: function (thisElement) {
        // change_amount
        // cash_amount
        // var total_amount = parseInt($("#total_payable").val() * 1);

        var pay_amount = parseInt($("#cash_bd_amount").val() * 1);
        if (pay_amount) {
            $("#cash_amount").val(pay_amount);
            $("#change_amount").val("");
        } else {
            $("#change_amount").val("");
            $("#cash_amount").val(total_amount);
        }
    },
    calculatePosPayment: function (thisElement) {
        var net_payable = $("#net_payable").html().trim() * 1;
        var pay_amount = $("#pay_amount").val() * 1;
        if (net_payable > 0) {
            if (pay_amount > net_payable) {
                $(".common-modal-notify-error").modal("show");
                $(".common-modal-notify-error .modal-title").html(
                    "Validation Error"
                );
                $(".common-modal-notify-error .modal-body").html(
                    "Payment Amount can not be greater than Net Payable Amount"
                );
                $("#total_due, #total_due_con, #pay_amount").val("");
                return;
            }

            var given_amount = $("#given_amount").val() * 1;

            if (pay_amount > 0) {
                if (given_amount > 0)
                    $("#change_amount").val(given_amount - pay_amount);
                else $("#change_amount").val("");
            } else {
                $("#change_amount").val("");
            }
            $("#total_due").val((net_payable - pay_amount).toFixed(2));
            $("#total_due_con").html((net_payable - pay_amount).toFixed(2));
        } else {
            $("#pay_amount, #given_amount").val("");
            $(".common-modal-notify-error").modal("show");
            $(".common-modal-notify-error .modal-title").html(
                "Validation Error"
            );
            $(".common-modal-notify-error .modal-body").html(
                "You did not selected any Item."
            );
            return;
        }
    },
    createBill: function (thisElement) {
        var action = $(thisElement).attr("data-response_action");
        if ($("#billing_table-body tr").length == 0) {
            alert("You did not select any Service Item");
            event.preventDefault();
            return;
        }

        formValidation("frmBilling");

        btnSaveUpdate(
            $(thisElement),
            "afterSaveModal",
            action,
            "common-modal-md",
            "Service Bill Invoice"
        );

        ipdbillingEngine.resetBillForm();
    },

    resetBillForm: function () {
        $("#frmBilling").find("input, textarea").not(".keep_me").val("");
        $("#frmBilling").find("select").not(".keep_me").val("0");
        $("#net_payable").html("00.00");
        $("#total_due_con").html("00.00");
        $("#total_due_data").html("00.00");
        $("#item_total").html("00.00");
        $("p").html("");

        //$("#frmBilling").find("input").val('');
        //$("#frmBilling").find("select").val(0);
        $(
            "#billing_table-body, #tfoot, #tbody, #patient_info, #doctor_info",
            "#p_info"
        ).html("");
    },
};

function checkBlankSpace(element) {
    if ($(element).val().trim().length == 0) {
        $(element).val("");
    }
}

function numberFormat(number, decimals, decimalSeparator, thousandsSeparator) {
    decimals = decimals !== undefined ? decimals : 0;
    decimalSeparator = decimalSeparator || ".";
    thousandsSeparator = thousandsSeparator || ",";

    var parsedNumber = parseFloat(number);

    if (isNaN(parsedNumber)) {
        return "";
    }

    var parts = parsedNumber.toFixed(decimals).split(".");
    var integerPart = parts[0].replace(
        /\B(?=(\d{3})+(?!\d))/g,
        thousandsSeparator
    );
    var formattedNumber = integerPart;

    if (parts.length > 1) {
        formattedNumber += decimalSeparator + parts[1];
    }

    return formattedNumber;
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");
    return `${day}-${month}-${year}`;
}

// check NullOrUndefinedOrNaNOrEmpty
function isNullOrUndefinedOrNaN(value) {
    return (
        value === null || value === undefined || isNaN(value) || value === ""
    );
}

document.addEventListener("keydown", function (event) {
    // if (event.key === "F4") {
    //     document.getElementById("save_button").click();
    // }
    // if (event.key === "F5") {
    //     document.getElementById("print_button").click();
    // }
    // if (event.key === "F6") {
    //     document.getElementById("template_save_button").click();
    // }
    // if (event.key === "F10") {
    //     document.getElementById("med_td_action_0").click();
    // }
});
