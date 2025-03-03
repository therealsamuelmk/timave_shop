<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["ADMIN_SESSION"]))
    {
        header("location:./index.php");
    }
    //TOP SELLING PRODUCTS
    $item = "SELECT * FROM ITEM ORDER BY POST_DATE DESC LIMIT 10";
    $query = mysqli_query($connect,$item);
    //TOTAL OERDERS
    $cart = "SELECT COUNT(*) AS TOTAL FROM CART";
    $query_1 = mysqli_query($connect, $cart);
    $cart_num = mysqli_fetch_array($query_1);
    //TOTAL USERS
    $user = "SELECT COUNT(*) AS TOTAL FROM USERS";
    $query_5 = mysqli_query($connect, $user);
    $user_num = mysqli_fetch_array($query_5);
    //TOTAL USERS ACTIVE
    $active= "SELECT COUNT(*) AS TOTAL FROM ONLINE_STATUS WHERE USER_STATUS = 'online'";
    $query_6 = mysqli_query($connect, $active);
    $active_num = mysqli_fetch_array($query_6);
    //COMMISSION
    $data=mysqli_query($connect,"SELECT * FROM APP_COMMISSION WHERE ID = 1");
    $app_commission = mysqli_fetch_array($data);

?>
<!DOCTYPE html>
<!-- Coding by microlasan-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Timave Admin </title>
    <meta name="description" content="Developed by Microlasan Technolgies">
    <link href="../images/timave.jpg" rel="shortcut icon">
    <link rel="stylesheet" href="./admin.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-cart'></i>
      <span class="logo_name">Timave</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="#" class="active">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>

        <li>
          <a href="stock.php">
            <i class='bx bx-coin-stack' ></i>
            <span class="links_name">Stock</span>
          </a>
        </li>

        <li>
          <a href="users.php">
            <i class='bx bx-user' ></i>
            <span class="links_name">users</span>
          </a>
        </li>
        <li>
          <a href="sellers.php">
            <i class='bx bx-user' ></i>
            <span class="links_name">Sellers</span>
          </a>
        </li>
        <li class="log_out">
          <a href="./logout.php">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <img src="images/profile.jpg" alt="">
        <span class="admin_name">Admin</span>
        <i class='bx bx-chevron-down' ></i>
      </div>
    </nav>

    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Orders</div>
            <div class="number"><?php echo($cart_num["TOTAL"]) ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Cumulative</span>
            </div>
          </div>
          <i class='bx bx-cart-alt cart'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Users</div>
            <div class="number"><?php echo($user_num["TOTAL"]) ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Cumulative</span>
            </div>
          </div>
          <i class='bx bxs-user cart two' ></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Profit</div>
            <div class="number">ZMW<?php echo($app_commission["COMMISSION_AMOUNT"]) ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Cumulative</span>
            </div>
          </div>
          <i class='bx bx-wallet cart three' ></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Users Online</div>
            <div class="number"><?php echo($active_num["TOTAL"]) ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Cumulative</span>
            </div>
          </div>
          <i class='bx bxs-badge-check cart two' ></i>
        </div>
      </div>
    <?php
    /* fetching recent 20 users eho have joined the platform */
    $info_1 = "SELECT USER_FULL_NAME, JOINED_DATE FROM USERS ORDER BY JOINED_DATE DESC LIMIT 20";
    $query_2 = mysqli_query($connect,$info_1);

    $info_2 = "SELECT USER_PHONE_NUMBER, JOINED_DATE FROM USERS ORDER BY JOINED_DATE DESC LIMIT 20";
    $query_3 = mysqli_query($connect,$info_2);

    $info_3 = "SELECT USER_PHONE_NUMBER, JOINED_DATE FROM USERS ORDER BY JOINED_DATE DESC LIMIT 20";
    $query_4 = mysqli_query($connect,$info_3);
    ?>
      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Recent Joined Users</div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Customer Name</li>
                <?php
                    while($names = mysqli_fetch_array($query_2))
                    {
                ?>
                <li><a href="#"><?php echo($names["USER_FULL_NAME"]) ?></a></li>
                <?php
                    }
                ?>
                
            </ul>
            <ul class="details">
            <li class="topic">Customer Phone</li>
                <?php
                    while($names_2 = mysqli_fetch_array($query_3))
                    {
                ?>
                <li><a href="tel:<?php echo($names_2["USER_PHONE_NUMBER"]) ?>"><?php echo($names_2["USER_PHONE_NUMBER"]) ?></a></li>
                <?php
                    }
                ?>
          </ul>

          <ul class="details">
            <li class="topic">Date Joined</li>
                <?php
                    while($names_3 = mysqli_fetch_array($query_4))
                    {
                ?>
                <li><a href="#"><?php echo($names_3["JOINED_DATE"]) ?></a></li>
                <?php
                    }
                ?>

          </ul>
          </div>
        </div>
        <div class="top-sales box">
          <div class="title">Top Selling Product</div>
          <ul class="top-sales-details">
              <?php
                  while($display_items = mysqli_fetch_array($query))
                  {
              ?>
              <li>
                  <a href="#">
                  <img src="../images/item_photos/<?php echo($display_items["ITEM_PICTURE"])?>" alt="">
                  <span class="product"><?php echo($display_items["ITEM_NAME"])?></span>
                  </a>
                  <span class="price">ZMW <?php echo($display_items["ITEM_PRICE"])?></span>
              </li>
              <?php
                  }
              ?>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

</body>
</html>