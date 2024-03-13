<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);
$result = $student->readStudents();
$student_count = $result->rowCount();

if ($student_count > 0) {
    $student_arr = array();
    $student_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $student_item = array(
            'student_id' => $student_id,
            'student_username' => $student_username,
            'student_password' => $student_password,
            'phone_num' => $phone_num,
            'email' => $email,
            'age_group_parent_id' => $age_group_parent_id,
            'course_parent_id' => $course_parent_id,
            'level_parent_id' => $level_parent_id,
            'emergency_contact' => $emergency_contact,
            'blood_group' => $blood_group,
            'address' => $address,
            'pincode' => $pincode,
            'city_parent_id' => $city_parent_id,
            'state_parent_id' => $state_parent_id,
            'country_parent_id' => $country_parent_id,
            'student_status' => $student_status,
            'joined_date' => $joined_date
        );
        array_push($student_arr['data'], $student_item);
    }
    echo json_encode($student_arr);
} else {
    echo json_encode(array('message' => 'No students found'));
}
?>