<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/class.php'; 

$classi = new ClassObject($db); 
$result = $classi->readClasses(); 
$class_count = $result->rowCount(); 

if ($class_count > 0) { 
    $class_arr = array();
    $class_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $class_item = array( 
            'class_id' => $class_id, 
            'course_parent_id' => $course_parent_id,
            'teacher_parent_id' => $teacher_parent_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'date_of_class' => $date_of_class,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'class_status' => $class_status 
        );
        array_push($class_arr['data'], $class_item); 
    }
    echo json_encode($class_arr);
} else {
    echo json_encode(array('message' => 'No classes found')); 
}
?>
