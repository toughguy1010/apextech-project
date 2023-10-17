import "./bootstrap";

$(function () {
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
        console.log(url);
        $.ajax({
            type: "post",
            dataType: "json",
            url: url,
            data: form,
            processData: false, // Ensure that jQuery doesn't process the data
            contentType: false, // Ensure that jQuery doesn't set the content type
            success: function(results){
                if (results.success == true) {
                    const imageUrl = "/" + results.url;
                    $("#show_img").html(
                        '<a href=" ' +
                            imageUrl +
                            ' "> <img src=" ' +
                            imageUrl +
                            ' " width =  "150px"> </a>'
                    );
                    $("#thumb").val(imageUrl);
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
});
