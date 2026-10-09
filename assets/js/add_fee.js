
$(document).ready(function () {

    // LOAD STUDENTS USING AJAX
    $.ajax({
        url: "api/get_students.php",
        type: "GET",
        dataType: "json",

        success: function (students) {
            $.each(students, function (index, student) {
                $("#student").append(
                    $("<option>")
                        .val(student.user_id)
                        .text(student.name)
                );
            });
        },

        error: function () {
            $("#studentError").text("Unable to load students.");
        }
    });


    // FORM SUBMISSION AND VALIDATION
    $("#feeForm").submit(function (event) {
        event.preventDefault();

        let valid = true;

        // Clear previous errors
        $(".error-message").text("");
        $("input, select").removeClass("input-error");

        const student = $("#student").val();
        const amount = $("#amount").val();
        const paidDate = $("#paid_date").val();
        const dueDate = $("#due_date").val();
        const status = $("#status").val();


        // STUDENT VALIDATION
        if (student === "") {
            $("#studentError").text("Please select a student.");
            $("#student").addClass("input-error");
            valid = false;
        }


        // AMOUNT VALIDATION
        if (amount === "") {
            $("#amountError").text("Please enter the fee amount.");
            $("#amount").addClass("input-error");
            valid = false;
        } else if (!Number.isFinite(Number(amount)) || Number(amount) <= 0) {
            $("#amountError").text("Amount must be greater than 0.");
            $("#amount").addClass("input-error");
            valid = false;
        }


        // DUE DATE VALIDATION
        if (dueDate === "") {
            $("#dueDateError").text("Please select the due date.");
            $("#due_date").addClass("input-error");
            valid = false;
        }


        // STATUS VALIDATION
        if (status === "") {
            $("#statusError").text("Please select the payment status.");
            $("#status").addClass("input-error");
            valid = false;
        }


        // PAID DATE VALIDATION
        if (status === "paid" && paidDate === "") {
            $("#paidDateError").text(
                "Paid date is required when status is Paid."
            );
            $("#paid_date").addClass("input-error");
            valid = false;
        }


        // DATE COMPARISON
        if (paidDate !== "" && dueDate !== "" && paidDate > dueDate) {
            $("#paidDateError").text(
                "Paid date cannot be after the due date."
            );
            $("#paid_date").addClass("input-error");
            valid = false;
        }


        // STOP IF VALIDATION FAILS
        if (!valid) {
            return;
        }


        // AJAX: INSERT FEE
        $.ajax({
            url: "api/add_fee.php",
            type: "POST",

            data: {
                user_id: student,
                amount: amount,
                paid_date: paidDate,
                due_date: dueDate,
                status: status
            },

            dataType: "json",

            success: function (response) {
                if (response.success) {
                    alert("Fee added successfully.");
                    window.location.href = "fee_list.php";
                } else {
                    alert(response.message || "Unable to add fee.");
                }
            },

            error: function () {
                alert("Unable to add fee. Please try again.");
            }
        });
    });


    // CLEAR STUDENT ERROR
    $("#student").change(function () {
        if ($(this).val() !== "") {
            $("#studentError").text("");
            $(this).removeClass("input-error");
        }
    });


    // CLEAR AMOUNT ERROR
    $("#amount").on("input", function () {
        if ($(this).val() !== "" && Number($(this).val()) > 0) {
            $("#amountError").text("");
            $(this).removeClass("input-error");
        }
    });


    // CLEAR DUE DATE ERROR
    $("#due_date").change(function () {
        if ($(this).val() !== "") {
            $("#dueDateError").text("");
            $(this).removeClass("input-error");
        }

        validateDates();
    });


    // CLEAR PAID DATE ERROR AND RECHECK DATES
    $("#paid_date").change(function () {
        if ($(this).val() !== "") {
            $("#paidDateError").text("");
            $(this).removeClass("input-error");
        }

        validateDates();
    });


    // RECHECK DATE ORDER WHEN EITHER DATE CHANGES
    function validateDates() {
        const paidDate = $("#paid_date").val();
        const dueDate = $("#due_date").val();

        if (paidDate !== "" && dueDate !== "" && paidDate > dueDate) {
            $("#paidDateError").text(
                "Paid date cannot be after the due date."
            );
            $("#paid_date").addClass("input-error");
        } else {
            $("#paidDateError").text("");
            $("#paid_date").removeClass("input-error");
        }
    }


    // CLEAR STATUS ERROR
    $("#status").change(function () {
        if ($(this).val() !== "") {
            $("#statusError").text("");
            $(this).removeClass("input-error");
        }

        if ($(this).val() !== "paid" || $("#paid_date").val() !== "") {
            $("#paidDateError").text("");
            $("#paid_date").removeClass("input-error");
        }
    });

});
