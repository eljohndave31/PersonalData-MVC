<?php
// filepath: c:\Users\USER\OneDrive\Desktop\Xamppp\htdocs\PersonalData1.1\app\models\PersonalDataModel.php
require_once 'Database.php'; // Corrected path

class PersonalDataModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function insertPersonalData($data) {
        $sql = "INSERT INTO personal_info 
        (last_name, first_name, middle_name, dob, sex, civil_status, 
        nationality, religion, birth_street, birth_city, birth_province, birth_country, birth_zip_code, 
        home_street, home_city, home_province, home_country, home_zip_code, 
        mobile, email, telephone, father_last_name, father_first_name, father_middle_name, 
        mother_last_name, mother_first_name, mother_middle_name, tin) 
        VALUES (:last_name, :first_name, :middle_name, :dob, :sex, :civil_status, :nationality, :religion, 
        :birth_street, :birth_city, :birth_province, :birth_country, :birth_zip_code, 
        :home_street, :home_city, :home_province, :home_country, :home_zip_code, 
        :mobile, :email, :telephone, :father_last_name, :father_first_name, :father_middle_name, 
        :mother_last_name, :mother_first_name, :mother_middle_name, :tin)";

        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute($data);
    }

    public function getAllRecords() {
        $sql = "SELECT * FROM personal_info ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>