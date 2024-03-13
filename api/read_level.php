<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/level.php'; 

$level = new Level($db);
$result = $level->readLevels();
$level_count = $result->rowCount(); 

if ($level_count > 0) { 
    $level_arr = array();
    $level_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $level_item = array( 
            'level_id' => $level_id,
            'level_name' => $level_name,
            'level_status' => $level_status
        );
        array_push($level_arr['data'], $level_item); 
    }
    echo json_encode($level_arr);
} else {
    echo json_encode(array('message' => 'No levels found'));
}
?>
