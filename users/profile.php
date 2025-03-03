<?php
include "../backend/connection.php";
session_start();
if(!isset($_SESSION["USER_SESSION"]))
{
    header("location:login.php");
}
else{
    $details = mysqli_query($connect,"SELECT * FROM USERS WHERE USER_ID = '".$_SESSION["USER_SESSION"]."' ");
    $fetched = mysqli_fetch_array($details);

    //count number of purchases made
    $view = mysqli_query($connect,"SELECT COUNT(*) AS TOTAL FROM PURCHASE WHERE USER_ID = '".$_SESSION["USER_SESSION"]."'");
    $purchases = mysqli_fetch_array($view);

    //count number of rides made
}
?>
<!DOCTYPE html>
<!-- Coding By microlasan -->
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content=" developed by Microlasan Technologies">
    <title> Timave </title>
    <!---Custom Css File!--->
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/shop.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="../images/timave.jpg" rel="shortcut icon">
  </head>
  <body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
      <section class="main">
        <div class="profile-card">
          <div class="image">
            <img src="../images/profile_photos/<?php echo($fetched["PROFILE_PICTURE"]) ?>" alt="" class="profile-pic">
          </div>
          <div class="data">
            <h3><?php echo($fetched["USER_FULL_NAME"]) ?></h3>
            <span>(+26) <?php echo($fetched["USER_PHONE_NUMBER"]) ?></span>
          </div>
          <div class="row">
            <div class="info">
              <h3>Purchases</h3>
              <span><?php echo($purchases["TOTAL"]) ?></span>
            </div>
            <div class="info">
              <h3>Returns</h3>
              <span><?php /* echo($show["TOTAL"])  */?></span>
            </div>
          </div>
          <br>
          <div class="container">
            <header>
              <span class="logo">
                <img src="../icons/logo.png" alt="" />
                <h5>User Master Card</h5>
              </span>
              <img src="../icons/chip.png" alt="" class="chip" />
            </header>
            <div class="card-details">
              <div class="name-number">
                <h6>Mobile Money Number</h6>
                <h5 class="number">(+26) <?php echo($fetched["USER_PHONE_NUMBER"]) ?> ZM</h5>
                <h5 class="name"><?php echo($fetched["USER_FULL_NAME"]) ?></h5>
              </div>
              <div class="valid-date">
                <h6>Valid Thru</h6>
                <h5>05/28</h5>
              </div>
            </div>
          </div>
          <div class="buttons">
            <a href="../backend/logout.php" class="btn"><i class="ri-logout-box-r-line"></i> Exit</a>
            <a href="./cart.php" class="btn"><i class="ri-shopping-cart-fill"></i>Cart</a>
            <a href="./help.html" class="btn"><i class="ri-questionnaire-line"></i>Help</a>
          </div>
          <br>
          <br>
          <br>
        </div>
      </section>
        <nav class="nav">
            <a class="nav-link" href="shop.php">
                <i class="ri-shopping-bag-line"></i>
                <span class="nav-text">Shop</span>
            </a>
            <a class="nav-link" href="custom.php">
                    <i class="ri-scissors-cut-fill"></i>
                    <span class="nav-text">Custom</span>
            </a>
            <a class="nav-link" href="cart.php">
                <i class="ri-shopping-cart-line"></i>
                <span class="nav-text">Cart</span>
            </a>
            <a class="nav-link" href="history.php">
                <i class="ri-history-line"></i>
                <span class="nav-text">History</span>
            </a>
            <a class="nav-link active" href="profile.php">
                <i class="ri-user-3-line"></i>
                <span class="nav-text">Profile</span>
            </a>
        </nav>
    </main>
  </body>
</html>