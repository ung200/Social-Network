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

$sql_student_id = "select student_id from Student where email='".$_SESSION["CURRENT_USER"]."';";
$result_student_id = mysqli_query($conn,$sql_student_id);
while($row = mysqli_fetch_row($result_student_id)) {
  #echo "crap";
  $student_id = $row[0];
  #echo $student_id;
}
?>
<!DOCTYPE html>
<html>

<style>

.row{
  padding: center;
}
body, html {
height: 50%;
margin: 0; 

}
.bg {
/* Full height */
height: 100%; 

/* Center and scale the image nicely */
background: url("nyu.png") no-repeat center top fixed;
  
}
.nav-wrapper a img {
max-width: 100%; max-height: 100%;
}

</style>

<head>
<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>
Hitarth
</title>
</head>

<body bgcolor="#e0e0e0">
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo"><img src="nyu.png" style="height: 63.99px; width: auto;" alt="logo"></a>
        <a href="#" class="brand-logo" style="padding-left:70px "> Welcome to NYU Network </a>
        <ul class="right hide-on-med-and-down">
          <li><a href="search.php" class="modal-trigger"><i class="material-icons">search</i></a></li>

          <li><a href="Userprofile.php"><i class="material-icons">face</i></a></li>
          <li><a href="feed.php"><i class="material-icons">public</i></a></li>
          <li class="active"><a href="Activitypost.php"><i class="material-icons">view_list</i></a></li>

          <li><a href="#modal_friendship" class="modal-trigger"><i class="material-icons">people</i></a></li>

          <!-- Dropdown Structure -->
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href="#!">Privacy</a></li>
          </ul>
          <li><a href="Logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="row">
    <div class="col s12">
      <h3 class="center-align deep-purple-text text-darken-1"> <b>Here are all the activities that took so far since you joined us! </b></h3>
      
    </div>
    
  </div>

  <?php
    $list_activities = "select * from Student_activity ORDER BY activity_timestamp DESC;";

    $result_list_activities = mysqli_query($conn, $list_activities) or die(mysqli_error());

    while($row = mysqli_fetch_assoc($result_list_activities)){
      #echo "string";
      $from_student_id = $row["from_student_id"];
      $to_diary_id = $row["to_diary_id"];
      $activity_type = $row["activity_type"];
      $activity_timestamp = $row["activity_timestamp"];

      # get student name who did the activity
      $get_from_student_id_name = "select name from Student where student_id=".$from_student_id.";";
      #echo $get_from_student_id_name;

      $result_get_from_student_id_name = mysqli_query($conn, $get_from_student_id_name) or die(mysqli_error());

      while($result_name = mysqli_fetch_assoc($result_get_from_student_id_name)){
        #echo "string";
        $from_student_name = $result_name["name"];
        #echo $from_student_name;
      }

      #get name of student whose diary post was liked or disliked
      $get_to_student_name_diary = "select name from Diary natural join Student where Diary.diary_id = ".$to_diary_id.";";

      $result_get_to_student_name_diary = mysqli_query($conn, $get_to_student_name_diary) or die(mysqli_error());

      while($row = mysqli_fetch_assoc($result_get_to_student_name_diary)){
        $to_student_name = $row["name"];
      }

      $str_activity_timestamp = date("d F Y H:i:s",$activity_timestamp);
      # final display of cards for activity posts
      if($activity_type == "added post"){
        echo '<div class="row">
                <div class="col s12 m6 push-m3">
                  <div class="card hoverable white">
                    <div class="card-content black-text">
                      <div class="row">
                        <p class="deep-purple darken-1 white-text">'.$from_student_name.' added a new post</p>
                      </div>
                      <div class = "row">
                        <p class="right-align grey lighten-3"> '.$activity_timestamp.'</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';
      }
      elseif ($activity_type == "liked") {
        echo '<div class="row">
                <div class="col s12 m6 push-m3">
                  <div class="card hoverable white">
                    <div class="card-content black-text">
                      <div class="row">
                        <p class="deep-purple darken-1 white-text"><b>'.$from_student_name.' liked '.$to_student_name.'\'s post</b></p>
                      </div>
                      <div class="row">
                        <p class="right-align grey lighten-3"> '.$activity_timestamp.'</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';
      }
      elseif ($activity_type == "disliked") {
        echo '<div class="row">
                <div class="col s12 m6 push-m3">
                  <div class="card hoverable white">
                    <div class="card-content black-text">
                      <div class="row">
                        <p class="deep-purple darken-1 white-text"><b>'.$from_student_name.' disliked '.$to_student_name.'\'s post</b></p>
                      </div>
                      <div class="row">
                        <p class="right-align grey lighten-3"> '.$activity_timestamp.'</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';
      }
    }
  ?>

</body>
</html>
