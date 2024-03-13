<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/level.php'; 

$level = new Level($db); 

$data = json_decode(file_get_contents('php://input'));

$level->level_id = $data->level_id;

$result = $level->deleteLevel(); 
if($result === true){
    echo json_encode(array('Message'=>'Level deleted successfully')); 
} else {
    echo json_encode(array('Message'=>'No level with this ID found.')); 
}
?>
