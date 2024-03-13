<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/class.php';

$classi = new ClassObject($db);
$classi->class_id = isset($_GET['class_id']) ? $_GET['class_id'] : die();

if ($classi->readClassDetail()) {
    $classi_arr = array(
        'class_id' => $classi->class_id,
        'course_parent_id' => $classi->course_parent_id,
        'teacher_parent_id' => $classi->teacher_parent_id,
        'start_time' => $classi->start_time,
        'end_time' => $classi->end_time,
        'date_of_class' => $classi->date_of_class,
        'created_at' => $classi->created_at,
        'updated_at' => $classi->updated_at,
        'class_status' => $classi->class_status
    );
    echo json_encode($classi_arr);
} else {
    echo json_encode(array('Message' => 'Class not found'));
}
?>
