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


                <tbody id="feeTableBody">
                </tbody>

            </table>

        </div>

    </div>


</div>




<script src="../assets/js/fee_list.js"></script>


</body>
</html>