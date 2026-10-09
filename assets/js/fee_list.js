        
    
    
    
    /* =====================================
       SEARCH FIELD - DYNAMIC CHANGE
       ===================================== */

    $("#search_by").change(function () {

        let searchType = $(this).val();

        // Clear previous value and error
        $("#search_value").val("");
        $("#searchError").text("");
        $("#search_value").removeClass("input-error");


        // Student Name
        if (searchType === "student") {

            $("#search_value")
                .attr("type", "text")
                .attr("placeholder", "Enter student name");

        }


        // Fee ID
        else if (searchType === "fee_id") {

            $("#search_value")
                .attr("type", "text")
                .attr("placeholder", "Enter Fee ID");

        }

    });


    /* =====================================
       SEARCH VALIDATION
       ===================================== */

    $("#searchForm").submit(function (event) {

        let valid = true;

        let searchType = $("#search_by").val();

        let searchValue = $("#search_value").val().trim();


        // Clear previous error
        $("#searchError").text("");
        $("#search_value").removeClass("input-error");


        /* Empty value */

        if (searchValue === "") {

            $("#searchError").text(
                "Please enter a search value."
            );

            $("#search_value").addClass("input-error");

            valid = false;

        }


        /* Student Name validation */

        else if (searchType === "student") {

            let namePattern = /^[A-Za-z]+(?:\s+[A-Za-z]+)*$/;


            if (!namePattern.test(searchValue)) {

                $("#searchError").text(
                    "Please enter a valid student name."
                );

                $("#search_value").addClass("input-error");

                valid = false;

            }

        }


        /* Fee ID validation */

        else if (searchType === "fee_id") {

            let feeIdPattern = /^[0-9]+$/;


            if (!feeIdPattern.test(searchValue)) {

                $("#searchError").text(
                    "Please enter a valid Fee ID."
                );

                $("#search_value").addClass("input-error");

                valid = false;

            }

        }


        /* Stop form if validation fails */

        if (!valid) {

            event.preventDefault();

        }

    });


    /* =====================================
       SEARCH INPUT - CLEAR ERROR
       ===================================== */

    $("#search_value").on("input", function () {

        $("#searchError").text("");

        $(this).removeClass("input-error");

    });


    /* =====================================
       FILTER VALIDATION
       ===================================== */

    $("#filterForm").submit(function (event) {

        let fromDate = $("#due_date_from").val();

        let toDate = $("#due_date_to").val();


        // Clear previous error
        $("#filterError").text("");

        $("#due_date_from").removeClass("input-error");
        $("#due_date_to").removeClass("input-error");


        /*
         * Check date range
         *
         * From date cannot be
         * later than To date.
         */

        if (
            fromDate !== "" &&
            toDate !== "" &&
            fromDate > toDate
        ) {

            event.preventDefault();


            $("#filterError").text(
                "From date cannot be later than To date."
            );


            $("#due_date_from").addClass("input-error");

            $("#due_date_to").addClass("input-error");

        }

    });


    /* =====================================
       FILTER DATE ERROR CLEAR
       ===================================== */

    $("#due_date_from, #due_date_to").change(function () {

        $("#filterError").text("");

        $("#due_date_from").removeClass("input-error");

        $("#due_date_to").removeClass("input-error");

    });
    $(document).ready(function () {
    loadFees();
});
function loadFees() {

    $.ajax({

        url: "api/get_fees.php",

        type: "GET",

        dataType: "json",

        success: function (fees) {

            let rows = "";

            if (fees.length === 0) {

                rows = `
                    <tr>
                        <td colspan="7" style="text-align:center;">
                            No fee records found.
                        </td>
                    </tr>
                `;

            } else {

                $.each(fees, function (index, fee) {

                    let statusClass = "";

                    if (fee.status === "paid") {
                        statusClass = "status-paid";
                    } else {
                        statusClass = "status-pending";
                    }

                    let paidDate = fee.paid_date
                        ? fee.paid_date
                        : "-";

                    rows += `
                        <tr>

                            <td>${fee.fee_id}</td>

                            <td>${fee.name}</td>

                            <td>₹${fee.amount}</td>

                            <td>${paidDate}</td>

                            <td>${fee.due_date}</td>

                            <td>
                                <span class="status ${statusClass}">
                                    ${fee.status}
                                </span>
                            </td>

                            <td>

                                <a
                                    href="view_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-info">
                                    View
                                </a>

                                <a
                                    href="edit_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-warning">
                                    Edit
                                </a>

                                <a
                                    href="delete_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-danger">
                                    Delete
                                </a>

                            </td>

                        </tr>
                    `;

                });

            }

            $("#feeTableBody").html(rows);

        },

        error: function () {

            $("#feeTableBody").html(`
                <tr>
                    <td colspan="7" style="text-align:center;">
                        Unable to load fee records.
                    </td>
                </tr>
            `);

        }

    });

}