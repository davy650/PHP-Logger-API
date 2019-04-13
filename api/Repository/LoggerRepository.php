<?php 
require_once('../../vendor/autoload.php');
include_once '../../models/Log.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

 class LoggerRepository {

    // Constructor 
    public function __construct() {

    }

    public function WriteLog($data) {
        try
        {
            // Initiate Log Object
            $log = new Log();

            $log->channel_name = $data->ChannelName;
            $log->log_level = $data->LogLevel;
            $log->log_text = $data->LogText;
            $log->json_object = $data->ExtraDetails;
            $log->customerID = $data->CustomerID;

            $datenow = date_create('now')->format('Y-m-d H:i:s');

            $log->date = date_create('now')->format('Y-m-d H:i:s');
            $log->day = date_create('now')->format('d');
            $log->month = date_create('now')->format('m');
            $log->year = date_create('now')->format('Y');
            $logLevel = (string) $log->log_level;

            $logger = new Logger($log->channel_name);
            $logger->pushHandler(new StreamHandler('C:/Logs/' . $log->channel_name . '/' . $log->year . '/' . $log->month . '/' . $log->day . '/' . $log->customerID . '_LOG.log', Logger::DEBUG));
            $logger->$logLevel($log->log_text . ' - ' . $log->json_object . ' ');
            return true;

        } catch (PDOException $ex)
        {
            return false;
        }
    }


    public function ReadLog($data) {
        $log = new Log();

        $log->channel_name = $data->ChannelName;
        $log->day = $data->Day;
        $log->month = $data->Month;
        $log->year = $data->year;
        $log->customerID = $data->CustomerID;

        try
        {
            $file = file_get_contents('C:/Logs/' . $log->channel_name . '/' . $log->year . '/' . $log->month . '/' . $log->day . '/' . $log->customerID . '_LOG.log');
            if ($file) {

                $log->statusCode = '000';
                $log->log_text = $file;
 
            } else {
                    // error opening the file.
                $log->statusCode = '404';
                $log->log_text = 'File NOT Found !!';
            }
        }
        catch (PDOException $e)
        {
            $log->statusCode = '091';
            $log->log_text = 'Error Reading File !!';
        }

        return $log;
    }

    

 }