<?php

$con=mysqli_connect("127.0.0.1","root","asd","androidtest");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_GET['username'];
$password = $_GET['password'];
$email = $_GET['email'];
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

if(mysqli_query($con,"INSERT INTO users (Username, PasswordEncrypted, email,salt,Role) VALUES( '$username',md5(CONCAT('dafuq','$password','$salt')), '$email','$salt','$confirmed')"))
{
  echo "Success!";
/*	mail($email,'Conferma registrazione APP','Ciao '.$username.' clicca <a href="http://10.0.015/ANDROIDconnect1/confermaregistrazione.php?confirmed='$confirmed'&username='$username'&email='$email'">qui</a> per confermare la registrazione all''app'
)/*,
		"From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     		"Reply-To:  @gmail.com\r\n" .
     		"X-Mailer: PHP/" . phpversion()); 
*/ 
}

}

mysqli_close($con);
?>
