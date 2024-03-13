<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/age.php';

$ageGroup = new AgeGroup($db);
$ageGroup->age_group_id = isset($_GET['age_group_id']) ? $_GET['age_group_id'] : die();

if ($ageGroup->readAgeGroupDetail()) {
    $ageGroup_arr = array(
        'age_group_id' => $ageGroup->age_group_id,
        'age_group_name' => $ageGroup->age_group_name,
        'age_group_status' => $ageGroup->age_group_status
    );
    echo json_encode($ageGroup_arr);
} else {
    echo json_encode(array('Message' => 'Age group not found'));
}
?>
