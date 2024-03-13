<?php
class Student{
    private $conn;
    private $table = "students";

    public $student_id;
    public $student_username;
    public $student_password;
    public $phone_num;
    public $email;
    public $age_group_parent_id;
    public $course_parent_id;
    public $level_parent_id;
    public $emergency_contact;
    public $blood_group;
    public $address;
    public $pincode;
    public $city_parent_id;
    public $state_parent_id;
    public $country_parent_id;
    public $student_status;
    public $joined_date;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readStudents(){
        $sql = "SELECT * FROM students";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } 

    public function readStudentDetail(){
        $sql = "SELECT * FROM students WHERE student_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->student_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->student_username = $row['student_username'];
            $this->student_password = $row['student_password'];
            $this->phone_num = $row['phone_num'];
            $this->email = $row['email'];
            $this->age_group_parent_id = $row['age_group_parent_id'];
            $this->course_parent_id = $row['course_parent_id'];
            $this->level_parent_id = $row['level_parent_id'];
            $this->emergency_contact = $row['emergency_contact'];
            $this->blood_group = $row['blood_group'];
            $this->address = $row['address'];
            $this->pincode = $row['pincode'];
            $this->city_parent_id = $row['city_parent_id'];
            $this->state_parent_id = $row['state_parent_id'];
            $this->country_parent_id = $row['country_parent_id'];
            $this->student_status = $row['student_status'];
            $this->joined_date = $row['joined_date'];
            return true; 
        }
        return false; 
    }

    public function createStudent(){
        $checkSql = "SELECT * FROM students WHERE student_username = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(1, $this->student_username);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        if($numRows > 0) {
            return "Error: This username is taken by another user. Please try a different username.";
        }
        $currentDate = date('Y-m-d');
        $sql = "INSERT INTO students 
        SET student_username = :student_username, 
            student_password = :student_password,
            phone_num = :phone_num,
            email = :email,
            age_group_parent_id = :age_group_parent_id,
            course_parent_id = :course_parent_id,
            level_parent_id = :level_parent_id,
            emergency_contact = :emergency_contact,
            blood_group = :blood_group,
            address = :address,
            pincode = :pincode,
            city_parent_id = :city_parent_id,
            state_parent_id = :state_parent_id,
            country_parent_id = :country_parent_id,
            student_status = :student_status,
            joined_date = :joined_date";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':student_username', $this->student_username);
        $stmt->bindParam(':student_password', $this->student_password);
        $stmt->bindParam(':phone_num', $this->phone_num);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age_group_parent_id', $this->age_group_parent_id);
        $stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $stmt->bindParam(':level_parent_id', $this->level_parent_id);
        $stmt->bindParam(':emergency_contact', $this->emergency_contact);
        $stmt->bindParam(':blood_group', $this->blood_group);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':pincode', $this->pincode);
        $stmt->bindParam(':city_parent_id', $this->city_parent_id);
        $stmt->bindParam(':state_parent_id', $this->state_parent_id);
        $stmt->bindParam(':country_parent_id', $this->country_parent_id);
        $stmt->bindParam(':student_status', $this->student_status);
        $stmt->bindParam(':joined_date', $currentDate);
        
        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }
    
    public function updateStudent(){
        $checkIdSql = "SELECT * FROM students WHERE student_id = ?";
        $checkIdStmt = $this->conn->prepare($checkIdSql);
        $checkIdStmt->bindParam(1, $this->student_id);
        $checkIdStmt->execute();
        $numIdRows = $checkIdStmt->rowCount();
        if($numIdRows == 0) {
            return "No student found with this ID";
        }

        $checkSql = "SELECT * FROM $this->table WHERE student_username = :student_username AND student_id != :student_id";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(':student_username', $this->student_username);
        $checkStmt->bindParam(':student_id', $this->student_id);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            return "Error: This username is taken by another student.";
        }

        $sql = "UPDATE students 
        SET student_username = :student_username,
            student_password = :student_password,
            phone_num = :phone_num,
            email = :email,
            age_group_parent_id = :age_group_parent_id,
            course_parent_id = :course_parent_id,
            level_parent_id = :level_parent_id,
            emergency_contact = :emergency_contact,
            blood_group = :blood_group,
            address = :address,
            pincode = :pincode,
            city_parent_id = :city_parent_id,
            state_parent_id = :state_parent_id,
            country_parent_id = :country_parent_id,
            student_status = :student_status
        WHERE student_id = :student_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':student_username', $this->student_username);
        $stmt->bindParam(':student_password', $this->student_password);
        $stmt->bindParam(':phone_num', $this->phone_num);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':age_group_parent_id', $this->age_group_parent_id);
        $stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $stmt->bindParam(':level_parent_id', $this->level_parent_id);
        $stmt->bindParam(':emergency_contact', $this->emergency_contact);
        $stmt->bindParam(':blood_group', $this->blood_group);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':pincode', $this->pincode);
        $stmt->bindParam(':city_parent_id', $this->city_parent_id);
        $stmt->bindParam(':state_parent_id', $this->state_parent_id);
        $stmt->bindParam(':country_parent_id', $this->country_parent_id);
        $stmt->bindParam(':student_status', $this->student_status);

        if($stmt->execute()) {
            return true;
        }
        printf('error %s \n', $stmt->error);
        return false;
    }

    public function deleteStudent(){
        $sql = "DELETE FROM students WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':student_id', $this->student_id);

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
