<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/class_room.php';

$classRoomObj = new ClassRoom($db);
$classRoomObj->class_room_id = isset($_GET['class_room_id']) ? $_GET['class_room_id'] : die();

if ($classRoomObj->readClassRoomDetail()) {
    $classRoomArr = array(
        'class_room_id' => $classRoomObj->class_room_id,
        'class_parent_id' => $classRoomObj->class_parent_id,
        'student_parent_id' => $classRoomObj->student_parent_id,
        'attendance' => $classRoomObj->attendance,
        'attendance_time' => $classRoomObj->attendance_time,
        'class_room_status' => $classRoomObj->class_room_status
    );
    echo json_encode($classRoomArr);
} else {
    echo json_encode(array('Message' => 'Class room not found'));
}
?>
