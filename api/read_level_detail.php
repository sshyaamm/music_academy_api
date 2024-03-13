<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/level.php';

$level = new Level($db);
$level->level_id = isset($_GET['level_id']) ? $_GET['level_id'] : die();

if ($level->readLevelDetail()) {
    $level_arr = array(
        'level_id' => $level->level_id,
        'level_name' => $level->level_name,
        'level_status' => $level->level_status
    );
    echo json_encode($level_arr);
} else {
    echo json_encode(array('Message' => 'Level not found'));
}
?>
