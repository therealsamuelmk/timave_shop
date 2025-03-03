<?php
    include "../backend/connection.php";
    include "./register.php";
    session_start();
    if(!isset($_SESSION["ADMIN_SESSION"]))
    {
        header("location:./index.php");
    }

?>
<!DOCTYPE html>
<!-- Coding by microlasan-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Developed by Microlasan Technolgies">
    <title> Admin Dashboard </title>
    <link rel="stylesheet" href="admin.css">
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
    <link href="../images/timave.jpg" rel="shortcut icon">
    <link href="./form.css" rel="stylesheet">
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
          <a href="#"  class="active">
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
        <span class="dashboard">Selers Management</span>
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
          <div class="title">Register Seller</div>
            <div class="sales-details">
            <div class="container">
                <div class="content">
                  <!-- Registration form -->
                  <form  action="#" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="user-details">
                      <!-- Input for Full Name -->
                      <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" name="full_name" placeholder="Enter your name" required>
                      </div>
                      <!-- Input for Username -->
                      <div class="input-box">
                        <span class="details">Profile Picture</span>
                        <input type="file" name="profile_image" required>
                      </div>
                      <!-- Input for Email -->
                      <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" name="email_address" placeholder="Enter your email" required>
                      </div>
                      <!-- Input for Phone Number -->
                      <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phone_number" placeholder="Enter your number" required>
                      </div>
                      <!-- Input for Password -->
                      <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password" placeholder="Enter your password" required>
                      </div>
                      <!-- Input for Confirm Password -->
                      <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                      </div>
                    </div>
                    <!-- Submit button -->
                    <div class="button">
                      <input type="submit" name="signup_button" value="Register">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="top-sales box">
          <div class="title">Approved Sellers</div>
            <div class="top-sales-details">
            <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                  <tr>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $workers = mysqli_query($connect, "SELECT * FROM SELLER ");
                    while($details = mysqli_fetch_array($workers))
                    {
                ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <img
                            src="../images/profile_photos/<?php echo($details["PROFILE_PICTURE"]) ?>"
                            alt=""
                            style="width: 45px; height: 45px"
                            class="rounded-circle"
                            />
                        <div class="ms-3">
                          <p class="fw-bold mb-1"><?php echo($details["USER_FULL_NAME"]) ?></p>
                          <p class="text-muted mb-0"><?php echo($details["USER_EMAIL_ADDRESS"]) ?></p>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
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