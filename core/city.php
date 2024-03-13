<?php
class City {
    private $conn;
    private $table = "cities";

    public $city_id;
    public $state_parent_id;
    public $city_name;
    public $city_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readCities(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readCityDetail(){
        $sql = "SELECT * FROM $this->table WHERE city_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->city_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->state_parent_id = $row['state_parent_id'];
            $this->city_name = $row['city_name'];
            $this->city_status = $row['city_status'];
            return true; 
        }
        return false; 
    }

    public function createCity(){
        $checkSql = "SELECT * FROM $this->table WHERE city_name = :city_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':city_name', $this->city_name);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: The city with this name already exists.";
        }

        $sql = "INSERT INTO $this->table 
        SET state_parent_id = :state_parent_id,
            city_name = :city_name, 
            city_status = :city_status";
        $stmt = $this->conn->prepare($sql);

        $this->state_parent_id = htmlspecialchars(strip_tags($this->state_parent_id));
        $this->city_name = htmlspecialchars(strip_tags($this->city_name));
        $this->city_status = htmlspecialchars(strip_tags($this->city_status));

        $stmt->bindParam(':state_parent_id', $this->state_parent_id);
        $stmt->bindParam(':city_name', $this->city_name);
        $stmt->bindParam(':city_status', $this->city_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

   public function updateCity(){
    	$checkExistenceSql = "SELECT * FROM $this->table WHERE city_id = :city_id";
    	$checkExistenceStmt = $this->conn->prepare($checkExistenceSql);
    	$checkExistenceStmt->bindParam(':city_id', $this->city_id);
    	$checkExistenceStmt->execute();
    	if($checkExistenceStmt->rowCount() == 0) {
        	return "Error: City with ID $this->city_id not found.";
    	} 
  
        $checkSql = "SELECT * FROM $this->table WHERE city_name = :city_name AND city_id != :city_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':city_name', $this->city_name);
        $checkStmt->bindParam(':city_id', $this->city_id);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: Another city with this name already exists.";
        }

        $sql = "UPDATE $this->table 
        SET state_parent_id = :state_parent_id,
            city_name = :city_name,
            city_status = :city_status
        WHERE city_id = :city_id";

        $stmt = $this->conn->prepare($sql);

        $this->city_id = htmlspecialchars(strip_tags($this->city_id));
        $this->state_parent_id = htmlspecialchars(strip_tags($this->state_parent_id));
        $this->city_name = htmlspecialchars(strip_tags($this->city_name));
        $this->city_status = htmlspecialchars(strip_tags($this->city_status));

        $stmt->bindParam(':city_id', $this->city_id);
        $stmt->bindParam(':state_parent_id', $this->state_parent_id);
        $stmt->bindParam(':city_name', $this->city_name);
        $stmt->bindParam(':city_status', $this->city_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteCity(){
        $sql = "DELETE FROM $this->table WHERE city_id = :city_id";
        $stmt = $this->conn->prepare($sql);

        $this->city_id = htmlspecialchars(strip_tags($this->city_id));

        $stmt->bindParam(':city_id', $this->city_id);

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
