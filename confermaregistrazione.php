<?php

$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_GET['username'];
$confirmed = $_GET['confirmed'];
$email = $_GET['email'];
$result = mysqli_query($con,"SELECT Role FROM users where Username='$username' AND email='$email' AND Role ='$confirmed' ");
$row = mysqli_fetch_array($result);
$data = $row[0];

if($data){


	if(mysqli_query($con,"UPDATE users set Role ='user' WHERE Username='$username' AND email='$email' AND Role ='$confirmed'  "))
	{
	   echo "Success!"; 
	}
	else{
		echo 'Error' ;
		 
	 
	} 
}
else{
	echo 'Error' ;
	 
 
} 
 

mysqli_close($con);
?>
