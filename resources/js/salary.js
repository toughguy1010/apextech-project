$(function () {
    // $("#detail_salary").modal('show')/
    $('.show-salary-detail').on("click",function(e){
        e.preventDefault()
        var url = $(this).data("url")
        $.ajax({
            url: url,
            type: "post",
            dataType: "html",
           
            success: function(response){
                console.log(response)
                $(".detail-salary").html(response)
                $("#detail_salary").modal('show')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        })
    })
})