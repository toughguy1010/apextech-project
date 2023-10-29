$(function () {
    $(".form-check-input").on("change", function () {
        let isChecked = this.checked;
        let canRemove = $(this).data('department');
        if (!isChecked && canRemove == "1") {
            let employeeId = $(this).val();
            let removeEmployeeInput = `<input type="hidden" name="remove_employee[]" value="${employeeId}">`;
            $(this).attr('name', 'employees_id[]');
            $(this).after(removeEmployeeInput);
        } else {
            $(this).attr('name', 'employees_id[]');
            $("input[name='remove_employee[]'][value='" + $(this).val() + "']").remove();
        }
    });


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

});
