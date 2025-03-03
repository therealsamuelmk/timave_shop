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
     $exists = "SELECT COUNT(*) AS POSSIBLE FROM SELLER WHERE USER_PHONE_NUMBER = '".$username."'";
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
      $approval_status = "not approved";
      $validate = "SELECT * FROM SELLER WHERE USER_PHONE_NUMBER = '".$username."'";
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
      // creating a user session and updating the online status
      else{
        $online_status = "online";
        $status = mysqli_query($connect,"INSERT INTO ONLINE_STATUS(USER_ID,USER_STATUS) VALUES('".md5($username)."','".$online_status."')");
        $_SESSION["SELLER_SESSION"] = md5($username);
        header("location:index.php");
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
  <link href="../images/timave.jpg" rel="shortcut icon">
  <title>Timave</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/seller.css">
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Retailer Login</header>
      <form action="#" method="post" autocomplete="off">
        <input type="text" name="login_email" placeholder="Enter username" required>
        <input type="password" name="login_password" placeholder="Enter your password" required>
        <a href="#">Forgot password?</a>
        <input type="submit" name="login_button" class="button" value="Login">
      </form>
    </div>
  </div>
  <script src="../js/login.js" type="text/javascript"></script>
  <script src="seller.js" type="text/javascript"></script>
</body>
</html>