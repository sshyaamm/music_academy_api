<?php
class ClassRoom{
    private $conn;
    private $table = "class_rooms";

    public $class_room_id;
    public $class_parent_id;
    public $student_parent_id;
    public $attendance;
    public $attendance_time;
    public $class_room_status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createClassRoom(){
        $checkSql = "SELECT * FROM class_rooms WHERE student_parent_id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(1, $this->student_parent_id);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        if($numRows > 0) {
            return "Error: This student's attendance is already recorded.";
        }

        $currentDateTime = date('Y-m-d H:i:s');

        if ($this->attendance == "Present" || $this->attendance == "Late") {
            $attendance_time = $currentDateTime;
        } else {
            $attendance_time = "Absent";
        }

        $sql = "INSERT INTO class_rooms 
        SET class_parent_id = :class_parent_id, 
            student_parent_id = :student_parent_id,
            attendance = :attendance,
            attendance_time = :attendance_time,
            class_room_status = :class_room_status";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':class_parent_id', $this->class_parent_id);
        $stmt->bindParam(':student_parent_id', $this->student_parent_id);
        $stmt->bindParam(':attendance', $this->attendance);
        $stmt->bindParam(':attendance_time', $attendance_time); 
        $stmt->bindParam(':class_room_status', $this->class_room_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function updateClassRoom(){
        $checkIdSql = "SELECT * FROM class_rooms WHERE class_room_id = ?";
        $checkIdStmt = $this->conn->prepare($checkIdSql);
        $checkIdStmt->bindParam(1, $this->class_room_id);
        $checkIdStmt->execute();
        $numIdRows = $checkIdStmt->rowCount();
        if($numIdRows == 0) {
            return "No class room found with this ID";
        }

        $checkSql = "SELECT * FROM class_rooms WHERE student_parent_id = :student_parent_id AND class_room_id != :class_room_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':student_parent_id', $this->student_parent_id);
        $checkStmt->bindParam(':class_room_id', $this->class_room_id);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            return "Error: This student's attendance is already recorded.";
        }

        $currentDateTime = date('Y-m-d H:i:s');

        if ($this->attendance == "Present" || $this->attendance == "Late") {
            $attendance_time = $currentDateTime;
        } else {
            $attendance_time = "Absent";
        }

        $sql = "UPDATE class_rooms 
        SET class_parent_id = :class_parent_id,
            student_parent_id = :student_parent_id,
            attendance = :attendance,
            attendance_time = :attendance_time,
            class_room_status = :class_room_status
        WHERE class_room_id = :class_room_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':class_room_id', $this->class_room_id);
        $stmt->bindParam(':class_parent_id', $this->class_parent_id);
        $stmt->bindParam(':student_parent_id', $this->student_parent_id);
        $stmt->bindParam(':attendance', $this->attendance);
        $stmt->bindParam(':attendance_time', $attendance_time); 
        $stmt->bindParam(':class_room_status', $this->class_room_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function readClassRooms(){
        $sql = "SELECT * FROM class_rooms";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readClassRoomDetail(){
        $sql = "SELECT * FROM class_rooms WHERE class_room_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->class_room_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->class_parent_id = $row['class_parent_id'];
            $this->student_parent_id = $row['student_parent_id'];
            $this->attendance = $row['attendance'];
            $this->attendance_time = $row['attendance_time'];
            $this->class_room_status = $row['class_room_status'];
            return true; 
        }
        return false; 
    }

    public function deleteClassRoom(){
        $sql = "DELETE FROM class_rooms WHERE class_room_id = :class_room_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':class_room_id', $this->class_room_id);

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
