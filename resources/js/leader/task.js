$(function () {
    $(".update-task-status").on("change",function(){
        var url = $(this).data("url")
        var status = $(this).val()
        console.log(status)
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                status: status,
            },
            success: function (response) {
              $(".message-status").html(response.message)
              $(".message-status").addClass("active-message-status")
              setTimeout(function(){
                $(".message-status").fadeOut();
              },3000)
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log(textStatus,errorThrown)
            },
        });
    })
});
