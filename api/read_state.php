<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/state.php'; 

$state = new State($db); 
$result = $state->readStates();
$state_count = $result->rowCount(); 

if ($state_count > 0) { 
    $state_arr = array();
    $state_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $state_item = array( 
            'state_id' => $state_id,
            'country_parent_id' => $country_parent_id,
            'state_name' => $state_name,
            'state_status' => $state_status
        );
        array_push($state_arr['data'], $state_item); 
    }
    echo json_encode($state_arr);
} else {
    echo json_encode(array('message' => 'No states found'));
}
?>
