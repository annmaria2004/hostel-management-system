
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

$feeObject = new Fee($conn);
$error = "";

/* UPDATE FEE */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_POST['user_id'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $paid_date = $_POST['paid_date'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $status = $_POST['status'] ?? '';

    if (
        $user_id === '' ||
        !ctype_digit((string)$user_id) ||
        (int)$user_id <= 0 ||
        $amount === '' ||
        !is_numeric($amount) ||
        (float)$amount < 0 ||
        $due_date === '' ||
        !in_array($status, ['pending', 'paid'], true)
    ) {
        $error = "Please enter valid fee details.";
    } elseif (
        $paid_date !== '' &&
        $due_date < $paid_date
    ) {
        $error = "Due Date cannot be earlier than Paid Date.";
    } else {

        $success = $feeObject->updateFee(
            $fee_id,
            (int)$user_id,
            (float)$amount,
            $paid_date,
            $due_date,
            $status
        );

        if ($success) {
            header("Location: view_fee.php?id=" . $fee_id);
            exit;
        }

        $error = "Unable to update fee record.";
    }
}

/* GET FEE DETAILS */

$fee = $feeObject->getFeeForEdit($fee_id);

if ($fee === null) {
    die("Fee record not found.");
}

/* GET STUDENTS */

$students = $feeObject->getActiveStudents();

$currentStudentExists = false;

foreach ($students as $student) {
    if (
        (string)$student['user_id'] ===
        (string)$fee['user_id']
    ) {
        $currentStudentExists = true;
        break;
    }
}

/* Include the currently assigned student if inactive */

if (!$currentStudentExists) {

    $stmt = $conn->prepare(
        "SELECT user_id, name FROM users WHERE user_id = ?"
    );

    if ($stmt) {
        $stmt->bind_param("i", $fee['user_id']);
        $stmt->execute();

        $result = $stmt->get_result();
        $currentStudent = $result->fetch_assoc();

        if ($currentStudent) {
            array_unshift($students, $currentStudent);
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Fee</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container">

    <div class="page-header">
        <div>
            <h1>Edit Fee</h1>
            <p>Update the fee and payment details</p>
        </div>

        <a href="fee_list.php" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card">

        <?php if ($error !== ''): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form
            id="editFeeForm"
            method="POST"
            action="edit_fee.php?id=<?php echo $fee_id; ?>"
        >

            <input
                type="hidden"
                name="fee_id"
                value="<?php echo (int)$fee['fee_id']; ?>"
            >

            <div class="form-grid">

                <!-- Student -->

                <div class="form-group">
                    <label>Student *</label>

                    <select name="user_id" required>
                        <option value="">Select Student</option>

                        <?php foreach ($students as $student): ?>
                            <option
                                value="<?php echo (int)$student['user_id']; ?>"
                                <?php
                                echo (
                                    (string)$student['user_id'] ===
                                    (string)$fee['user_id']
                                ) ? 'selected' : '';
                                ?>
                            >
                                <?php echo htmlspecialchars($student['name']); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Amount -->

                <div class="form-group">
                    <label>Amount *</label>

                    <input
                        type="number"
                        name="amount"
                        value="<?php echo htmlspecialchars((string)$fee['amount']); ?>"
                        min="0"
                        step="0.01"
                        required
                    >
                </div>

                <!-- Paid Date -->

                <div class="form-group">
                    <label>Paid Date</label>

                    <input
                        type="date"
                        name="paid_date"
                        id="paid_date"
                        value="<?php echo htmlspecialchars($fee['paid_date'] ?? ''); ?>"
                    >
                </div>

                <!-- Due Date -->

                <div class="form-group">
                    <label>Due Date *</label>

                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        value="<?php echo htmlspecialchars($fee['due_date'] ?? ''); ?>"
                        required
                    >
                </div>

                <!-- Status -->

                <div class="form-group">
                    <label>Status *</label>

                    <select name="status" required>
                        <option
                            value="pending"
                            <?php echo ($fee['status'] === 'pending') ? 'selected' : ''; ?>
                        >
                            Pending
                        </option>

                        <option
                            value="paid"
                            <?php echo ($fee['status'] === 'paid') ? 'selected' : ''; ?>
                        >
                            Paid
                        </option>
                    </select>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Update Fee
                </button>

                <a href="fee_list.php" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

<script src="../assets/js/edit_fee.js"></script>

</body>
</html>
