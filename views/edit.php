<?php
require_once '../app/models/Database.php'; // Corrected path to Database.php

// Get the user ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $conn = Database::getConnection(); // Get the database connection
    $sql = "SELECT * FROM personal_info WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<h3 style='color:red; text-align:center; font-family: Arial, sans-serif;'>Record not found!</h3>";
        exit();
    }
} catch (PDOException $e) {
    die("<h3 style='color:red; text-align:center;'>Failed to fetch record: " . $e->getMessage() . "</h3>");
}

// Update the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $civil_status = $_POST['civil_status'];
    $tin = $_POST['tin'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $birth_street = $_POST['birth_street'];
    $birth_city = $_POST['birth_city'];
    $birth_province = $_POST['birth_province'];
    $birth_country = $_POST['birth_country'];
    $birth_zip_code = $_POST['birth_zip_code'];
    $home_street = $_POST['home_street'];
    $home_city = $_POST['home_city'];
    $home_province = $_POST['home_province'];
    $home_country = $_POST['home_country'];
    $home_zip_code = $_POST['home_zip_code'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $father_last_name = $_POST['father_last_name'];
    $father_first_name = $_POST['father_first_name'];
    $father_middle_name = $_POST['father_middle_name'];
    $mother_last_name = $_POST['mother_last_name'];
    $mother_first_name = $_POST['mother_first_name'];
    $mother_middle_name = $_POST['mother_middle_name'];

    try {
        $update_sql = "UPDATE personal_info SET last_name=:last_name, first_name=:first_name, middle_name=:middle_name, dob=:dob, sex=:sex, civil_status=:civil_status, tin=:tin, nationality=:nationality, religion=:religion, 
                       birth_street=:birth_street, birth_city=:birth_city, birth_province=:birth_province, birth_country=:birth_country, birth_zip_code=:birth_zip_code, home_street=:home_street, home_city=:home_city, home_province=:home_province, 
                       home_country=:home_country, home_zip_code=:home_zip_code, mobile=:mobile, email=:email, telephone=:telephone, father_last_name=:father_last_name, father_first_name=:father_first_name, father_middle_name=:father_middle_name, 
                       mother_last_name=:mother_last_name, mother_first_name=:mother_first_name, mother_middle_name=:mother_middle_name WHERE id=:id";
        $stmt = $conn->prepare($update_sql);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':middle_name', $middle_name);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':civil_status', $civil_status);
        $stmt->bindParam(':tin', $tin);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':religion', $religion);
        $stmt->bindParam(':birth_street', $birth_street);
        $stmt->bindParam(':birth_city', $birth_city);
        $stmt->bindParam(':birth_province', $birth_province);
        $stmt->bindParam(':birth_country', $birth_country);
        $stmt->bindParam(':birth_zip_code', $birth_zip_code);
        $stmt->bindParam(':home_street', $home_street);
        $stmt->bindParam(':home_city', $home_city);
        $stmt->bindParam(':home_province', $home_province);
        $stmt->bindParam(':home_country', $home_country);
        $stmt->bindParam(':home_zip_code', $home_zip_code);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':father_last_name', $father_last_name);
        $stmt->bindParam(':father_first_name', $father_first_name);
        $stmt->bindParam(':father_middle_name', $father_middle_name);
        $stmt->bindParam(':mother_last_name', $mother_last_name);
        $stmt->bindParam(':mother_first_name', $mother_first_name);
        $stmt->bindParam(':mother_middle_name', $mother_middle_name);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../public/submit.php?success=updated");
            exit();
        } else {
            echo "<h3 style='color:red; text-align:center;'>Error updating record.</h3>";
        }
    } catch (PDOException $e) {
        die("<h3 style='color:red; text-align:center;'>Failed to update record: " . $e->getMessage() . "</h3>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personal Info</title>
    <link rel="stylesheet" href="../public/edit.css"> <!-- Corrected path to edit.css -->
</head>
<body>

<div class="edit-container">
    <h2>Edit Here</h2>
    <form method="POST">
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

        <label>Middle Name:</label>
        <input type="text" name="middle_name" value="<?= htmlspecialchars($user['middle_name']) ?>" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>" required>

        <label>Sex:</label>
        <select name="sex" required>
            <option value="Male" <?= $user['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $user['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>

        <label>Civil Status:</label>
        <select name="civil_status" required>
            <option value="single" <?= $user['civil_status'] == 'single' ? 'selected' : '' ?>>Single</option>
            <option value="married" <?= $user['civil_status'] == 'married' ? 'selected' : '' ?>>Married</option>
            <option value="widowed" <?= $user['civil_status'] == 'widowed' ? 'selected' : '' ?>>Widowed</option>
            <option value="legally_separated" <?= $user['civil_status'] == 'legally_separated' ? 'selected' : '' ?>>Legally Separated</option>
            <option value="others" <?= $user['civil_status'] == 'others' ? 'selected' : '' ?>>Others</option>
        </select>

        <label>Tax Identification Number:</label>
        <input type="text" name="tin" value="<?= htmlspecialchars($user['tin']) ?>">

        <label>Nationality:</label>
        <input type="text" name="nationality" value="<?= htmlspecialchars($user['nationality']) ?>" required>

        <label>Religion:</label>
        <input type="text" name="religion" value="<?= htmlspecialchars($user['religion']) ?>">

        <h3>Place of Birth</h3>
        <label>Street Name:</label>
        <input type="text" name="birth_street" value="<?= htmlspecialchars($user['birth_street']) ?>" required>

        <label>City/Municipality:</label>
        <input type="text" name="birth_city" value="<?= htmlspecialchars($user['birth_city']) ?>" required>

        <label>Province:</label>
        <input type="text" name="birth_province" value="<?= htmlspecialchars($user['birth_province']) ?>">

        <label>Country:</label>
        <input type="text" name="birth_country" value="<?= htmlspecialchars($user['birth_country']) ?>" required>

        <label>Zip Code:</label>
        <input type="text" name="birth_zip_code" value="<?= htmlspecialchars($user['birth_zip_code']) ?>">

        <h3>Home Address</h3>
        <label>Street Name:</label>
        <input type="text" name="home_street" value="<?= htmlspecialchars($user['home_street']) ?>" required>

        <label>City/Municipality:</label>
        <input type="text" name="home_city" value="<?= htmlspecialchars($user['home_city']) ?>" required>

        <label>Province:</label>
        <input type="text" name="home_province" value="<?= htmlspecialchars($user['home_province']) ?>">

        <label>Country:</label>
        <input type="text" name="home_country" value="<?= htmlspecialchars($user['home_country']) ?>" required>

        <label>Zip Code:</label>
        <input type="text" name="home_zip_code" value="<?= htmlspecialchars($user['home_zip_code']) ?>" required>

        <label>Mobile:</label>
        <input type="text" name="mobile" value="<?= htmlspecialchars($user['mobile']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

        <label>Telephone:</label>
        <input type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>">

        <h3>Father's Name</h3>
        <label>Last Name:</label>
        <input type="text" name="father_last_name" value="<?= htmlspecialchars($user['father_last_name']) ?>">

        <label>First Name:</label>
        <input type="text" name="father_first_name" value="<?= htmlspecialchars($user['father_first_name']) ?>">

        <label>Middle Name:</label>
        <input type="text" name="father_middle_name" value="<?= htmlspecialchars($user['father_middle_name']) ?>">

        <h3>Mother's Maiden Name</h3>
        <label>Last Name:</label>
        <input type="text" name="mother_last_name" value="<?= htmlspecialchars($user['mother_last_name']) ?>">

        <label>First Name:</label>
        <input type="text" name="mother_first_name" value="<?= htmlspecialchars($user['mother_first_name']) ?>">

        <label>Middle Name:</label>
        <input type="text" name="mother_middle_name" value="<?= htmlspecialchars($user['mother_middle_name']) ?>">

        <div class="buttons">
            <input type="submit" value="Update" class="btn-update">
            <a href="../public/submit.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>