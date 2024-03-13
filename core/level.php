<?php
class Level {
    private $conn;
    private $table = "levels";

    public $level_id;
    public $level_name;
    public $level_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readLevels(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readLevelDetail(){
        $sql = "SELECT * FROM $this->table WHERE level_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->level_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->level_name = $row['level_name'];
            $this->level_status = $row['level_status'];
            return true; 
        }
        return false; 
    }

    public function createLevel(){
        $checkSql = "SELECT * FROM $this->table WHERE level_name = :level_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':level_name', $this->level_name);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: The level with this name already exists.";
        }

        $sql = "INSERT INTO $this->table 
        SET level_name = :level_name, 
            level_status = :level_status";
        $stmt = $this->conn->prepare($sql);

        $this->level_name = htmlspecialchars(strip_tags($this->level_name));
        $this->level_status = htmlspecialchars(strip_tags($this->level_status));

        $stmt->bindParam(':level_name', $this->level_name);
        $stmt->bindParam(':level_status', $this->level_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function updateLevel(){
        $checkExistenceSql = "SELECT * FROM $this->table WHERE level_id = :level_id";
        $checkExistenceStmt = $this->conn->prepare($checkExistenceSql);
        $checkExistenceStmt->bindParam(':level_id', $this->level_id);
        $checkExistenceStmt->execute();
        if($checkExistenceStmt->rowCount() == 0) {
            return "Error: Level with ID $this->level_id not found.";
        } 

        $checkSql = "SELECT * FROM $this->table WHERE level_name = :level_name AND level_id != :level_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':level_name', $this->level_name);
        $checkStmt->bindParam(':level_id', $this->level_id);
        $checkStmt->execute();
        if($checkStmt->rowCount() > 0) {
            return "Error: Another level with this name already exists.";
        }

        $sql = "UPDATE $this->table 
        SET level_name = :level_name,
            level_status = :level_status
        WHERE level_id = :level_id";

        $stmt = $this->conn->prepare($sql);

        $this->level_id = htmlspecialchars(strip_tags($this->level_id));
        $this->level_name = htmlspecialchars(strip_tags($this->level_name));
        $this->level_status = htmlspecialchars(strip_tags($this->level_status));

        $stmt->bindParam(':level_id', $this->level_id);
        $stmt->bindParam(':level_name', $this->level_name);
        $stmt->bindParam(':level_status', $this->level_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteLevel(){
        $sql = "DELETE FROM $this->table WHERE level_id = :level_id";
        $stmt = $this->conn->prepare($sql);

        $this->level_id = htmlspecialchars(strip_tags($this->level_id));

        $stmt->bindParam(':level_id', $this->level_id);

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
