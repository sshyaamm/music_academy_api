<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/state.php';

$state = new State($db);

$data = json_decode(file_get_contents('php://input'));

$state->state_id = $data->state_id;
$state->country_parent_id = $data->country_parent_id;
$state->state_name = $data->state_name;
$state->state_status = $data->state_status;

$result = $state->updateState();
if($result === true){
    echo json_encode(array('Message'=>'State updated successfully'));
} else {
    echo json_encode(array('Message'=>'No state with this ID.'));
}
?>
