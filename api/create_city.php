<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/city.php';

$city = new City($db);

$data = json_decode(file_get_contents('php://input'));

$city->state_parent_id = $data->state_parent_id;
$city->city_name = $data->city_name;
$city->city_status = $data->city_status;

$result = $city->createCity();
if($result === true){
    echo json_encode(array('Message'=>'City created successfully'));
} else {
    echo json_encode(array('Message'=>$result));
}
?>
