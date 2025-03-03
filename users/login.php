<?php
  session_start();
  if(isset($_SESSION["USER_SESSION"]))
  {
    header("location:shop.php");
  }
  include "../backend/connection.php";
  if(isset($_POST["signup_button"]))
  {
    //capturing the data entered in the fields
    $names = $_POST["full_name"];
    $phone = $_POST["phone_number"];
    $mail = $_POST["email_address"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    //checking whether the passwords entered are matching

    if($password != $confirm)
    {
      ?>
        <script>
          alert("Sorry the passwords do not match");
        </script>
      <?php
    }
    //checking if the user already exists
    else{
      $verification = "SELECT COUNT(*) AS POSSIBLE FROM USERS WHERE USER_PHONE_NUMBER = '".$phone."'";
      $search = mysqli_query($connect,$verification);
      $found = mysqli_fetch_array($search);
      if($found["POSSIBLE"]>0)
      {
        ?>
          <script>
            alert("Sorry this phone already has a user registered");
          </script>
        <?php
      }
      //registering the user
      else{
        //capturing the image
        $picture = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];
        $folder = "../images/profile_photos/" .$picture; 
        //encrypting the entered password to md5
        $password = md5($password); 
        $register = "INSERT INTO USERS(USER_ID, USER_FULL_NAME,	USER_PHONE_NUMBER,	USER_EMAIL_ADDRESS, PROFILE_PICTURE,	USER_PASSWORD) VALUES('".md5($phone)."','".$names."','".$phone."','".$mail."','".$picture."','".$password."') ";
        $enterd = mysqli_query($connect,$register);
        if(!$enterd)
        {
          ?>
            <script>
              alert("Sorry could not register because: <?php echo(mysqli_error($connect)) ?> ");
            </script>
          <?php
        }
        else{
          move_uploaded_file($tempname,$folder);
          ?>
            <script>
              alert("Congratulations, you have successfully been registered");
            </script>
          <?php
        }
      }
    }
  }
  //LOGIN BACKEND PROCESS
  if(isset($_POST["login_button"]))
  {
     //capturing the data entered in the fields
     $username = $_POST["login_email"];
     $pass = $_POST["login_password"];

     // convert the password to md5 encription
     $pass = md5($pass);

     //checking if the user exists
     $exists = "SELECT COUNT(*) AS POSSIBLE FROM USERS WHERE USER_PHONE_NUMBER = '".$username."'";
     $find = mysqli_query($connect, $exists);
     $does_exist = mysqli_fetch_array($find);

     if($does_exist["POSSIBLE"]<1)
     {
      ?>
        <script>
          alert("Sorry, this phone number is not registered with any account, please register");
        </script>
      <?php
     }
     //checking if the password inserted matches the database password
     else{
      $validate = "SELECT * FROM USERS WHERE USER_PHONE_NUMBER = '".$username."'";
      $fetch = mysqli_query($connect,$validate);
      $validated = mysqli_fetch_array($fetch);

      if($validated["USER_PASSWORD"] != $pass)
      {
        ?>
          <script>
            alert("Incorrect Password, Try again");
          </script>
        <?php
      }
      // creating a user session and updating the online status and location
      else{
        $online_status = "online";
        $status = mysqli_query($connect,"INSERT INTO ONLINE_STATUS(USER_ID,USER_STATUS) VALUES('".md5($username)."','".$online_status."')");
        $_SESSION["USER_SESSION"] = md5($username);
        header("location:shop.php");
      }
     }
  }
?>
<!DOCTYPE html>
<!-- Coding By microlasan technologies -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content=" developed by Microlasan Technologies">
  <title>Timave</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="../css/login.css">
  <link href="../images/timave.jpg" rel="shortcut icon">
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form" id="login">
      <header>User Login</header>
      <form action="#" method="post" autocomplete="off" class="myForm">
        <input type="text" name="login_email" placeholder="Enter your phone number" required>
        <input type="password" name="login_password" placeholder="Enter your password" required>

        <a href="#">Forgot password?</a>
        <input type="submit" name="login_button" class="button" value="Login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
         <label for="check">Signup</label>
        </span>
      </div>
    </div>
    <div class="registration form" id="signup">
      <header>Signup</header>
      <div class="image">
          <img src="../icons/place_holder.jpg" alt="photo" class="profile-pic" id="selectedImage">
      </div>
      <br>
      <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">
        <input type="text" name="full_name" placeholder="Enter your Full Name" required>
        <input type="text" name="phone_number" placeholder="Enter your Phone" required>
        <input type="email" name="email_address" placeholder="Enter your email" required>
        <div class="custom-file-input">
          <label for="fileInput">Choose a profile picture</label>
          <input type="file" id="fileInput" name="profile_image" onchange="displayFileName(this)" required>
          <div class="file-name" id="fileName"></div>
        </div>
        <input type="password" name="password" placeholder="Create a password" required>
        <input type="password" name="confirm_password" placeholder="Confirm your password" required>
        <input type="submit" name="signup_button" class="button" value="Signup">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
  <script src="../js/login.js" type="text/javascript"></script>
</body>
</html>