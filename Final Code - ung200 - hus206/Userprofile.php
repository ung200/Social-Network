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
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--Maps-->
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhLEzlhoJvU1bTLjjFcbOQHRhPj2HMckY&libraries=places"></script>

    <script type="text/javascript">
      var geocoder = new google.maps.Geocoder();

      function geocodePosition(pos) {
        geocoder.geocode({
          latLng: pos
        }, function(responses) {
          if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address);
          } else {
            updateMarkerAddress('Cannot determine address at this location.');
          }
        });
      }

      function updateMarkerStatus(str) {
        //document.getElementById('markerStatus').innerHTML = str;
      }

      function updateMarkerPosition(latLng) {
        document.getElementById('info').value = [
        latLng.lat(),
        latLng.lng()
        ].join(',');
      }

      function updateMarkerAddress(str) {
        document.getElementById('address').value = str;
      }

      function initialize() {
        var latLng = new google.maps.LatLng(-34.397, 150.644);
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
          zoom: 8,
          center: latLng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
          position: latLng,
          title: 'Point A',
          map: map,
          draggable: true
        });

        // Update current position info.
        updateMarkerPosition(latLng);
        geocodePosition(latLng);

        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'dragstart', function() {
          updateMarkerAddress('Dragging...');
        });

        google.maps.event.addListener(marker, 'drag', function() {
          updateMarkerStatus('Dragging...');
          updateMarkerPosition(marker.getPosition());
        });

        google.maps.event.addListener(marker, 'dragend', function() {
          updateMarkerStatus('Drag ended');
          geocodePosition(marker.getPosition());
        });
      }

      // Onload handler to fire off the app.
      google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <!--end of map-->

    <title>
      Hitarthi
    </title>

    <!-- hidden like-dislike-->
    <script>
      function setDiaryID(button_value,form_data){
          form_data.diary_id.value=button_value;
      }
      </script>
  </head>

  <body bgcolor="#e0e0e0">
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

      /* Maps */
      #mapCanvas {
          width: 450px;
          height: 400px;
      }
      #infoPanel {
        float: left;
        margin-left: 10px;
      }
      #infoPanel div {
        margin-bottom: 5px;
      }
    </style>

    <div class="navbar-fixed">
      <nav>
        <div class="nav-wrapper">
          <a href="#!" class="brand-logo"><img src="nyu.png" style="height: 63.99px; width: auto;" alt="logo"></a>
          <a href="#" class="brand-logo" style="padding-left:70px "> Welcome to NYU Network </a>
          <ul class="right hide-on-med-and-down">
            <li><a href="search.php" class="modal-trigger"><i class="material-icons">search</i></a></li>

            <li class="active"><a href="Userprofile.php"><i class="material-icons">face</i></a></li>
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

    <div class="row">
      <form class="col s12" method="post" action="">
        <div class="row">
          <div class="input-field col s5">
            <label for="name" style="font-size: 30px; position: relative;"><b style="color: teal">Hitarthi Shah</b></label>
          </div>
          <div class="input-field col s6">
            <i class="material-icons prefix">tag_faces</i>
            <input type="text" class="validate" data-length="128" name="bio">
            <label for="icon_telephone">Add a bio here</label>
          </div>
          <div class="input-field col s1">
              <a class="waves-effect waves-light btn" type="Submit" name="add_bio">Add</a>
          </div>
          </div>
        </div>
      </form>
    </div>

    <div class="row center">
      <div class="col s12">
        <div class="card card-panel col m4 l4 deep-purple darken-1">
          <div class="card-content">
            <div class="row col s12">
              <div class="card card-panel hoverable">
                <span class="card-title"><b>About Me</b></span>
                <?php
                  $pic = mysqli_query($conn,"select profile_pic from student where email='".$_SESSION["CURRENT_USER"]."';");
                  if (mysqli_num_rows($pic)>0) {
                      while($row=mysqli_fetch_assoc($pic)){
                          echo "<img src='".$row["profile_pic"]."'style='border-radius: 50%; width: 150px'>";
                      }
                  }
                ?>
                <?php
                  #get story into card
                  if(isset($_POST['story_submit'])){
                  $story = "update Student set story='".$_POST["story"]."' where email='".$_SESSION["CURRENT_USER"]."';";
                  } 
                  $result_story = mysqli_query($conn,$story);

                  $get_story = "select story from Student where email='".$_SESSION["CURRENT_USER"]."';";
                  $result_getstory = mysqli_query($conn,$get_story); 

                  if (mysqli_num_rows($result_getstory) > 0){
                    while($row=mysqli_fetch_row($result_getstory)){
                    #echo $row[0] . '<br>';
                    echo '<br>' . '<div class="row">' . $row[0] . '</div>';
                    }
                  }
                ?>
                <div class="row">
                  <form class="col s12" action="" method="post">
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea" name="story"></textarea>
                        <label for="textarea1">Tell your friends something about you...</label>
                        <input type="submit" name="story_submit">

                         <div class="row" style="padding-top: 20px">
                          <a class="waves-effect waves-light btn modal-trigger" href="#modal_edit_profile_pic"><i class="material-icons left">mode_edit</i>Edit Picture</a>
                        </div>
                        <div class="row" >
                          <a class="waves-effect waves-light btn modal-trigger" href="#modal_view_details"><i class="material-icons left">account_circle</i>View Details</a>
                        </div>
                        <div class="row">
                          <a class="waves-effect waves-light btn modal-trigger" href="#modal_friends"><i class="material-icons left">people</i>Your Friends</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <a class="btn-floating halfway-fab waves-effect waves-light modal-trigger" href="#modal_profile">
                <i class="material-icons">create</i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-panel col m7 l7 push-m1 push-l1 deep-purple darken-1">
          <div class="card-content">
            <div class="row col s12">

              <div class="card card-panel hoverable">
                <span class="card-title"><b>Here are all your Posts. Feel free to add some more using the below button!</b></span>

                <div class="row" style="padding-top: 10px">
                  <a class="waves-effect waves-light btn modal-trigger" href="#modal_add_New_post"><i class="material-icons left">create</i>Add New Post</a>
                </div>
              </div>

              <!-- <div class="card card-panel hoverable">
                <div class="row">
                  <div class="col s12">
                    <span class="card-title"><b>POST FORMAT</b></span>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col s12">
                    <div class="col s4">
                      <p>IMAGE</p>
                    </div>
                    <div class="col s4">
                      <p>TEXT</p>
                    </div>
                    <div class="col s4">
                      <p>LOCATION</p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12">
                    <div class="col s3 right-align">
                      <a class="waves-effect waves-light btn-large"><i class="material-icons left">thumb_up</i></a>
                    </div>
                    <div class="col s3 left-align">
                      <p style="padding-top: 15px"><b>32</b>&nbsp;<b>LIKES</b> </p>
                    </div>
                    <div class="col s3 right-align">
                      <a class="waves-effect waves-light btn-large"><i class="material-icons left">thumb_down</i></a>
                    </div>
                    <div class="col s3 left-align">
                      <p style="padding-top: 15px"><b>32</b>&nbsp;<b>DISLIKES</b> </p>
                    </div>
                  </div>
                </div>
              </div> -->

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

        <!-- Modal Structure -->
        <div id="modal_profile" class="modal">
          <div class="modal-content">
            <div class="row">
              <form class="col s12" method = 'post'>
                <div class="row">
                  <div class="input-field col s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="profile_name" type="text" name="fullname" class="validate">
                    <label for="profile_name">Edit your Name</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <i class="material-icons prefix">transform</i>
                    <input id="username" type="text" name="username" class="validate">
                    <label for="password">Edit your Username</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <i class="material-icons prefix">phone</i>
                    <input id="phone number" type="text" name="telephone" class="validate">
                    <label for="phone number">Edit your Telephone</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <label for="age">Update Age</label>
                    <input id="age" type="text" name="age" class="validate">
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="city" type="text" class="validate" name="city">
                    <label for="city">Update City</label>
                  </div>
                </div>
                <div class="row">
                    <p>
                      <input name="radio" type="radio" value="Female" id="test1" />
                      <label for="test1">Female</label>
                    </p>
                    <p>
                      <input name="radio" type="radio" id="test2" value="Male" />
                      <label for="test2">Male</label>
                    </p>
                </div>
                
                <div class="row">
                  <div class="input-field center">
                  <button class="btn waves-effect teal darken-1" type="submit" name="aboutme_submit" style="color: white;"> Submit <i class="material-icons right">send</i>
                  </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class=" modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <?php
          if(isset($_POST['aboutme_submit']))
          {
            if($_POST["fullname"] != ""){
              $updated_name = "update Student set name='".$_POST["fullname"]."' where email='".$_SESSION["CURRENT_USER"]."';";
              $result_name = mysqli_query($conn,$updated_name);
            }

            if($_POST["username"] != ""){
              $updated_username ="update Student set username='".$_POST["username"]."' where email='".$_SESSION["CURRENT_USER"]."';";
              $result_username = mysqli_query($conn,$updated_username);
            }
            
            if($_POST["telephone"] != ""){
              $telephone = $_POST["telephone"];
              $updated_telephone="update Student set telephone='".$telephone."' where email='".$_SESSION["CURRENT_USER"]."';";
              echo $updated_telephone;
              $result_telephone = mysqli_query($conn,$updated_telephone);
            }
            
            if($_POST["age"] != ""){
              $updated_age="update Student set age='".$_POST["age"]."' where email='".$_SESSION["CURRENT_USER"]."';";
              $result_age = mysqli_query($conn,$updated_age);
            }

            if($_POST["city"] != ""){
              $updated_city="update Student set city='".$_POST["city"]."' where email='".$_SESSION["CURRENT_USER"]."';";
              $result_city = mysqli_query($conn,$updated_city);
            }

            if($_POST["radio"] != ""){
              $updated_gender="update Student set gender='".$_POST["radio"]."' where email='".$_SESSION["CURRENT_USER"]."';"; 
              $result_gender = mysqli_query($conn,$updated_gender);
            }
          }
        ?>

        <div id="modal_edit_profile_pic" class="modal">
          <div class="modal-content">
            <div class="row">
              <form action="" method="post" action="" enctype="multipart/form-data">
                <div class="file-field">
                  <div class="btn">
                    <span>select picture from your computer</span>
                    <input id="new_pic" name="new_pic" type="file" accept="image/*">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="input-field center">
                  <button class="btn waves-effect teal darken-1" type="submit"  value="Upload" name="profile_pic_submit" style="color: white;"> Upload <i class="material-icons right">send</i>
                  </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class=" modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <div id="modal_view_details" class="modal">
          <div class="modal-content">
            <div class="row">
              <?php
                $sql = "SELECT * FROM Student WHERE email='".$_SESSION["CURRENT_USER"]."';";
                $result = mysqli_query($conn,$sql) or die (mysqli_error ());
                while ($row = mysqli_fetch_array($result)){
              ?>

              <form action="" method="post" style="color: teal">
                  <a class="waves-effect waves-light btn">Your Details</a><br>
                  <label style="color: black">Name</label>
                  <input type="text" name="name" value="<?php echo $row['name']; ?>" size=10>
                  <label style="color: black">Username</label>
                  <input type="text" name="username" value="<?php echo $row['username']; ?> " size=10>
                  <label style="color: black">Age</label>
                  <input type="text" name="age" value="<?php echo $row['age']; ?> " size=10>
                  <label style="color: black">Telephone</label>
                  <input type="text" name="gender" value="<?php echo $row['telephone']; ?> " size=10>
                  <label style="color: black">City</label>
                  <input type="text" name="city" value="<?php echo $row['city']; ?> " size=10>
                  <label style="color: black">Gender</label>
                  <input type="text" name="gender" value="<?php echo $row['gender']; ?> " size=10>
              </form>
              <?php
                }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class=" modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <div id="modal_friends" class="modal">
          <div class="modal-content">
            <div class="row">
              <form action="">
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Image</span>
                    <input type="file">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="input-field center">
                  <button class="btn waves-effect teal darken-1" type="submit" name="profile_pic_submit" style="color: white;"> Upload <i class="material-icons right">send</i>
                  </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class=" modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <?php
          if (isset($_POST["profile_pic_submit"])){
              // Get image name
              $image = $_FILES['new_pic']['name'];
              // image file directory
              $target = "images/".basename($image);
              
              // check if file is an image
              $check = getimagesize($_FILES["new_pic"]["tmp_name"]);
              if($check !== false) {
                  // it is an image
                  mysqli_query($conn,"UPDATE Student SET profile_pic='$target' WHERE email='".$_SESSION["CURRENT_USER"]."';");  
                  header('Location:Userprofile.php'); 
              }
              else {
                  echo "<script>alert('File uploaded was not an image!');</script>";
              }
          }
        ?>

        <!-- Modal Structure -->
        <div id="modal_add_New_post" class="modal">
          <div class="modal-content">
            <div class="row">
            <form action="" class="col s12" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">title</i>
                  <input id="post_title" type="text" name="post_title" class="validate">
                  <label for="post_title">Post Title</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">create</i>
                  <textarea id="post_text" class="materialize-textarea" name="post_text"></textarea>
                  <label for="post_text">Post Text</label>
                </div>
              </div>

              <div class="row">
                <p><i class="material-icons prefix">add_location</i>&nbsp; <b> Select your location from below </b></p>
                <div id="mapCanvas"></div>
              </div>

              <div class="row" style="text-align: left;">
                <div class="input-field col s12">
                  <input type="text" name="latlng" id="info">
                  <label for="info" data-error="Invalid"></label>
                </div>  
              </div>

              <div class="row" style="text-align: left;">
                <div class="input-field col s12">
                  <input type="text" name="addr" id="address">
                  <label for="address" data-error="Invalid"></label>
                </div>  
              </div>
              
              <div class="row">
                <div class="file-field input-field col s12">
                  <div class="btn">
                    <span>Image</span>
                    <input id="post_pic" name="post_pic" type="file"  accept="image/*">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="No file selected">
                  </div>
                </div>
              </div>
              <div class="row">
                <p>
                  <input class="with-gap" name="post_privacy" type="radio" id="private" value="Private" checked />
                  <label for="private">Private</label>
                </p>
                <p>
                  <input class="with-gap" name="post_privacy" type="radio" id="friends" value="Friends"/>
                  <label for="friends">Friends</label>
                </p>
                <p>
                  <input class="with-gap" name="post_privacy" type="radio" id="Friends_of_Friends" value="Friends_of_Friends"/>
                  <label for="friends_of_friends">Friends of Friends</label>
                </p>
                <p>
                  <input class="with-gap" name="post_privacy" type="radio" id="public" value="Public"/>
                  <label for="public">Public</label>
                </p>
              </div>
              <div class="row">
                <div class="input-field center">
                <button class="btn waves-effect teal darken-1" type="submit" value="Upload" name="profile_post_submit" style="color: white;"> Submit <i class="material-icons right">send</i>
                </button>
                </div>
              </div>
            </form>
          </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class="modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <div id="modal_friendship" class="modal">
          <div class="modal-content">
            <div class="card large grey lighten-4">
              <div class="card-content">
              </div>
              <div class="card-tabs">
                <ul class="tabs tabs-icon tabs-fixed-width grey lighten-4 red-text text-accent-2">
                  <li class="tab"><a class="active" href="#test4">FRIENDS</a></li>
                  <li class="tab"><a class="red-text text-accent-2" href="#test5">PENDING REQUESTS</a></li>
                </ul>
              </div>
              <div class="card-content grey lighten-4">
                <div id="test4">
                  <div class="row">
                    <div class="col s12 m8">
                      <div class="card card-panel hoverable white">
                          <div class="row">
                            <div class="col s12">
                              <div class="col s4">
                                <img src="images/img_avatar.png" style="border-radius: 50%; width:100px;">
                              </div>
                              <div class="col s4">
                                <h5 style="padding-left: 50px"><b>UDITA GUPTA</b></h5>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div id="test5">
                  <div class="row">
                    <div class="col s12 m8">
                      <div class="card card-panel hoverable white">
                          <div class="row">
                            <div class="col s12">
                              <div class="col s4">
                                <img src="images/img_avatar.png" style="border-radius: 50%; width:100px;">
                              </div>
                              <div class="col s4">
                                <h5 style="padding-left: 50px"><b>UDITA GUPTA</b></h5>
                              </div>
                            </div>
                          </div>
                          <div class="col s4">
                            <a class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons">check_circle</i></a>
                          </div>
                          <div class="col s4">
                            <a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">cancel</i></a>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="Userprofile.php" class="modal-action modal-close waves-effect btn-flat">Done</a>
          </div>
        </div>

        <?php
          if(isset($_POST['profile_post_submit'])){
            $image = $_FILES['post_pic']['name'];
            $target =  "images/".basename($image);
            $addr = $_POST['addr'];
            $latlng = $_POST['latlng'];
            $array_latlng = explode(",", $latlng);
            $latitude = $array_latlng[0];
            $longitude = $array_latlng[1];
              
            if($_POST["post_privacy"]){
              $get_privacy_control_id = "select privacy_control_id from Privacy_control where privacy_control_type = '".$_POST["post_privacy"]."';";
              #echo $get_privacy_control_id;

              $result_get_privacy_control_id = mysqli_query($conn,$get_privacy_control_id);

              while($row = mysqli_fetch_row($result_get_privacy_control_id)) {
                $privacy_control_id = $row[0];
                #echo $privacy_control_id;
              }
              $add_location = "insert into Location(location_id, location_name, latitude, longitude) values(0, '".$addr."', '".$latitude."', '".$longitude."');";
              #echo $add_location;
              $result_add_location = mysqli_query($conn,$add_location) or die(mysqli_error());



              $add_post = "insert into Diary(title, student_id, body_text, body_multimedia, privacy_control_id, location_name) values('".$_POST["post_title"]."', ".$student_id.", '".$_POST["post_text"]."', '".$target."', ".$privacy_control_id.",'".$addr."');";
              #echo $add_post;
              $result_add_post_title = mysqli_query($conn,$add_post) or die(mysqli_error());

              #Add activity into activity table
              $get_just_added_diary_id = "select diary_id from Diary where title='".$_POST["post_title"]."';";
              $result_get_just_added_diary_id = mysqli_query($conn,$get_just_added_diary_id) or die(mysqli_error());



              while($row=mysqli_fetch_assoc($result_get_just_added_diary_id)){
                $just_added_diary_id = $row["diary_id"];
                echo $just_added_diary_id;
              }

              $add_activity_new_post = "insert into Student_activity(from_student_id, to_diary_id, activity_type, privacy_control_id) values(".$student_id.", ".$just_added_diary_id.", 'added post', ".$privacy_control_id.");";

              #echo $add_activity_new_post;

              $result_add_activity_new_post = mysqli_query($conn, $add_activity_new_post) or die(mysqli_error());

              }
            }
        ?>

      </div>
    </div>


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
        $('input#input_text, textarea#textarea1').characterCounter();
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
      $('input#input_text, textarea#textarea1').characterCounter();
    });
    </script>

  </body>
</html>


                  
