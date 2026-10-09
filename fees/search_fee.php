
<?php

require_once "../classes/Fee.php";

$feeObject = new Fee($conn);

// Search inputs
$search_by = $_GET['search_by'] ?? '';
$search_value = trim($_GET['search_value'] ?? '');

// Filter inputs
$filter_status = $_GET['filter_status'] ?? '';
$due_date_from = $_GET['due_date_from'] ?? '';
$due_date_to = $_GET['due_date_to'] ?? '';

$error = '';
$fees = [];

/* VALIDATE SEARCH TYPE */

if (!in_array($search_by, ['', 'student', 'fee_id'], true)) {
    $error = "Invalid search option.";
}

/* VALIDATE STATUS */

if (
    $error === '' &&
    !in_array($filter_status, ['', 'pending', 'paid'], true)
) {
    $error = "Invalid payment status.";
}

/* VALIDATE DATES */

foreach (
    [
        'Due Date From' => $due_date_from,
        'Due Date To' => $due_date_to
    ] as $label => $date
) {
    if ($date === '') {
        continue;
    }

    $parsedDate = DateTime::createFromFormat('!Y-m-d', $date);

    if (
        !$parsedDate ||
        $parsedDate->format('Y-m-d') !== $date
    ) {
        $error = "Invalid " . $label . ".";
        break;
    }
}

/* VALIDATE DATE RANGE */

if (
    $error === '' &&
    $due_date_from !== '' &&
    $due_date_to !== '' &&
    $due_date_from > $due_date_to
) {
    $error = "Due Date From cannot be later than Due Date To.";
}

/* VALIDATE SEARCH VALUE */

if (
    $error === '' &&
    $search_by !== '' &&
    $search_value === ''
) {
    $error = "Please enter a search value.";
}

/* RUN SEARCH OR FILTER */

$hasSearch = $search_by !== '' && $search_value !== '';

$hasFilter =
    $filter_status !== '' ||
    $due_date_from !== '' ||
    $due_date_to !== '';

if ($error === '' && ($hasSearch || $hasFilter)) {

    $fees = $feeObject->searchFees(
        $search_by,
        $search_value,
        $filter_status,
        $due_date_from,
        $due_date_to
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Results</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container">

    <div class="page-header">
        <div>
            <h1>Search Results</h1>
            <p>Search and filter fee records</p>
        </div>

        <a href="fee_list.php" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card">

        <h2 style="margin-bottom: 20px;">Fee Records</h2>

        <?php if ($error !== ''): ?>

            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php elseif (!$hasSearch && !$hasFilter): ?>

            <div class="empty-state">
                <h3>Enter search criteria or select a filter.</h3>
            </div>

        <?php elseif (empty($fees)): ?>

            <div class="empty-state">
                <h3>No fee records found.</h3>
            </div>

        <?php else: ?>

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
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($fees as $fee): ?>

                        <tr>
                            <td>
                                <?php echo (int)$fee['fee_id']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($fee['name']); ?>
                            </td>

                            <td>
                                ₹<?php echo number_format((float)$fee['amount'], 2); ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($fee['paid_date'])
                                    ? date("d-m-Y", strtotime($fee['paid_date']))
                                    : "-";
                                ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($fee['due_date'])
                                    ? date("d-m-Y", strtotime($fee['due_date']))
                                    : "-";
                                ?>
                            </td>

                            <td>
                                <?php if ($fee['status'] === 'paid'): ?>
                                    <span class="status status-paid">Paid</span>
                                <?php else: ?>
                                    <span class="status status-pending">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
