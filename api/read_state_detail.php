<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/state.php'; 

$state = new State($db); 
$state->state_id = isset($_GET['state_id']) ? $_GET['state_id'] : die(); 

if ($state->readStateDetail()) { 
    $state_arr = array(
        'state_id' => $state->state_id,
        'country_parent_id' => $state->country_parent_id,
        'state_name' => $state->state_name,
        'state_status' => $state->state_status
    );
    echo json_encode($state_arr); 
} else {
    echo json_encode(array('Message' => 'State not found'));
}
?>
