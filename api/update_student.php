<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);

$data = json_decode(file_get_contents('php://input'));

$student->student_id = $data->student_id;
$student->student_username = $data->student_username;
$student->student_password = $data->student_password;
$student->phone_num = $data->phone_num;
$student->email = $data->email;
$student->age_group_parent_id = $data->age_group_parent_id;
$student->course_parent_id = $data->course_parent_id;
$student->level_parent_id = $data->level_parent_id;
$student->emergency_contact = $data->emergency_contact;
$student->blood_group = $data->blood_group;
$student->address = $data->address;
$student->pincode = $data->pincode;
$student->city_parent_id = $data->city_parent_id;
$student->state_parent_id = $data->state_parent_id;
$student->country_parent_id = $data->country_parent_id;
$student->student_status = $data->student_status;

$result = $student->updateStudent();
if($result === true){
    echo json_encode(array('Message'=>'Student updated successfully'));
} else {
    echo json_encode(array('Message'=>$result)); 
}
?>
