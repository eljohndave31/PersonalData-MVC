<?php
// filepath: c:\Users\USER\OneDrive\Desktop\Xamppp\htdocs\PersonalData1.1\app\controllers\PersonalDataControllers.php

require_once __DIR__ . '/../models/PersonalDataModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Validation
    $required_fields = ['last_name', 'first_name', 'middle_name', 'dob', 'sex', 'civil_status', 'nationality', 'mobile'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace("_", " ", $field)) . " is required.";
        }
    }

    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!empty($_POST['mobile']) && !preg_match("/^\d{10,}$/", $_POST['mobile'])) {
        $errors[] = "Mobile number should have at least 10 digits.";
    }

    if (!empty($errors)) {
        echo "<h2 style='color: red;'>Please fix the following errors:</h2>";
        echo "<ul style='color: red;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<br><a href='javascript:history.back()'>Back to Previous Page</a>";
        exit();
    }

    // Prepare data
    $personalData = [
        ':last_name' => clean_input($_POST['last_name']),
        ':first_name' => clean_input($_POST['first_name']),
        ':middle_name' => clean_input($_POST['middle_name']),
        ':dob' => clean_input($_POST['dob']),
        ':sex' => clean_input($_POST['sex']),
        ':civil_status' => clean_input($_POST['civil_status']),
        ':nationality' => clean_input($_POST['nationality']),
        ':religion' => !empty($_POST['religion']) ? clean_input($_POST['religion']) : NULL,
        ':birth_street' => clean_input($_POST['birth_street']),
        ':birth_city' => clean_input($_POST['birth_city']),
        ':birth_province' => clean_input($_POST['birth_province']),
        ':birth_country' => clean_input($_POST['birth_country']),
        ':birth_zip_code' => !empty($_POST['birth_zip_code']) ? clean_input($_POST['birth_zip_code']) : NULL,
        ':home_street' => clean_input($_POST['home_street']),
        ':home_city' => clean_input($_POST['home_city']),
        ':home_province' => clean_input($_POST['home_province']),
        ':home_country' => clean_input($_POST['home_country']),
        ':home_zip_code' => clean_input($_POST['home_zip_code']),
        ':mobile' => clean_input($_POST['mobile']),
        ':email' => !empty($_POST['email']) ? clean_input($_POST['email']) : NULL,
        ':telephone' => !empty($_POST['telephone']) ? clean_input($_POST['telephone']) : NULL,
        ':father_last_name' => clean_input($_POST['father_last_name']),
        ':father_first_name' => clean_input($_POST['father_first_name']),
        ':father_middle_name' => clean_input($_POST['father_middle_name']),
        ':mother_last_name' => clean_input($_POST['mother_last_name']),
        ':mother_first_name' => clean_input($_POST['mother_first_name']),
        ':mother_middle_name' => clean_input($_POST['mother_middle_name']),
        ':tin' => !empty($_POST['tin']) ? clean_input($_POST['tin']) : NULL,
    ];

    // Call Model to Insert Data
    $model = new PersonalDataModel();
    if ($model->insertPersonalData($personalData)) {
        header("Location: ../../views/submit.php");
        exit();
    } else {
        echo "Error in saving data.";
    }
}
?>