<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../Repository/LoggerRepository.php';


$data = json_decode(file_get_contents("php://input"));
$loggerRepository = new LoggerRepository();
$log = $loggerRepository->ReadLog($data);

$logs_arr = array();
$log_item = array(
    'StatusCode' => '000', 
    'ChannelName' => $log->channel_name,
    'CustomerID' => $log->customerID,
    'Date' => $log->day . '-' . $log->month . '-' . $log->year,
    'Log' => $log->log_text
);
array_push($logs_arr, $log_item);
echo json_encode($logs_arr);

