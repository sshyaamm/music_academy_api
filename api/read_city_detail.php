<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/city.php'; 

$city = new City($db); 
$city->city_id = isset($_GET['city_id']) ? $_GET['city_id'] : die(); 

if ($city->readCityDetail()) { 
    $city_arr = array(
        'city_id' => $city->city_id,
        'state_parent_id' => $city->state_parent_id,
        'city_name' => $city->city_name,
        'city_status' => $city->city_status
    );
    echo json_encode($city_arr); 
} else {
    echo json_encode(array('Message' => 'City not found'));
}
?>
