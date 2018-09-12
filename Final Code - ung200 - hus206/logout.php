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


session_destroy();

header('Location:Homepage.html');
die;
exit;

?>