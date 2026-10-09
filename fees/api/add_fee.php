
<?php

require_once "../../classes/Fee.php";

header("Content-Type: application/json");

// Receive form data
$user_id = $_POST['user_id'] ?? '';
$amount = $_POST['amount'] ?? '';
$paid_date = $_POST['paid_date'] ?? '';
$due_date = $_POST['due_date'] ?? '';
$status = $_POST['status'] ?? '';

// Validate required fields
if (
    $user_id === '' ||
    $amount === '' ||
    $due_date === '' ||
    $status === ''
) {
    echo json_encode([
        "success" => false,
        "message" => "Please fill all required fields."
    ]);
    exit;
}

// Create Fee object
$fee = new Fee($conn);

// Call the class method
$success = $fee->addFee(
    $user_id,
    $amount,
    $paid_date,
    $due_date,
    $status
);

// Return JSON response
if ($success) {
    echo json_encode([
        "success" => true,
        "message" => "Fee added successfully."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Unable to add fee."
    ]);
}

?>
