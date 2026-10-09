
<?php
require_once "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Fee</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container">

    <div class="page-header">
        <div>
            <h1>Add Fee</h1>
            <p>Create a new student fee record</p>
        </div>

        <a href="fee_list.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">

        <form id="feeForm" novalidate>

            <div class="form-grid">

                <!-- Student -->
                <div class="form-group">
                    <label for="student">Student *</label>

                    <select id="student" name="user_id">
                        <option value="">Select Student</option>
                    </select>

                    <small class="error-message" id="studentError"></small>
                </div>

                <!-- Amount -->
                <div class="form-group">
                    <label for="amount">Amount *</label>

                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        placeholder="Enter fee amount"
                        min="0.01"
                        step="0.01"
                    >

                    <small class="error-message" id="amountError"></small>
                </div>

                <!-- Paid Date -->
                <div class="form-group">
                    <label for="paid_date">Paid Date</label>

                    <input
                        type="date"
                        id="paid_date"
                        name="paid_date"
                    >

                    <small class="error-message" id="paidDateError"></small>
                </div>

                <!-- Due Date -->
                <div class="form-group">
                    <label for="due_date">Due Date *</label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                    >

                    <small class="error-message" id="dueDateError"></small>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status *</label>

                    <select id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                    </select>

                    <small class="error-message" id="statusError"></small>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Save Fee
                </button>

                <a href="fee_list.php" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Page-specific JavaScript: validation and AJAX -->
<script src="../assets/js/add_fee.js"></script>

</body>
</html>
