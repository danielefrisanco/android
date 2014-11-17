 <?php

 
//
 //PHP API for Login, Register, Changepassword, Resetpassword Requests and for Email Notifications.
 //  
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // Get tag
    $tag = $_POST['tag'];

    // Include Database handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    // check for tag type
    if ($tag == 'login') {
	
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
			$response["user"]["uname"] = $user["username"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
           
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } 
  else if ($tag == 'chgpass'){
  $email = $_POST['email'];

  $newpassword = $_POST['newpas'];
  

  $hash = $db->hashSSHA($newpassword);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
  $subject = "Change Password Notification";
         $message = "Hello User,\n\nYour Password is sucessfully changed.\n\nRegards,\nLearn2Crack Team.";
          $from = "contact@learn2crack.com";
          $headers = "From:" . $from;
	if ($db->isUserExisted($email)) {

 $user = $db->forgotPassword($email, $encrypted_password, $salt);
if ($user) {
         $response["success"] = 1;
          mail($email,$subject,$message,$headers);
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
}


            // user is already existed - error response
           
           
        } 
           else {

            $response["error"] = 2;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);

}
}
else if ($tag == 'forpass'){
$forgotpassword = $_POST['forgotpassword'];

$randomcode = $db->random_string();
  

$hash = $db->hashSSHA($randomcode);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
  $subject = "Password Recovery";
         $message = "Hello User,\n\nYour Password is sucessfully changed. Your new Password is $randomcode . Login with your new Password and change it in the User Panel.\n\nRegards,\nLearn2Crack Team.";
          $from = "contact@learn2crack.com";
          $headers = "From:" . $from;
	if ($db->isUserExisted($forgotpassword)) {

 $user = $db->forgotPassword($forgotpassword, $encrypted_password, $salt);
if ($user) {
         $response["success"] = 1;
          mail($forgotpassword,$subject,$message,$headers);
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
}


            // user is already existed - error response
           
           
        } 
           else {

            $response["error"] = 2;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);

}

}
else if ($tag == 'register') {
        // Request type is Register new user
        $fname = $_POST['fname'];
		$lname = $_POST['lname'];
        $email = $_POST['email'];
		$uname = $_POST['uname'];
        $password = $_POST['password'];


        
          $subject = "Registration";
         $message = "Hello $fname,\n\nYou have sucessfully registered to our service.\n\nRegards,\nAdmin.";
          $from = "contact@learn2crack.com";
          $headers = "From:" . $from;

        // check if user is already existed
        if ($db->isUserExisted($email)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
        } 
           else if(!$db->validEmail($email)){
            $response["error"] = 3;
            $response["error_msg"] = "Invalid Email Id";
            echo json_encode($response);             
}
else {
            // store user
            $user = $db->storeUser($fname, $lname, $email, $uname, $password);
            if ($user) {
                // user stored successfully
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
			$response["user"]["uname"] = $user["username"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
               mail($email,$subject,$message,$headers);
            
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured in Registartion";
                echo json_encode($response);
            }
        }
    } 
else if ($tag == 'insertspam') {
		   /*  $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured in Registartion";
                echo json_encode($response);
		 
       */
		
		// inserisci un nuovo messaggio 
		$msg = $_POST['msg'];
		$uid =1 ;//$_POST['uid'];

		$message= $db->insertSpam( $msg, $uid);
		$response["success"] = 1; 
		$response["message"]["uid"] = $message["uid"];
		$response["message"]["mid"] = $message["mid"];
		$response["message"]["created"] = $message["created"];
		$response["message"]["testo"] = $message["testo"];
		echo json_encode($response);

      
    } 
    
    
    
   /*
else if ($tag == 'table') {
	//DANIELE
        // Request type is get table fields and types
        $table = $_POST['table']; 




       
            // get table info
            $table = $db->tableInfo($table);
			$numberOfFields=0;
            if ($table) {
                // table info aquired succesfully
            $response["success"] = 1;
        
			foreach($table as $field){
				$response["table"]["fieldName".$numberOfFields] = $table[$field[0]];
				$response["table"]["fieldType".$numberOfFields] = $table[$field[1]];
				$numberOfFields++;
			}
			$response["table"]["numberOfFields"] = $numberOfFields;
			echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured in getting table info";
                echo json_encode($response);
            }
        }
      
    
     
    
   */ else {
         $response["error"] = 3;
         $response["error_msg"] = "JSON ERROR";
        echo json_encode($response);
    }
} else {
    echo "Learn2Crack Login API";
} 
?>
