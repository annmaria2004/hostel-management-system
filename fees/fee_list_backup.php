<?php
require_once "../config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees & Payments</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<div class="container">

    <!-- Page Header -->
    <div class="page-header">

        <div>
            <h1>Fees & Payments</h1>
            <p>Manage student fees and payment records</p>
        </div>

        <div>
            <a href="add_fee.php" class="btn btn-primary">
                + Add Fee
            </a>

            <a href="import_fees.php" class="btn btn-success">
                Import Fees
            </a>
        </div>

    </div>


    <!-- ========================= -->
    <!-- SEARCH SECTION -->
    <!-- ========================= -->

    <div class="card">

        <h2>Search Fees</h2>

        <form action="search_fee.php" method="GET" id="searchForm">

            <div class="search-box">

                <!-- Search By -->
                <div class="form-group">

                    <label for="search_by">
                        Search By
                    </label>

                    <select name="search_by" id="search_by">

                        <option value="student">
                            Student Name
                        </option>

                        <option value="fee_id">
                            Fee ID
                        </option>

                    </select>

                </div>


                <!-- Search Value -->
                <div class="form-group">

                    <label for="search_value">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search_value"
                        name="search_value"
                        placeholder="Enter student name"
                    >

                    <small
                        id="searchError"
                        class="error-message">
                    </small>

                </div>


                <!-- Search Button -->
                <div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Search

                    </button>

                    <a
                        href="fee_list.php"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>


    <!-- ========================= -->
    <!-- FILTER SECTION -->
    <!-- ========================= -->

    <div class="card">

        <h2>Filter Fees</h2>

        <form action="search_fee.php" method="GET" id="filterForm">

            <div class="search-box">


                <!-- Payment Status -->
                <div class="form-group">

                    <label for="filter_status">
                        Payment Status
                    </label>

                    <select
                        name="filter_status"
                        id="filter_status">

                        <option value="">
                            All
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="paid">
                            Paid
                        </option>

                    </select>

                </div>


                <!-- Due Date From -->
                <div class="form-group">

                    <label for="due_date_from">
                        Due Date From
                    </label>

                    <input
                        type="date"
                        id="due_date_from"
                        name="due_date_from">

                </div>


                <!-- Due Date To -->
                <div class="form-group">

                    <label for="due_date_to">
                        Due Date To
                    </label>

                    <input
                        type="date"
                        id="due_date_to"
                        name="due_date_to">

                </div>


                <!-- Filter Buttons -->
                <div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Apply Filter

                    </button>

                    <a
                        href="fee_list.php"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

            <!-- Filter Error -->
            <small
                id="filterError"
                class="error-message">
            </small>

        </form>

    </div>


    <!-- ========================= -->
    <!-- FEE RECORDS -->
    <!-- ========================= -->

    <div class="card">

        <div class="page-header">

            <div>
                <h2>Fee Records</h2>
            </div>

            <div>

                <a
                    href="../reports/fees/fee_csv.php"
                    class="btn btn-success">

                    Export CSV

                </a>

                <a
                    href="../reports/fees/fee_pdf.php"
                    class="btn btn-danger">

                    Export PDF

                </a>

            </div>

        </div>


        <!-- Fee Table -->
        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Fee ID</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Paid Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>


                <<tbody id="feeTableBody">
                </tbody>

            </table>

        </div>

    </div>


</div>


<!-- ========================= -->
<!-- JQUERY VALIDATION -->
<!-- ========================= -->

<script>

$(document).ready(function () {


        loadFees();
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
                .attr("type", "number")
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

</script>

</body>
</html>