$(function () {
    $(document).ready(function() {
        // Lấy tab có id là 1 và kích hoạt nó
        var defaultTab = $(".role-tab[data-url*='1']");
        // defaultTab.addClass("active");
    
        // Thực hiện AJAX request khi tab mặc định được kích hoạt
        loadRoleUsers(defaultTab);
    });
    
    // Bổ sung hàm để tải người dùng theo tab
    function loadRoleUsers(tab) {
        var url = tab.data("url");
        $.ajax({
            url: url,
            type: "post",
            dataType: "html",
            success: function (response) {
                $(".list_user_body").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            }
        });
    }
    
    // Thêm sự kiện click cho tất cả các tab
    $(".role-tab").on("click", function(e) {
        e.preventDefault();
        $(".role-tab").removeClass("active");
        $(this).addClass("active");
        loadRoleUsers($(this));
    });
});
