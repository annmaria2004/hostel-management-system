
<?php

require_once __DIR__ . "/../config/db.php";

class Fee
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all fee records
    public function getAllFees()
    {
        $sql = "SELECT
                    fees.fee_id,
                    users.name,
                    fees.amount,
                    fees.paid_date,
                    fees.due_date,
                    fees.status
                FROM fees
                INNER JOIN users
                    ON fees.user_id = users.user_id
                ORDER BY fees.fee_id ASC";

        $result = $this->conn->query($sql);

        $fees = $result->fetchAll(PDO::FETCH_ASSOC);

        return $fees;
    }

    // Add a new fee record
    public function addFee(
        $user_id,
        $amount,
        $paid_date,
        $due_date,
        $status
    ) {
        $paid_date_value = ($paid_date === '')
            ? NULL
            : $paid_date;

        $stmt = $this->conn->prepare("
            INSERT INTO fees
            (
                user_id,
                amount,
                paid_date,
                due_date,
                status
            )
            VALUES (:user_id, :amount, :paid_date, :due_date,:status)
        ");

        if (!$stmt) {
            return false;
        }

        
        $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
        $stmt->bindParam(":amount",$amount,PDO::PARAM_STR);
        if ($paid_date_value === null) {
            $stmt->bindValue(":paid_date", null, PDO::PARAM_NULL);
            } else {
                 $stmt->bindParam(":paid_date", $paid_date_value, PDO::PARAM_STR);
            }
        $stmt->bindParam(":due_date",$due_date,PDO::PARAM_STR);
        $stmt->bindParam(":status",$status,PDO::PARAM_STR);

        $success = $stmt->execute();

        return $success;
    }
    
    // Get all active students
    public function getActiveStudents()
    {
        $sql = "SELECT
                    user_id,
                    name
                FROM users
                WHERE user_type = 'student'
                AND status = 'active'
                ORDER BY name ASC";

        $result = $this->conn->query($sql);
        

        $students = $result->fetchAll(PDO::FETCH_ASSOC);

        return $students;
    }
    
public function getFeeById($fee_id)
{
    $sql = "SELECT
                fees.fee_id,
                users.name,
                fees.amount,
                fees.paid_date,
                fees.due_date,
                fees.status
            FROM fees
            INNER JOIN users
                ON fees.user_id = users.user_id
            WHERE fees.fee_id = :fee_id";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        return null;
    }

    $stmt->bindParam(":fee_id", $fee_id,PDO::PARAM_INT);

    $stmt->execute();
    $fee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fee ?: null;
}

    // Get fee details for editing
    public function getFeeForEdit($fee_id)
    {
        $sql = "SELECT
                    fee_id,
                    user_id,
                    amount,
                    paid_date,
                    due_date,
                    status
                FROM fees
                WHERE fee_id = :fee_id";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bindParam(":fee_id",$fee_id,PDO::PARAM_INT);

        $stmt->execute();

        $fee = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fee ?: null;
    }

    // Update an existing fee
    public function updateFee(
        $fee_id,
        $user_id,
        $amount,
        $paid_date,
        $due_date,
        $status
    ) {
        $paid_date_value = ($paid_date === '')
            ? NULL
            : $paid_date;

        $stmt = $this->conn->prepare("
            UPDATE fees
            SET user_id = :user_id,
                amount = :amount,
                paid_date = :paid_date,
                due_date = :due_date,
                status = :status
            WHERE fee_id = :fee_id
        ");

        if (!$stmt) {
            return false;
        }

        $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
        $stmt->bindParam(":amount",$amount,PDO::PARAM_STR);
         
        if ($paid_date_value === null) {
            $stmt->bindValue(":paid_date", null, PDO::PARAM_NULL);
            } else {
                 $stmt->bindParam(":paid_date", $paid_date_value, PDO::PARAM_STR);
            }


        $stmt->bindParam(":due_date",$due_date,PDO::PARAM_STR);
        $stmt->bindParam(":status",$status,PDO::PARAM_STR);
        $stmt->bindParam(":fee_id",$fee_id,PDO::PARAM_INT);

        
        $success = $stmt->execute();
        return $success;
    }


    public function deleteFee($fee_id)
{
    $stmt = $this->conn->prepare(
        "DELETE FROM fees WHERE fee_id = :fee_id"
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bindParam(":fee_id", $fee_id,PDO::PARAM_INT);

    $success = $stmt->execute();

    

    return $success;
}


public function searchFees(
    $search_by,
    $search_value,
    $filter_status,
    $due_date_from,
    $due_date_to
) {
    $sql = "SELECT
                fees.fee_id,
                users.name,
                fees.amount,
                fees.paid_date,
                fees.due_date,
                fees.status
            FROM fees
            INNER JOIN users
                ON fees.user_id = users.user_id
            WHERE
                (
                    :search_by_empty = ''
                    OR (
                        :search_by_student = 'student'
                        AND users.name LIKE :student_name
                    )
                    OR (
                        :search_by_id = 'fee_id'
                        AND CAST(fees.fee_id AS CHAR)
                            LIKE :fee_id
                    )
                )
                AND (:status_empty = '' OR fees.status = :status_value)
                AND (:from_empty = '' OR fees.due_date >= :from_date)
                AND (:to_empty = '' OR fees.due_date <= :to_date)
            ORDER BY fees.fee_id ASC";

    $stmt = $this->conn->prepare($sql);

    // Prepare search patterns
    $student_name = "%" . $search_value . "%";
    $fee_id_value = "%" . $search_value . "%";

    // Bind search parameters
    $stmt->bindParam(
        ":search_by_empty",
        $search_by,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":search_by_student",
        $search_by,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":student_name",
        $student_name,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":search_by_id",
        $search_by,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":fee_id",
        $fee_id_value,
        PDO::PARAM_STR
    );

    // Bind status filter
    $stmt->bindParam(
        ":status_empty",
        $filter_status,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":status_value",
        $filter_status,
        PDO::PARAM_STR
    );

    // Bind start date filter
    $stmt->bindParam(
        ":from_empty",
        $due_date_from,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":from_date",
        $due_date_from,
        PDO::PARAM_STR
    );

    // Bind end date filter
    $stmt->bindParam(
        ":to_empty",
        $due_date_to,
        PDO::PARAM_STR
    );

    $stmt->bindParam(
        ":to_date",
        $due_date_to,
        PDO::PARAM_STR
    );

    // Execute the query
    $stmt->execute();

    // Fetch all matching fee records
    $fees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $fees;
}

}

?>
