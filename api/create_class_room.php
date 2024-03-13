<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/class_room.php';

$classRoomObj = new ClassRoom($db);

$data = json_decode(file_get_contents('php://input'));

$classRoomObj->class_parent_id = $data->class_parent_id;
$classRoomObj->student_parent_id = $data->student_parent_id;
$classRoomObj->attendance = $data->attendance;
$classRoomObj->class_room_status = $data->class_room_status;

$result = $classRoomObj->createClassRoom();
if($result === true){
    echo json_encode(array('Message'=>'Class room created successfully'));
} else {
    echo json_encode(array('Message'=>$result)); 
}
?>
