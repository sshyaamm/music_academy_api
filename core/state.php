<?php
class State {
    private $conn;
    private $table = "states";

    public $state_id;
    public $country_parent_id;
    public $state_name;
    public $state_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readStates(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function readStateDetail(){
        $sql = "SELECT * FROM $this->table WHERE state_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->state_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->state_name = $row['state_name'];
	    $this->country_parent_id = $row['country_parent_id'];
            $this->state_status = $row['state_status'];
            return true;
        }
        return false;
    }

    public function createState(){
        $checkSql = "SELECT * FROM $this->table WHERE state_name = :state_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':state_name', $this->state_name);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: The state with this name already exists.";
        }

        $sql = "INSERT INTO $this->table 
                SET country_parent_id = :country_parent_id,
                    state_name = :state_name, 
                    state_status = :state_status";
        $stmt = $this->conn->prepare($sql);

        $this->country_parent_id = htmlspecialchars(strip_tags($this->country_parent_id));
        $this->state_name = htmlspecialchars(strip_tags($this->state_name));
        $this->state_status = htmlspecialchars(strip_tags($this->state_status));

        $stmt->bindParam(':country_parent_id', $this->country_parent_id);
        $stmt->bindParam(':state_name', $this->state_name);
        $stmt->bindParam(':state_status', $this->state_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function updateState(){
        $checkExistenceSql = "SELECT * FROM $this->table WHERE state_id = :state_id";
        $checkExistenceStmt = $this->conn->prepare($checkExistenceSql);
        $checkExistenceStmt->bindParam(':state_id', $this->state_id);
        $checkExistenceStmt->execute();
        if($checkExistenceStmt->rowCount() == 0) {
            return "Error: State with ID $this->state_id not found.";
        }

        $checkSql = "SELECT * FROM $this->table WHERE state_name = :state_name AND state_id != :state_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':state_name', $this->state_name);
        $checkStmt->bindParam(':state_id', $this->state_id);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: Another state with this name already exists.";
        }

        $sql = "UPDATE $this->table 
                SET country_parent_id = :country_parent_id,
                    state_name = :state_name,
                    state_status = :state_status
                WHERE state_id = :state_id";

        $stmt = $this->conn->prepare($sql);

        $this->state_id = htmlspecialchars(strip_tags($this->state_id));
        $this->country_parent_id = htmlspecialchars(strip_tags($this->country_parent_id));
        $this->state_name = htmlspecialchars(strip_tags($this->state_name));
        $this->state_status = htmlspecialchars(strip_tags($this->state_status));

        $stmt->bindParam(':state_id', $this->state_id);
        $stmt->bindParam(':country_parent_id', $this->country_parent_id);
        $stmt->bindParam(':state_name', $this->state_name);
        $stmt->bindParam(':state_status', $this->state_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteState(){
        $sql = "DELETE FROM $this->table WHERE state_id = :state_id";
        $stmt = $this->conn->prepare($sql);

        $this->state_id = htmlspecialchars(strip_tags($this->state_id));

        $stmt->bindParam(':state_id', $this->state_id);

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