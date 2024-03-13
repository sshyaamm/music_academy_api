<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/class_room.php';

$classRoomObj = new ClassRoom($db);

$data = json_decode(file_get_contents('php://input'));

$classRoomObj->class_room_id = $data->class_room_id;

$result = $classRoomObj->deleteClassRoom();
if($result === true){
    echo json_encode(array('Message'=>'Class room delete successfully'));
} else {
    echo json_encode(array('Message'=>'No class room found with this ID')); 
}
?>
