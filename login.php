<?php
$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$username = $_GET['username'];
$password = $_GET['password'];
$result = mysqli_query($con,"SELECT Role FROM users where Username='$username' and PasswordEncrypted=md5(CONCAT('dafuq','$password',salt))");
$row = mysqli_fetch_array($result);
$data = $row[0];
if($data){
	echo $data;

}

mysqli_close($con);
?>
