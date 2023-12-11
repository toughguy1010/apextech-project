$(function () {
    $("#time_logs_modal").modal("show");

    $("#checkin").on("click", function () {
        var url = $(this).data("url");
        var userID = $(this).data("userid");
        var date = $(this).data("date");

        var currentTime = new Date();

        var options = {
            hour: "numeric",
            minute: "numeric",
            second: "numeric",
            timeZone: "Asia/Ho_Chi_Minh",
        };
        var time = currentTime.toLocaleString("vi-VN", options);

        $.ajax({
            url :url,
            type: "post",
            dataType: "json",
            data:{
                userId : userID,
                date : date,
                time : time,
            },
            success: function(response){
                console.log(response)
            } ,error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        })
    });

    $("#checkout").on("click", function () {
        var url = $(this).data("url");
        var userID = $(this).data("userid");
        var date = $(this).data("date");

        var currentTime = new Date();

        var options = {
            hour: "numeric",
            minute: "numeric",
            second: "numeric",
            timeZone: "Asia/Ho_Chi_Minh",
        };
        var time = currentTime.toLocaleString("vi-VN", options);

        $.ajax({
            url :url,
            type: "post",
            dataType: "json",
            data:{
                userId : userID,
                date : date,
                time : time,
            },
            success: function(response){
                console.log(response)
            } ,error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        })
    });
});
