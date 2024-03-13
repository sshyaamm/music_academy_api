<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/age.php';

$ageGroup = new AgeGroup($db);

$data = json_decode(file_get_contents('php://input'));

$ageGroup->age_group_id = $data->age_group_id;

$result = $ageGroup->deleteAgeGroup();
if($result === true){
    echo json_encode(array('Message'=>'Age group deleted successfully'));
} else {
    echo json_encode(array('Message'=>'No age group found with this ID.')); 
}
?>
