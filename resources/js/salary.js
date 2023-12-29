$(function () {
    // $("#detail_salary").modal('show')/
    $(".show-salary-detail").on("click", function (e) {
        e.preventDefault();
        var url = $(this).data("url");
        $.ajax({
            url: url,
            type: "post",
            dataType: "html",

            success: function (response) {
                console.log(response);
                $(".detail-salary").html(response);
                $("#detail_salary").modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        });
    });

    $(".export-statistic").on("click",function(){
        var url = $(this).data("url");
        var department = $("#department").val();
        var selected_month = $("#selected_month").val();
        var selected_year = $("#selected_year").val();
        $.ajax({
            url:url,
            type: "post",
            // dataType: "json",
            data:{
                department : department,
                selected_month : selected_month,
                selected_year : selected_year,
            },
            success:function(response){
                console.log(response)
                window.location.href = response.url;
            },
            error: function(xhr) {
                // Handle error
                console.error(xhr.responseText);
            }
        })
    })
});
