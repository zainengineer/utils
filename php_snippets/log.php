<?php
function __z_log_message($vMessage)
{
    $vLogFile = dirname(dirname(__FILE__)) . '/runtime/quick.log';
    $vBaseFolder = dirname($vLogFile);
    if (!file_exists($vBaseFolder)){
        //not using exception as meant to be temp log, exception can lead to
        echo "$vBaseFolder does not exist so cannot create $vLogFile";
        exit;
    }
    static $iFlag = null;
    if (file_exists($vLogFile)){
        $bWriteAble = is_writable($vLogFile);
    }
    else{
        $bWriteAble = is_writable(dirname($vLogFile));
    }
    if (!$bWriteAble){
        echo ("$vLogFile not writeable");
        exit;
    }
    $aBackTrace = debug_backtrace();
    $vFile = $aBackTrace[0]['file'];
    $vLine = $aBackTrace[0]['line'];
    $vMessage = date('c') . ": $vMessage $vFile:$vLine\n";

    @$result = file_put_contents($vLogFile,$vMessage, $iFlag);
    @chmod($vLogFile,0777);
    if (!$result){
        echo ("Unable to write to $vLogFile even when it is write able\n");
        exit;
    }
    $iFlag = FILE_APPEND;
}
