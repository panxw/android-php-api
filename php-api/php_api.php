<?php
require 'php_api_core.php';

//begin
$jsonStr = file_get_contents ( "php://input" ); //fetch post data as string

//process
$apiCore = new PHPApi( $jsonStr );
$apiCore->execute ();

//end
exit ();
?>