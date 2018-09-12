<?php
error_reporting(0);

session_start();

$nameErr = "";
$name = "";
$servername = "localhost";
$username = "root";
$password = "root";
$conn = "";

 // Create connection
$conn = mysqli_connect($servername, $username, $password,'thesocialnetworktrial2');

// Check connection
if (!$conn){
  die("Connection failed: " . mysqli_connect_error());
}

$sql_use_db = "use thesocialnetworktrial2;";
if (mysqli_query($conn, $sql_use_db)) {
   #echo "Using thesocialnetworktrial2 Database successfully";
} else {
   echo "Error using thesocialnetworktrial2 database: " . mysqli_error($conn);
   print mysqli_error($conn);
}
#echo "<br>";

mysqli_select_db('thesocialnetworktrial2');

mysqli_query($conn,"SET SESSION explicit_defaults_for_timestamp=false");  // allows timestamp values to be null



if(isset($_POST['register'])){
	$register = "insert into Student(username, email, password, name) values('".$_POST["UserName"]."','".$_POST["email"]."', '".$_POST["password"]."', '".$_POST["name"]."');";
	$result = mysqli_query($conn,$register);

	header('Location:Homepage.html');
	exit();
}


# do action
if(isset($_POST['login'])){
	$login="select * from Student where email='".$_POST["loginemail"]."';";
	$login_result = mysqli_query($conn,$login);
	if(mysqli_num_rows($login_result) == 1){
			//set session variables
			$_SESSION["CURRENT_USER"] = $_POST["loginemail"];
			header('Location:Userprofile.php');
			exit();
	}
	else{
		header('Location:Homepage.html');
		exit();
	}
}


mysqli_close($conn);
#echo "Connection closed";
?>