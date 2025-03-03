<?php
  session_start();
  include "../backend/connection.php";
  if(isset($_POST["login_button"]))
  {
     //capturing the data entered in the fields
     $username = $_POST["login_email"];
     $pass = $_POST["login_password"];
     // convert the password to md5 encription
     $pass = md5($pass);

     //checking if the user exists
     $exists = "SELECT COUNT(*) AS POSSIBLE FROM ADMIN WHERE ADMIN_ID = '".md5($username)."'";
     $find = mysqli_query($connect, $exists);
     $does_exist = mysqli_fetch_array($find);

     if($does_exist["POSSIBLE"]<1)
     {
      ?>
        <script>
          alert("Sorry, there is no admin with this username, please contact webmaster");
        </script>
      <?php
     }
     //checking if the password inserted matches the database password
     else{

      $validate = "SELECT * FROM ADMIN WHERE ADMIN_ID = '".md5($username)."'";
      $fetch = mysqli_query($connect,$validate);
      $validated = mysqli_fetch_array($fetch);

      if($validated["ADMIN_PASSWORD"] != $pass)
      {
        ?>
          <script>
            alert("Incorrect Password, Try again");
          </script>
        <?php
      }
      // creating a user session and updating the online status
      else{
        $online_status = "online";
        $status = mysqli_query($connect,"INSERT INTO ONLINE_STATUS(USER_ID,USER_STATUS) VALUES('".md5($username)."','".$online_status."')");
        $_SESSION["ADMIN_SESSION"] = md5($username);
        header("location:./dashboard.php");
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
  <meta name="description" content="Developed by Microlasan Technolgies">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Timave</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="seller.css">
  <link href="../images/timave.jpg" rel="shortcut icon">
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Admin Login</header>
      <form action="#" method="post" autocomplete="off">
        <input type="text" name="login_email" placeholder="Administrator ID" required>
        <input type="password" name="login_password" placeholder="Enter your password" required>
        <a href="#">Forgot password?</a>
        <input type="submit" name="login_button" class="button" value="Login">
      </form>
      <div class="signup">
      </div>
    </div>
  </div>
  <script src="../js/login.js" type="text/javascript"></script>
  <script src="seller.js" type="text/javascript"></script>
</body>
</html>