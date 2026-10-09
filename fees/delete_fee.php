
<?php

require_once "../classes/Fee.php";

$fee_id = $_GET['id'] ?? $_POST['fee_id'] ?? '';

if (
    $fee_id === '' ||
    !ctype_digit((string)$fee_id) ||
    (int)$fee_id <= 0
) {
    die("Invalid Fee ID.");
}

$fee_id = (int)$fee_id;

// Create Fee object
$feeObject = new Fee($conn);


/* -------------------------------
   DELETE FEE
-------------------------------- */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $success = $feeObject->deleteFee($fee_id);

    if ($success) {
        header("Location: fee_list.php");
        exit;
    }

    die("Unable to delete fee record.");
}


/* -------------------------------
   GET FEE DETAILS
-------------------------------- */

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

    <title>Delete Fee</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <div class="page-header">

        <div>
            <h1>Delete Fee</h1>
            <p>Confirm deletion of the fee record</p>
        </div>

    </div>

    <div class="card">

        <div class="alert alert-danger">

            <strong>Are you sure?</strong>

            <p style="margin-top: 8px;">
                You are about to delete this fee record.
            </p>

        </div>

        <table class="details-table">

            <tr>
                <td>Fee ID</td>
                <td>
                    <?php echo (int)$fee['fee_id']; ?>
                </td>
            </tr>

            <tr>
                <td>Student</td>
                <td>
                    <?php echo htmlspecialchars($fee['name']); ?>
                </td>
            </tr>

            <tr>
                <td>Amount</td>
                <td>
                    ₹<?php echo number_format((float)$fee['amount'], 2); ?>
                </td>
            </tr>

            <tr>
                <td>Due Date</td>
                <td>
                    <?php
                    echo $fee['due_date']
                        ? date("d-m-Y", strtotime($fee['due_date']))
                        : "-";
                    ?>
                </td>
            </tr>

        </table>

        <div class="form-actions">

            <form
                action="delete_fee.php?id=<?php echo (int)$fee['fee_id']; ?>"
                method="POST">

                <input
                    type="hidden"
                    name="fee_id"
                    value="<?php echo (int)$fee['fee_id']; ?>">

                <button type="submit" class="btn btn-danger">
                    Yes, Delete
                </button>

            </form>

            <a href="fee_list.php" class="btn btn-secondary">
                Cancel
            </a>

        </div>

    </div>

</div>

</body>
</html>
