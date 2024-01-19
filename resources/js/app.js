import "./bootstrap";
import "tinymce/tinymce";
import "tinymce/skins/ui/oxide/skin.min.css";
import "tinymce/skins/content/default/content.min.css";
import "tinymce/skins/content/default/content.css";
import "tinymce/icons/default/icons";
import "tinymce/themes/silver/theme";
import "tinymce/models/dom/model";
$(function () {
    tinymce.init({
        selector: ".tinymce",
        toolbar:
            "undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | code",
        skin: false,
        content_css: false,
    });
    // upload file
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#upload").on("change", function () {
        const form = new FormData();
        form.append("file", this.files[0]);
        const url = $(this).data("url");
        $.ajax({
            type: "post",
            dataType: "json",
            url: url,
            data: form,
            processData: false, // Ensure that jQuery doesn't process the data
            contentType: false, // Ensure that jQuery doesn't set the content type
            success: function (results) {
                if (results.success == true) {
                    const imageUrl = "/" + results.url;
                    $("#show_img").html(
                        '<a href=" ' +
                            imageUrl +
                            ' "> <img src=" ' +
                            imageUrl +
                            ' " width =  "150px"> </a>'
                    );
                    $("#avatar").val(imageUrl);
                } else {
                    alert("upload file failed");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        });
    });

    // menu child
    $(".has-child a.sidebar__link").on("click", function (event) {
        event.preventDefault();
        $(this).siblings(".siderbar__submenu").slideToggle();
        $(this).siblings(".arrow").toggleClass("up-arrow");
    });

    // confirm update infomation
    $(".confirm").on("click", function (e) {
        e.preventDefault();
        if (confirm("Bạn có muốn lưu lại thông tin đã thay đổi?")) {
            $("#personal-info").submit();
        }
    });

    $("#notification").on("click", function (e) {
        e.preventDefault();
        var url = $(this).data("url");
        $(this).toggleClass("show");
        $.ajax({
            type: "get",
            dataType: "html",
            url: url,
            success: function (response) {
                $("#notification_item").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        });
    });

    $(".plus-process").on("click", function () {
        var clone = $(this).closest(".task-process-item").clone(true);
        $(this).closest(".task-process-item").after(clone);
    });
    $(".minus-process").on("click", function () {
        // Kiểm tra có nhiều hơn một task-process-item không
        if ($(".task-process-item").length > 1) {
            // Xóa task-process-item gần nhất
            $(this).closest(".task-process-item").remove();
        }
    });

    setTimeout(function (){
        $('.overlay-arlert').hide()
    }, 4000)
    $(".alert").on("click", function(){
        $('.overlay-arlert').hide()
    })

    $(".show_avt_name").hover(
        function() {
            // Hover-in event
            var info = $(this).data("info");
            $(this).next(".avt_name").stop(true, true).text(info).fadeIn(200);
        },
        function() {
            // Hover-out event
            $(this).next(".avt_name").stop(true, true).fadeOut(200);
        }
    );
});
