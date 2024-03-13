<?php
class Country {
    private $conn;
    private $table = "countries";

    public $country_id;
    public $country_name;
    public $country_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readCountries(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readCountryDetail(){
        $sql = "SELECT * FROM $this->table WHERE country_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->country_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->country_name = $row['country_name'];
            $this->country_status = $row['country_status'];
            return true; 
        }
        return false; 
    }

    public function createCountry(){
        $checkSql = "SELECT * FROM $this->table WHERE country_name = :country_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':country_name', $this->country_name);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: The country with this name already exists.";
        }

        $sql = "INSERT INTO $this->table 
        SET country_name = :country_name, 
            country_status = :country_status";
        $stmt = $this->conn->prepare($sql);

        $this->country_name = htmlspecialchars(strip_tags($this->country_name));
        $this->country_status = htmlspecialchars(strip_tags($this->country_status));

        $stmt->bindParam(':country_name', $this->country_name);
        $stmt->bindParam(':country_status', $this->country_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

   public function updateCountry(){
    	$checkExistenceSql = "SELECT * FROM $this->table WHERE country_id = :country_id";
    	$checkExistenceStmt = $this->conn->prepare($checkExistenceSql);
    	$checkExistenceStmt->bindParam(':country_id', $this->country_id);
    	$checkExistenceStmt->execute();
    	if($checkExistenceStmt->rowCount() == 0) {
        	return "Error: Country with ID $this->country_id not found.";
    	} 
  
        $checkSql = "SELECT * FROM $this->table WHERE country_name = :country_name AND country_id != :country_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':country_name', $this->country_name);
        $checkStmt->bindParam(':country_id', $this->country_id);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: Another country with this name already exists.";
        }

        $sql = "UPDATE $this->table 
        SET country_name = :country_name,
            country_status = :country_status
        WHERE country_id = :country_id";

        $stmt = $this->conn->prepare($sql);

        $this->country_id = htmlspecialchars(strip_tags($this->country_id));
        $this->country_name = htmlspecialchars(strip_tags($this->country_name));
        $this->country_status = htmlspecialchars(strip_tags($this->country_status));

        $stmt->bindParam(':country_id', $this->country_id);
        $stmt->bindParam(':country_name', $this->country_name);
        $stmt->bindParam(':country_status', $this->country_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteCountry(){
        $sql = "DELETE FROM $this->table WHERE country_id = :country_id";
        $stmt = $this->conn->prepare($sql);

        $this->country_id = htmlspecialchars(strip_tags($this->country_id));

        $stmt->bindParam(':country_id', $this->country_id);

        if($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        }
        printf('error %s \n', $stmt->error);
        return false; 
    }
}
?>
