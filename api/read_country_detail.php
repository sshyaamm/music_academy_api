<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/country.php';

$country = new Country($db);
$country->country_id = isset($_GET['country_id']) ? $_GET['country_id'] : die();

if ($country->readCountryDetail()) {
    $country_arr = array(
        'country_id' => $country->country_id,
        'country_name' => $country->country_name,
        'country_status' => $country->country_status
    );
    echo json_encode($country_arr);
} else {
    echo json_encode(array('Message' => 'Country not found'));
}
?>
