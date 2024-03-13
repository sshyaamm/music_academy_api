<?php
class ClassObject {
    private $conn;
    private $table = "classes";

    public $class_id;
    public $course_parent_id;
    public $teacher_parent_id;
    public $start_time;
    public $end_time;
    public $date_of_class;
    public $created_at;
    public $updated_at;
    public $class_status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readClasses() {
        $sql = "SELECT * FROM classes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readClassDetail() {
        $sql = "SELECT * FROM classes WHERE class_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->class_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->course_parent_id = $row['course_parent_id'];
            $this->teacher_parent_id = $row['teacher_parent_id'];
            $this->start_time = $row['start_time'];
            $this->end_time = $row['end_time'];
            $this->date_of_class = $row['date_of_class'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            $this->class_status = $row['class_status'];
            return true; 
        }
        return false; 
    }

    public function createClass() {
        $checkSql = "SELECT * FROM classes WHERE date_of_class = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(1, $this->date_of_class);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        if ($numRows > 0) {
            return "Error: The class of this date is already created.";
        }

        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO classes 
        SET course_parent_id = :course_parent_id, 
            teacher_parent_id = :teacher_parent_id,
            start_time = :start_time,
            end_time = :end_time,
            date_of_class = :date_of_class,
            created_at = :created_at,
            updated_at = :updated_at,
            class_status = :class_status";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $stmt->bindParam(':teacher_parent_id', $this->teacher_parent_id);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':date_of_class', $this->date_of_class);
        $stmt->bindParam(':created_at', $currentDateTime);
        $stmt->bindParam(':updated_at', $currentDateTime);
        $stmt->bindParam(':class_status', $this->class_status);

        if ($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function updateClass() {
        $checkIdSql = "SELECT * FROM classes WHERE class_id = ?";
        $checkIdStmt = $this->conn->prepare($checkIdSql);
        $checkIdStmt->bindParam(1, $this->class_id);
        $checkIdStmt->execute();
        $numIdRows = $checkIdStmt->rowCount();
        if ($numIdRows == 0) {
            return "No class found with this ID";
        }

        $checkSql = "SELECT * FROM $this->table WHERE date_of_class = :date_of_class AND class_id != :class_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':date_of_class', $this->date_of_class);
        $checkStmt->bindParam(':class_id', $this->class_id);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            return "Error: Another class with this date already exists.";
        }

        $currentDateTime = date('Y-m-d H:i:s');

        $sql = "UPDATE classes 
        SET course_parent_id = :course_parent_id,
            teacher_parent_id = :teacher_parent_id,
            start_time = :start_time,
            end_time = :end_time,
            date_of_class = :date_of_class,
            updated_at = :updated_at,
            class_status = :class_status
        WHERE class_id = :class_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $stmt->bindParam(':teacher_parent_id', $this->teacher_parent_id);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':date_of_class', $this->date_of_class);
        $stmt->bindParam(':updated_at', $currentDateTime);
        $stmt->bindParam(':class_status', $this->class_status);
        $stmt->bindParam(':class_id', $this->class_id);

        if ($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteClass() {
        $sql = "DELETE FROM classes WHERE class_id = :class_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':class_id', $this->class_id);

        if ($stmt->execute()) {
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
