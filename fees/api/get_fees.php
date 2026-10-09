
<?php

require_once "../../classes/Fee.php";

header("Content-Type: application/json");

$fee = new Fee($conn);

$fees = $fee->getAllFees();

echo json_encode($fees);

?>
