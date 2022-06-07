<?php
// $log_time = date('Y-m-d h:i:sa');
// $log_msg = "how to create log file in php?";
  
// wh_log("************** Start Log For Day : '" . $log_time . "'**********");
// wh_log($log_msg);
// wh_log("************** END Log For Day : '" . $log_time . "'**********");
 
function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}
?>