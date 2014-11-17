<?php
$con=mysqli_connect("127.0.0.1","root","asd");
$sql="CREATE DATABASE androidtest";
if (mysqli_query($con,$sql))
{
   echo "Database my_db created successfully";
}
?>
