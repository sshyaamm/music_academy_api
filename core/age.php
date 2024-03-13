<?php
class AgeGroup {
    private $conn;
    private $table = "age_groups";

    public $age_group_id;
    public $age_group_name;
    public $age_group_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAgeGroups(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readAgeGroupDetail(){
        $sql = "SELECT * FROM $this->table WHERE age_group_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->age_group_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->age_group_name = $row['age_group_name'];
            $this->age_group_status = $row['age_group_status'];
            return true; 
        }
        return false; 
    }

    public function createAgeGroup(){
        $checkSql = "SELECT * FROM $this->table WHERE age_group_name = :age_group_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':age_group_name', $this->age_group_name);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: The age group with this name already exists.";
        }

        $sql = "INSERT INTO $this->table 
        SET age_group_name = :age_group_name, 
            age_group_status = :age_group_status";
        $stmt = $this->conn->prepare($sql);

        $this->age_group_name = htmlspecialchars(strip_tags($this->age_group_name));
        $this->age_group_status = htmlspecialchars(strip_tags($this->age_group_status));

        $stmt->bindParam(':age_group_name', $this->age_group_name);
        $stmt->bindParam(':age_group_status', $this->age_group_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

   public function updateAgeGroup(){
        $checkExistenceSql = "SELECT * FROM $this->table WHERE age_group_id = :age_group_id";
        $checkExistenceStmt = $this->conn->prepare($checkExistenceSql);
        $checkExistenceStmt->bindParam(':age_group_id', $this->age_group_id);
        $checkExistenceStmt->execute();
        if($checkExistenceStmt->rowCount() == 0) {
            return "Error: Age group with ID $this->age_group_id not found.";
        } 
  
        $checkSql = "SELECT * FROM $this->table WHERE age_group_name = :age_group_name AND age_group_id != :age_group_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':age_group_name', $this->age_group_name);
        $checkStmt->bindParam(':age_group_id', $this->age_group_id);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: Another age group with this name already exists.";
        }

        $sql = "UPDATE $this->table 
        SET age_group_name = :age_group_name,
            age_group_status = :age_group_status
        WHERE age_group_id = :age_group_id";

        $stmt = $this->conn->prepare($sql);

        $this->age_group_id = htmlspecialchars(strip_tags($this->age_group_id));
        $this->age_group_name = htmlspecialchars(strip_tags($this->age_group_name));
        $this->age_group_status = htmlspecialchars(strip_tags($this->age_group_status));

        $stmt->bindParam(':age_group_id', $this->age_group_id);
        $stmt->bindParam(':age_group_name', $this->age_group_name);
        $stmt->bindParam(':age_group_status', $this->age_group_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteAgeGroup(){
        $sql = "DELETE FROM $this->table WHERE age_group_id = :age_group_id";
        $stmt = $this->conn->prepare($sql);

        $this->age_group_id = htmlspecialchars(strip_tags($this->age_group_id));

        $stmt->bindParam(':age_group_id', $this->age_group_id);

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
