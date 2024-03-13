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

if($student->deleteStudent()){
    echo json_encode(array('Message'=>'Student deleted successfully'));
}
else{
    echo json_encode(array('Message'=>'No students found with this ID'));
}
?>
