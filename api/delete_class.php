<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/class.php';

$classi = new ClassObject($db);

$data = json_decode(file_get_contents('php://input'));

$classi->class_id = $data->class_id;

if($classi->deleteClass()){
    echo json_encode(array('Message'=>'Class deleted successfully'));
}
else{
    echo json_encode(array('Message'=>'No class found with this ID'));
}
?>
