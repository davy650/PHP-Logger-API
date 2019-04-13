<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../Repository/LoggerRepository.php';
include_once '../../models/Log.php';


//'C:/Logs/' . $log->channel_name . '/' . $log->year . '/' . $log->month . '/' . $log->day . '/' . $log->customerID . '_LOG.log', Logger::DEBUG));

$data = json_decode(file_get_contents("php://input"));
$log = new Log();
$log->channel_name = $data->ChannelName;
$log->day = $data->Day;
$log->month = $data->Month;
$log->year = $data->year;
$log->customerID = $data->CustomerID;

$logtext = '';
$logs_arr = array();

try
{
    $file = file_get_contents('C:/Logs/' . $log->channel_name . '/' . $log->year . '/' . $log->month . '/' . $log->day . '/' . $log->customerID . '_LOG.log');
    if ($file) {

        //$logs_arr = array();
        $log_item = array(
            'StatusCode' => '000', 
            'ChannelName' => $log->channel_name,
            'CustomerID' => $log->customerID,
            'Date' => $log->day . '-' . $log->month . '-' . $log->year,
            'Log' => $file
        );
        array_push($logs_arr, $log_item);
        echo json_encode($logs_arr);

        
    } else {
        // error opening the file.
        
        $log_item = array(
            'StatusCode' => '404',
            'ChannelName' => $log->channel_name,
            'CustomerID' => $log->customerID,
            'Date' => $log->day . '-' . $log->month . '-' . $log->year,
            'Log' => 'File NOT Found !!'
        );
        array_push($logs_arr, $log_item);
        echo json_encode($logs_arr);
    }
}
catch (PDOException $e)
{
    echo json_encode(array('StatusCode' => '091'));
}


/*
print_r( $dirs);


$loggerRepository = new LoggerRepository();
if ($loggerRepository->WriteLog($data))
{
    echo json_encode(array('StatusCode' => '000'));
}
else
{
    echo json_encode(array('StatusCode' => '091'));
}
*/