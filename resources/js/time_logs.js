$(function () {
    function senAjax(url, userID, date, time) {
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {
                userId: userID,
                date: date,
                time: time,
            },
            success: function (response) {
                $(".message-report").html(response.message);
                if (response.success == true) {
                    $(".message-report").removeClass("false-message-report");
                    $(".message-report").addClass("active-message-report");
                } else {
                    $(".message-report").removeClass("active-message-report");
                    $(".message-report").css("display", "block");
                    $(".message-report").addClass("false-message-report");
                }
                setTimeout(function () {
                    $(".message-report").fadeOut();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }, 2000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        });
    }
    
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
        
        senAjax(url, userID, date, time);
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
        
        senAjax(url, userID, date, time);
    });

    // $("#date_time-logs").modal('show')

    $(".show_time-logs").on("click",function(){
        var userId =  $(this).data("userid");
        var url =  $(this).data("url");
        var date =  $(this).data("date");
        // $("#date_time-logs").modal('show')
        $.ajax({
            url: url,
            type: "post",
            dataType: "html",
            data: {
                userId: userId,
                date: date, 
            },
            success: function(response){
                console.log(response)
                $(".time_log-detail").html(response)
                $("#date_time-logs").modal('show')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        })
    })
});
