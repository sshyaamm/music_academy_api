<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/class.php';

$classi = new ClassObject($db);

$data = json_decode(file_get_contents('php://input'));

$classi->course_parent_id = $data->course_parent_id;
$classi->teacher_parent_id = $data->teacher_parent_id;
$classi->start_time = $data->start_time;
$classi->end_time = $data->end_time;
$classi->date_of_class = $data->date_of_class;
$classi->class_status = $data->class_status;

$result = $classi->createClass();
if($result === true){
    echo json_encode(array('Message'=>'Class created successfully'));
} else {
    echo json_encode(array('Message'=>$result)); 
}
?>
