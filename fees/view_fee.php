<?php

require_once "../classes/Fee.php";

$fee_id = $_GET['id'] ?? '';

if ($fee_id === '' || !ctype_digit($fee_id) || (int)$fee_id <= 0) {
    die("Invalid Fee ID.");
}

$fee_id = (int)$fee_id;

// Create Fee object
$feeObject = new Fee($conn);

// Retrieve fee details using the class method
$fee = $feeObject->getFeeById($fee_id);

if ($fee === null) {
    die("Fee record not found.");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>View Fee</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <div class="page-header">

        <div>
            <h1>Fee Details</h1>
            <p>View complete fee and payment information</p>
        </div>

        <a href="fee_list.php"
           class="btn btn-secondary">

            Back

        </a>

    </div>


    <div class="card">

        <table class="details-table">

            <tr>
                <td>Fee ID</td>
                <td><?php echo $fee['fee_id']; ?></td>
            </tr>

            <tr>
                <td>Student</td>
                <td><?php echo htmlspecialchars($fee['name']); ?></td>
            </tr>

            <tr>
                <td>Amount</td>
                <td>₹<?php echo number_format($fee['amount'], 2); ?></td>
            </tr>

            <tr>
                <td>Paid Date</td>
                <td>
                    <?php
                    echo $fee['paid_date']
                        ? date("d-m-Y", strtotime($fee['paid_date']))
                        : "-";
                    ?>
                </td>
            </tr>

            <tr>
                <td>Due Date</td>
                <td>
                    <?php
                    echo date("d-m-Y", strtotime($fee['due_date']));
                    ?>
                </td>
            </tr>

            <tr>
                <td>Status</td>

                <td>

                    <?php if ($fee['status'] === 'paid'): ?>

                        <span class="status status-paid">
                            Paid
                        </span>

                    <?php else: ?>

                        <span class="status status-pending">
                            Pending
                        </span>

                    <?php endif; ?>

                </td>

            </tr>

        </table>


        <div class="form-actions">

            <a href="edit_fee.php?id=<?php echo $fee['fee_id']; ?>"
   class="btn btn-warning">
    Edit
</a>

            <a href="delete_fee.php?id=<?php echo $fee['fee_id']; ?>"
               class="btn btn-danger">

                Delete

            </a>

            <a href="fee_list.php"
               class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

</div>

</body>

</html>