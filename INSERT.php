<?php
$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
$sql="INSERT INTO users (Username, PasswordEncrypted, email,salt) VALUES ('admin', asswordEncrypted=md5(CONCAT('dafuq','admin','admin)),'admin@admin.com','admin')";
if (mysqli_query($con,$sql))
{
   echo "Values have been inserted successfully";
}
?>
