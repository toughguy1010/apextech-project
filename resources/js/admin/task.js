$(function () {

    $(".btn-delete").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            var url = $(this).data("url");
            if (confirm("Bạn có muốn xóa công việc này?")) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    dataType: "json",
                    success: function (response) {
                        $(".message").html(
                            '<div class="alert alert-success">' +
                                response.success +
                                "</div>"
                        );
                        setTimeout(function () {
                            $(".message").fadeOut("slow");
                        }, 5000);
                        const taskID = response.id;
                        $("#task-" + taskID).remove();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // Handle errors
                        console.log("Error:", textStatus, errorThrown);
                        $(".message").html(
                            '<div class="alert alert-danger">' +
                                response.error +
                                "</div>"
                        );
                        setTimeout(function () {
                            $(".message").fadeOut("slow");
                        }, 3000);
                    },
                });
            }
        });
    });
});
