<?php

$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$tempo = $_GET['tempo'];
$titolo = $_GET['titolo'];
$descrizione = $_GET['descrizione'];
$result = mysqli_query($con,"SELECT Username FROM users where Username='$username' or email='$email'");
$row = mysqli_fetch_array($result);
$data = $row[0];

if($data){
	echo 'Error'. PHP_EOL;
	echo 'Email or Username already exists'; 
 
}
else{
////$salt=openssl_random_pseudo_bytes(10,TRUE);
$salt=mt_rand();
$confirmed=mt_rand();

if(mysqli_query($con,"INSERT INTO tempi (tempo, titolo, descrizione) VALUES( '$tempo' ,'$titolo','$descrizione')"))
{
  echo "Success!"; 
}

}

mysqli_close($con);
?>
