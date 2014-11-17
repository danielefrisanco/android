<?php
$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
$sql="CREATE TABLE table1(Username CHAR(30),Password CHAR(30),Role CHAR(30))";
if (mysqli_query($con,$sql))
{
   echo "Table have been created successfully";
}
?>
