<?php

if( file_exists ( "imslog.txt" ) && filesize("imslog.txt") > '5000000')
{
$oldfile = time()."imslog.txt";
rename("imslog.txt",$oldfile);
fopen("imslog.txt","w");
}


   function logToFile($filename, $msg)
   { 
   // open file
   $fd = fopen($filename, "a");
   // append date/time to message
   date_default_timezone_set("Asia/Colombo");
   $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg; 
   // write string
   fwrite($fd, $str."\n");
   // close file
   fclose($fd);
   }
   ?>