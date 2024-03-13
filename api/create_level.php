<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/level.php';

$level = new Level($db);

$data = json_decode(file_get_contents('php://input'));

$level->level_name = $data->level_name;
$level->level_status = $data->level_status;

$result = $level->createLevel();
if($result === true){
    echo json_encode(array('Message'=>'Level created successfully'));
} else {
    echo json_encode(array('Message'=>$result));
}
?>
