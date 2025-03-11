<?php
require_once '../app/models/Database.php'; // Corrected path to Database.php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $conn = Database::getConnection(); // Get the database connection

        // Check if record exists before deleting
        $check_sql = "SELECT * FROM personal_info WHERE id = :id";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $check_stmt->execute();
        $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $sql = "DELETE FROM personal_info WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: ../public/submit.php?success=deleted");
                exit();
            } else {
                echo "<h3 style='color:red; text-align:center;'>Error deleting record.</h3>";
            }
        } else {
            echo "<h3 style='color:red; text-align:center;'>Record not found!</h3>";
        }
    } catch (PDOException $e) {
        die("<h3 style='color:red; text-align:center;'>Failed to delete record: " . $e->getMessage() . "</h3>");
    }
} else {
    echo "<h3 style='color:red; text-align:center;'>Invalid request!</h3>";
}
?>