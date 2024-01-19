$(function () {
    $(".update-task-status").on("change", function () {
        var url = $(this).data("url");
        var status = $(this).val();
        console.log(status);
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                status: status,
            },
            success: function (response) {
                $(".message-status").html(response.message);
                $(".message-status").addClass("active-message-status");
                setTimeout(function () {
                    $(".message-status").fadeOut();
                }, 3000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    });
    $(".open-task-model").on("click", function () {
        var url = $(this).data("url");
        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",

            success: function (response) {
                $("#modal-show").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    });
   
});
