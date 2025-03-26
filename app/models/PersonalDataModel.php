<?php
require_once 'Database.php'; 

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

    // Fetch a single record by ID
    public function getRecordById($id) {
        $sql = "SELECT * FROM personal_info WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a record by ID
    public function updateRecord($id, $data) {
        $sql = "UPDATE personal_info SET 
            last_name=:last_name, first_name=:first_name, middle_name=:middle_name, dob=:dob, sex=:sex, civil_status=:civil_status, tin=:tin, nationality=:nationality, religion=:religion, 
            birth_street=:birth_street, birth_city=:birth_city, birth_province=:birth_province, birth_country=:birth_country, birth_zip_code=:birth_zip_code, 
            home_street=:home_street, home_city=:home_city, home_province=:home_province, home_country=:home_country, home_zip_code=:home_zip_code, 
            mobile=:mobile, email=:email, telephone=:telephone, 
            father_last_name=:father_last_name, father_first_name=:father_first_name, father_middle_name=:father_middle_name, 
            mother_last_name=:mother_last_name, mother_first_name=:mother_first_name, mother_middle_name=:mother_middle_name 
            WHERE id=:id";

        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        foreach ($data as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt->execute();
    }
}
?>