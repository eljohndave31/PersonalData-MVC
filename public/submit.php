<?php
require_once '../app/models/Database.php'; // Corrected path


// Fetch all records
try {
    $conn = Database::getConnection(); // Get the database connection
    $sql = "SELECT * FROM personal_info ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<h3 style='color:red; text-align:center;'>Failed to fetch records: " . $e->getMessage() . "</h3>");
}

// Function to calculate age
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
    <title>Form Submission</title>
    <link rel="stylesheet" href="../public/submit.css"> <!-- Corrected path to submit.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <?php if ($_GET['success'] == 'submitted'): ?>
        <h2 style="color: green;">Submitted Successfully!</h2>
    <?php elseif ($_GET['success'] == 'updated'): ?>
        <h2 style="color: green;">Updated Successfully!</h2>
    <?php elseif ($_GET['success'] == 'deleted'): ?>
        <h2 style="color: green;">Deleted Successfully!</h2>
    <?php endif; ?>
<?php endif; ?>

<div class="table-container">
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Civil Status</th>
            <th>Nationality</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php if (!empty($result)): ?>
            <?php foreach ($result as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['last_name'] . "," .  $user['first_name'] . " " . $user['middle_name']) ?></td>
                <td><?= calculate_age($user['dob']) ?></td>
                <td><?= htmlspecialchars($user['sex']) ?></td>
                <td><?= htmlspecialchars($user['civil_status']) ?></td>
                <td><?= htmlspecialchars($user['nationality']) ?></td>
                <td><?= htmlspecialchars($user['mobile']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td class="action-buttons">
                    <a href="../views/view.php?id=<?= $user['id'] ?>" class="view"><i class="fas fa-eye"></i> View</a> | 
                    <a href="../views/edit.php?id=<?= $user['id'] ?>" class="edit"><i class="fas fa-edit"></i> Edit</a> | 
                    <a href="../views/delete.php?id=<?= $user['id'] ?>" class="delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i> Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<br><br>
<a href="../public/index.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Add More</a> <!-- Corrected path to index.php -->

</body>
</html>

<?php 
$conn = null;
?>