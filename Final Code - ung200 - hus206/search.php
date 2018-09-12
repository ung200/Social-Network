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
Hitarthi
</title>

<!-- hidden add friend button-->
    <script>
      function setStudentID(button_value,form_data){
          form_data.student_id.value=button_value;
      }
      </script>
</head>

<body bgcolor="#e0e0e0">
<div class="navbar-fixed">
<nav>
<div class="nav-wrapper">
  <a href="#!" class="brand-logo"><img src="nyu.png" style="height: 63.99px; width: auto;" alt="logo"></a>
  <a href="#" class="brand-logo" style="padding-left:70px "> Welcome to NYU Network </a>
  <ul class="right hide-on-med-and-down">
    <li class="active"><a href="search.php" class="modal-trigger"><i class="material-icons">search</i></a></li>

    <li><a href="Userprofile.php"><i class="material-icons">face</i></a></li>
    <li><a href="feed.php"><i class="material-icons">public</i></a></li>
    <li><a href="Activitypost.php"><i class="material-icons">view_list</i></a></li>

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

<form action="" method="post">
  <input type="text" name="query" placeholder="Enter keyword here to search" /><br>
  <input type="submit" value="Search" name="search" />
</form>

<?php
  $query = $_POST['query']; 
  if(isset($_POST["search"])){

    $search_student = "SELECT name, student_id, profile_pic FROM Student WHERE name LIKE '%".$query."%' OR username LIKE '%".$query."%' OR email LIKE '%".$query."%';";

    $student_results = mysqli_query($conn,$search_student) or die(mysqli_error());

    $search_diary = "SELECT * FROM Diary WHERE body_text LIKE '%".$query."%' OR title LIKE '%".$query."%';";

    $diary_results = mysqli_query($conn,$search_diary) or die(mysqli_error());


    if (mysqli_num_rows($student_results) > 0) {
      while($row = mysqli_fetch_assoc($student_results)){
        $display_user_face = $row["profile_pic"];
        $display_user_name = $row["name"];
        $display_student_id = $row["student_id"];
        #echo "<p><h3>".$results_s['name']."</h3><p>";

        echo '<br><br><div class="row">
  <div class="col s12 m6 push-m3">
    <div class="card card-panel hoverable white">
        <div class="row">
          <div class="col s12">
            <div class="col s6">
              <img src='.$display_user_face.' style="border-radius: 50%; width:150px;">
            </div>
            <div class="col s6">
              <h3><b>'.$display_user_name.'</b></h3>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
              <form method="post" action="">
                <button class="btn waves-effect waves-light center" type="submit" name="post_like_submit" value = "'.$display_student_id.'" onclick="setStudentID(this.value,this.form)" style="color: white;"> ADD FIREND <i class="material-icons right">person_add</i>
                </button>
                <input type="hidden" name = "student_id" id = "student_id"/>
              </form>
          </div>
        </div>
      </div>
  </div>
</div>';
      }
    } 

    # Diary search using body_text and title
    if (mysqli_num_rows($diary_results) > 0){
      while($row = mysqli_fetch_assoc($diary_results)){

        $display_post_title = $row['title'];
        $display_post_text = $row["body_text"];
        $display_post_media = $row["body_multimedia"];
        $display_post_location_name = $row["location_name"];

        echo '<div class="row">
            <div class="col s12 m6 push-m3">
              <div class="card hoverable white">
                <div class="card-content black-text">
                  <div class="row">
                    <span class="card-title center"><b>'.$display_post_title.'</b></span>
                  </div>
                  <div class="row">
                    <div class="col s4">
                      <img src='.$display_post_media.' style="border-radius: 50%; width:150px;">
                    </div>
                    <div class="col s4">
                      <p>'.$display_post_text.'</p>
                    </div>
                    <div class="col s4">
                      <p>Location: '.$display_post_location_name.'</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>';
      }
    }
  }

  
?>


</body>

</html>




