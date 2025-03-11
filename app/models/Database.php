<?php
class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "personal_data";

                self::$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("<h3 style='color:red; text-align:center;'>Database Connection Failed: " . $e->getMessage() . "</h3>");
            }
        }
        return self::$conn;
    }
}
?>
