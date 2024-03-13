<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/city.php'; 

$city = new City($db); 
$result = $city->readCities(); 
$city_count = $result->rowCount(); 

if ($city_count > 0) { 
    $city_arr = array();
    $city_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $city_item = array( 
            'city_id' => $city_id,
            'state_parent_id' => $state_parent_id,
            'city_name' => $city_name,
            'city_status' => $city_status
        );
        array_push($city_arr['data'], $city_item); 
    }
    echo json_encode($city_arr);
} else {
    echo json_encode(array('message' => 'No cities found'));
}
?>
