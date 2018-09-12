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
    <li><a href="search.php" class="modal-trigger"><i class="material-icons">search</i></a></li>

    <li><a href="Userprofile.php"><i class="material-icons">face</i></a></li>
    <li class="active"><a href="feed.php"><i class="material-icons">public</i></a></li>
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

<div class="row center">
  <div class="col s12">
    <div class="card card-panel col m7 l7 push-m3 push-l3 deep-purple darken-1">
      <div class="card-content">
        <div class="row col s12">

          <!-- PHP for Like Button -->
          <?php
            if(isset($_POST["post_like_submit"])){
              #echo "string";
              # Get Diary_id for that particular post
              $diary_id = $_POST["diary_id"];
              #echo $diary_id;

              # Get current like_counter value
              $like_counter_current = "select like_counter from Diary where diary_id= ".$diary_id.";";
              #echo $like_counter_current;
              $result_like_counter_current = mysqli_query($conn, $like_counter_current);

              while($row = mysqli_fetch_row($result_like_counter_current)) {
                # code...
                #echo $row;
                $like_counter_val = $row[0];
                #echo $like_counter_val;
              }

              # Increment the like_counter value by 1
              $like_counter_val = $like_counter_val +1;
              #echo "<br>";
              #echo $like_counter_val;

              # Update the like_counter value in the table
              $update_like_counter = "update Diary set like_counter= ".$like_counter_val." where diary_id=".$diary_id.";";
              #echo $update_like_counter;
              $result_update_like_counter = mysqli_query($conn, $update_like_counter) or die(mysqli_error());


              #Add activity into activity table
              $get_privacy_control_id_activity = "select privacy_control_id from Diary where diary_id=".$diary_id.";";
              $result_get_privacy_control_id_activity = mysqli_query($conn, $get_privacy_control_id_activity) or die(mysqli_error());


              while($row=mysqli_fetch_assoc($result_get_privacy_control_id_activity)){
                $just_liked_privacy_control_id = $row["privacy_control_id"];
                #echo $just_added_diary_id;
              }

              $add_activity_liked = "insert into Student_activity(from_student_id, to_diary_id, activity_type, privacy_control_id) values(".$student_id.", ".$diary_id.", 'liked', ".$just_liked_privacy_control_id.");";

              #echo $add_activity_new_post;

              $result_add_activity_liked = mysqli_query($conn, $add_activity_liked) or die(mysqli_error());
            }
          ?>

          <!-- PHP for Dislike Button -->
          <?php
            if(isset($_POST["post_dislike_submit"])){
              #echo "string";
              # Get Diary_id for that particular post
              $diary_id = $_POST["diary_id"];

              # Get current dislike_counter value
              $dislike_counter_current = "select dislike_counter from Diary where diary_id= ".$diary_id.";";
              
              $result_dislike_counter_current = mysqli_query($conn, $dislike_counter_current);

              while($row = mysqli_fetch_row($result_dislike_counter_current)) {
                $dislike_counter_val = $row[0];
              }

              # Increment the dislike_counter value by 1
              $dislike_counter_val = $dislike_counter_val +1;

              # Update the like_counter value in the table
              $update_dislike_counter = "update Diary set dislike_counter= ".$dislike_counter_val." where diary_id=".$diary_id.";";
              
              $result_update_dislike_counter = mysqli_query($conn, $update_dislike_counter) or die(mysqli_error());

              #Add activity into activity table
              $get_privacy_control_id_activity_dislike = "select privacy_control_id from Diary where diary_id=".$diary_id.";";
              $result_get_privacy_control_id_activity_dislike = mysqli_query($conn, $get_privacy_control_id_activity_dislike) or die(mysqli_error());


              while($row=mysqli_fetch_assoc($result_get_privacy_control_id_activity_dislike)){
                $just_disliked_privacy_control_id = $row["privacy_control_id"];
                #echo $just_added_diary_id;
              }

              $add_activity_disliked = "insert into Student_activity(from_student_id, to_diary_id, activity_type, privacy_control_id) values(".$student_id.", ".$diary_id.", 'disliked', ".$just_disliked_privacy_control_id.");";

              #echo $add_activity_new_post;

              $result_add_activity_disliked = mysqli_query($conn, $add_activity_disliked) or die(mysqli_error());
            }
          ?>

          <!-- PHP for displaying all the posts in seperate cards -->
          <?php
            $display_posts = "select * from Diary ORDER BY diary_timestamp DESC;";
            $result_display_posts = mysqli_query($conn, $display_posts) or die(mysqli_error());
            while($row = mysqli_fetch_assoc($result_display_posts)) {
              $display_post_title = $row['title'];
              $display_post_text = $row["body_text"];
              $display_post_media = $row["body_multimedia"];
              $display_post_location_name = $row["location_name"];
              $display_post_like_counter = $row["like_counter"];
              $display_post_dislike_counter = $row["dislike_counter"];
              $display_post_id = $row["diary_id"];
              $display_diary_timestamp = $row["diary_timestamp"];


              echo '<div class="card card-panel hoverable">
                      <div class="row">
                        <div class="col s12">
                          <span class="card-title"><b>'.$display_post_title.'</b></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s12">
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

                      <div class="row">
                        <div class="col s12">
                          <div class="col s3 right-align">
                            <form method="post" action="">
                              <button class="btn waves-effect waves-light" type="submit" name="post_like_submit" value = "'.$display_post_id.'" onclick="setDiaryID(this.value,this.form)" style="color: white;"> LIKE <i class="material-icons right">thumb_up</i>
                              </button>
                              <input type="hidden" name = "diary_id" id = "diary_id"/>
                            </form>
                          </div>
                          <div class="col s3 left-align">
                            <p style="padding-top: 15px"><b>'.$display_post_like_counter.'</b>&nbsp;<b>LIKES</b> </p>
                          </div>
                          <div class="col s3 right-align">
                            <form method="post" action="">
                              <button class="btn waves-effect waves-light" type="submit" name="post_dislike_submit" value = "'.$display_post_id.'" onclick="setDiaryID(this.value,this.form)" style="color: white;"> DISLIKE <i class="material-icons right">thumb_down</i>
                              </button>
                              <input type="hidden" name = "diary_id" id = "diary_id"/>

                            </form>
                          </div>
                          <div class="col s3 left-align">
                            <p style="padding-top: 15px"><b>'.$display_post_dislike_counter.'</b>&nbsp;<b>DISLIKES</b> </p>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s12">
                          <p class="right-align grey-text" style="padding-top: 20px">'.$display_diary_timestamp.'</p>
                        </div>
                      </div>
                    </div>';
            }
          ?>

       </div>
      </div>
    </div>
  </div>
</div>




</body>

</html>




