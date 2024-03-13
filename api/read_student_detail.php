<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);
$student->student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die();


if ($student->readStudentDetail()) {
    $student_arr = array(
        'student_id' => $student->student_id,
        'student_username' => $student->student_username,
        'student_password' => $student->student_password,
        'phone_num' => $student->phone_num,
        'email' => $student->email,
        'age_group_parent_id' => $student->age_group_parent_id,
        'course_parent_id' => $student->course_parent_id,
        'level_parent_id' => $student->level_parent_id,
        'emergency_contact' => $student->emergency_contact,
        'blood_group' => $student->blood_group,
        'address' => $student->address,
        'pincode' => $student->pincode,
        'city_parent_id' => $student->city_parent_id,
        'state_parent_id' => $student->state_parent_id,
        'country_parent_id' => $student->country_parent_id,
        'student_status' => $student->student_status,
        'joined_date' => $student->joined_date
    );
    echo json_encode($student_arr);
} else {
    echo json_encode(array('Message' => 'Student not found'));
}
?>