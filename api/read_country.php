<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/country.php'; 

$country = new Country($db);
$result = $country->readCountries();
$country_count = $result->rowCount(); 

if ($country_count > 0) { 
    $country_arr = array();
    $country_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $country_item = array( 
            'country_id' => $country_id,
            'country_name' => $country_name,
            'country_status' => $country_status
        );
        array_push($country_arr['data'], $country_item); 
    }
    echo json_encode($country_arr);
} else {
    echo json_encode(array('message' => 'No countries found'));
}
?>
