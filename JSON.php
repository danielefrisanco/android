<?php
 
if( isset($_POST["json"]) ) {
     $data = json_decode($_POST["json"]);
     $data->msg = strrev($data->msg);
 
     echo json_encode($data);
 
}
