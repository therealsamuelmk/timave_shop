<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["ADMIN_SESSION"]))
    {
        header("location:login.php");
    }

?>
<!DOCTYPE html>
<!-- Coding by microlasan-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Admin Dashboard </title>
    <link rel="stylesheet" href="admin.css">
    <meta name="description" content="Developed by Microlasan Technolgies">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
      rel="stylesheet"
    />
    <link href="../images/timave.jpg" rel="shortcut icon" >
   </head>
<body>
  <!-- MDB -->
  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"
  ></script>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-cart'></i>
      <span class="logo_name">Timave</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="./dashboard.php">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#" class="active">
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
          <a href="sellers.php" >
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
        <span class="dashboard">Stock Management</span>
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

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">New Stock</div>
            <div class="sales-details">
              <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                  <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date Posted</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $product = mysqli_query($connect, "SELECT * FROM ITEM ORDER BY POST_DATE DESC");
                    while($items = mysqli_fetch_array($product))
                    {
                ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <img
                            src="../images/item_photos/<?php echo($items["ITEM_PICTURE"]) ?>"
                            alt=""
                            style="width: 45px; height: 45px"
                            class="rounded-circle"
                            />
                        <div class="ms-3">
                          <p class="fw-bold mb-1"><?php echo($items["ITEM_NAME"]) ?></p>
                          <p class="text-muted mb-0"><?php echo($items["ITEM_QUANTITY"]) ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="fw-normal mb-1"><?php echo($items["ITEM_PRICE"]) ?></p>
                      <p class="text-muted mb-0">ZMW</p>
                    </td>
                    <td>
                      <button type="button" class="btn btn-link btn-sm btn-rounded">
                      <?php echo($items["POST_DATE"]) ?>
                      </button>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="top-sales box">
            <div class="title">Top selling</div>
            <ul class="top-sales-details">
                <?php
                    //TOP SELLING PRODUCTS
                    $item = "SELECT * FROM ITEM ORDER BY POST_DATE DESC LIMIT 10";
                    $query = mysqli_query($connect,$item);
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