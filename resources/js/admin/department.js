$(function () {
    $(".btn-delete").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            var url = $(this).data("url");
            if (confirm("Bạn có muốn xóa phòng ban này?")) {
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
                        const departmentID = response.id;
                        $("#department-" + departmentID).remove();
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

    $(".search-emp-btn").on("click", function (e) {
        var searchVal = $(".search-emp-input").val().trim();
        var url = $(this).data("url");
        var departmentID = $(this).data("departmentid");

        $.ajax({
            method: "GET",
            url: url + "/" + searchVal,
            data: { search: searchVal },
            success: function (response) {
                var users = response.users;
                $("#employee-list").empty();

                users.forEach(function (user) {
                    var newRow = $("<tr>");

                    var checked =
                        user.department_id == departmentID ? "checked" : "";

                    newRow.append(
                        '<td><input class="form-check-input" type="checkbox" value="' +
                            user.id +
                            '" name="employees_id[]" id="flexCheckChecked" data-url="' +
                            user.url +
                            '" data-department="' +
                            (user.department_id == null ||
                            user.department_id == departmentID
                                ? 1
                                : 0) +
                            '"' +
                            checked +
                            "></td>"
                    );
                    newRow.append("<td>" + user.name + "</td>");
                    newRow.append("<td>" + user.username + "</td>");
                    newRow.append(
                        "<td>" +
                            (user.department_name
                                ? user.department_name
                                : "Chưa có phòng ban") +
                            "</td>"
                    );
                    $("#employee-list").append(newRow);
                });
            },
            error: function (error) {
                // Xử lý khi có lỗi xảy ra trong quá trình gửi yêu cầu
                console.log("Có lỗi xảy ra:", error);
            },
        });
    });

    $(document).on("change", ".form-check-input", function () {
        let isChecked = this.checked;
        let canRemove = $(this).data("department");
        if (!isChecked && canRemove == "1") {
            let employeeId = $(this).val();
            let removeEmployeeInput = `<input type="hidden" name="remove_employee[]" value="${employeeId}">`;
            $(this).attr("name", "employees_id[]");
            $(this).after(removeEmployeeInput);
        } else {
            $(this).attr("name", "employees_id[]");
            $(
                "input[name='remove_employee[]'][value='" + $(this).val() + "']"
            ).remove();
        }
    });

    $(".set-department-employee").on("change", function(){
        var isChecked = $(this).is(":checked");
        var url = $(this).data("url");
        var department = $(this).data("department")
        if (isChecked) {
            updateUserDepartment(url, department)
        } else {
            department = null;
            updateUserDepartment(url, department)

        }

    })

    function updateUserDepartment(url,department){
        $.ajax({
            url : url ,
            type:"post",
            dataType: "json",
            data: {
                department : department
            },
            success: function (response){
                $(".message-report").html(response.message);

                if (response.status == 1) {
                    $(".message-report").removeClass("false-message-report")
                    $(".message-report").addClass("active-message-report");
                    setTimeout(function() {
                    $(".message-report").fadeOut();
                }, 3000);
                } else {
                    $(".message-report").removeClass("active-message-report")
                    $(".message-report").addClass("false-message-report");
                    setTimeout(function() {
                    $(".message-report").fadeOut();
                }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            }
        })
    }
});
