<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../Repository/LoggerRepository.php';


$data = json_decode(file_get_contents("php://input"));


$loggerRepository = new LoggerRepository();
if ($loggerRepository->WriteLog($data))
{
    echo json_encode(array('StatusCode' => '000'));
}
else
{
    echo json_encode(array('StatusCode' => '091'));
}
