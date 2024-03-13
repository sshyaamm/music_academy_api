<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/city.php';

$city = new City($db);

$data = json_decode(file_get_contents('php://input'));

$city->city_id = $data->city_id;

$result = $city->deleteCity();
if($result === true){
    echo json_encode(array('Message'=>'City deleted successfully'));
} else {
    echo json_encode(array('Message'=>$result)); 
}
?>
