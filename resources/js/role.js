$(function () {
    $(document).ready(function() {
        var defaultTab = $(".role-tab[data-url*='1']");
    
        loadRoleUsers(defaultTab);
    });
    
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
    
    $(".role-tab").on("click", function(e) {
        e.preventDefault();
        $(".role-tab").removeClass("active");
        $(this).addClass("active");
        loadRoleUsers($(this));
    });
});
