<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../includes/config.php';
require_once '../core/age.php'; 

$ageGroup = new AgeGroup($db);
$result = $ageGroup->readAgeGroups();
$ageGroup_count = $result->rowCount(); 

if ($ageGroup_count > 0) { 
    $ageGroup_arr = array();
    $ageGroup_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $ageGroup_item = array( 
            'age_group_id' => $age_group_id,
            'age_group_name' => $age_group_name,
            'age_group_status' => $age_group_status
        );
        array_push($ageGroup_arr['data'], $ageGroup_item); 
    }
    echo json_encode($ageGroup_arr);
} else {
    echo json_encode(array('message' => 'No age groups found'));
}
?>
