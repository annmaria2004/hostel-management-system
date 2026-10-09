
<?php

require_once "../../classes/Fee.php";

header("Content-Type: application/json");

// Create Fee object
$fee = new Fee($conn);

// Get active students using class method
$students = $fee->getActiveStudents();

// Return JSON response
echo json_encode($students);

?>
