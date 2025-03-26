<?php
require_once '../app/models/Database.php'; 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $conn = Database::getConnection(); 
    $sql = "SELECT * FROM personal_info WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<h3 style='color:red; text-align:center;'>Record not found!</h3>";
        exit();
    }
} catch (PDOException $e) {
    die("<h3 style='color:red; text-align:center;'>Failed to fetch record: " . $e->getMessage() . "</h3>");
}

function calculate_age($dob) {
    $dob_date = new DateTime($dob);
    $today = new DateTime();
    return $today->diff($dob_date)->y;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Personal Info</title>
    <link rel="stylesheet" href="css/view.css">
</head>
<body>
    <div class="view-container">
        <h2>View Personal Info</h2>
        <div class="info-group">
            <label>ID:</label>
            <span><?= htmlspecialchars($user['id']) ?></span>
        </div>
        <div class="info-group">
            <label>Full Name:</label>
            <span><?= htmlspecialchars($user['last_name'] . "," . $user['first_name'] . " " . $user['middle_name']) ?></span>
        </div>
        <div class="info-group">
            <label>Date of Birth:</label>
            <span><?= htmlspecialchars($user['dob']) ?></span>
        </div>
        <div class="info-group">
            <label>Age:</label>
            <span><?= calculate_age($user['dob']) ?></span>
        </div>
        <div class="info-group">
            <label>Sex:</label>
            <span><?= htmlspecialchars($user['sex']) ?></span>
        </div>
        <div class="info-group">
            <label>Civil Status:</label>
            <span><?= htmlspecialchars($user['civil_status']) ?></span>
        </div>
        <div class="info-group">
            <label>Nationality:</label>
            <span><?= htmlspecialchars($user['nationality']) ?></span>
        </div>
        <div class="info-group">
            <label>Place of Birth:</label>
            <span><?= htmlspecialchars($user['birth_street'] . ", " . $user['birth_city'] . ", " . $user['birth_province'] . ", " . $user['birth_country'] . ", " . $user['birth_zip_code']) ?></span>
        </div>
        <div class="info-group">
            <label>Home Address:</label>
            <span><?= htmlspecialchars($user['home_street'] . ", " . $user['home_city'] . ", " . $user['home_province'] . ", " . $user['home_country'] . ", " . $user['home_zip_code']) ?></span>
        </div>
        <div class="info-group">
            <label>Mobile:</label>
            <span><?= htmlspecialchars($user['mobile']) ?></span>
        </div>
        <div class="info-group">
            <label>Email:</label>
            <span><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="info-group">
            <label>Father's Name:</label>
            <span><?= htmlspecialchars($user['father_first_name'] . " " . $user['father_middle_name'] . " " . $user['father_last_name']) ?></span>
        </div>
        <div class="info-group">
            <label>Mother's Name:</label>
            <span><?= htmlspecialchars($user['mother_first_name'] . " " . $user['mother_middle_name'] . " " . $user['mother_last_name']) ?></span>
        </div>
        <br>
        <a href="../public/submit.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>

<?php 
$conn = null;
?>