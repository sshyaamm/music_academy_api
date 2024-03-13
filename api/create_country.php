<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/country.php';

$country = new Country($db);

$data = json_decode(file_get_contents('php://input'));

$country->country_name = $data->country_name;
$country->country_status = $data->country_status;

$result = $country->createCountry();
if($result === true){
    echo json_encode(array('Message'=>'Country created successfully'));
} else {
    echo json_encode(array('Message'=>$result));
}
?>
