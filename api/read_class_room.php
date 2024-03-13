<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/class_room.php'; 

$classRoomObj = new ClassRoom($db); 
$result = $classRoomObj->readClassRooms(); 
$classRoomCount = $result->rowCount(); 

if ($classRoomCount > 0) { 
    $classRoomArr = array();
    $classRoomArr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $classRoomItem = array( 
            'class_room_id' => $class_room_id, 
            'class_parent_id' => $class_parent_id,
            'student_parent_id' => $student_parent_id,
            'attendance' => $attendance,
            'attendance_time' => $attendance_time,
            'class_room_status' => $class_room_status 
        );
        array_push($classRoomArr['data'], $classRoomItem); 
    }
    echo json_encode($classRoomArr);
} else {
    echo json_encode(array('message' => 'No class rooms found')); 
}
?>
