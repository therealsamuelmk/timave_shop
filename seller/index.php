<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["SELLER_SESSION"]))
    {
        header("location:login.php");
    }
    //fetching all the items posted by the seller
    $recent_item = "SELECT * FROM ITEM WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'";
    $execute = mysqli_query($connect, $recent_item);
    $posted_items = mysqli_fetch_array($execute);

    //counting the posted item
    $num = "SELECT COUNT(*) AS TOTAL FROM ITEM WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'";
    $query = mysqli_query($connect, $num);
    $items_num = mysqli_fetch_array($query);

    //counting the amount of commision
    $cash = "SELECT COMMISSION_AMOUNT FROM APP_COMMISSION WHERE ID = 1";
    $find = mysqli_query($connect, $cash);
    $amount = mysqli_fetch_array($find);

    //items disbursed
    $disbursed = mysqli_query($connect,"SELECT COUNT(*) AS TOTAL FROM PURCHASE WHERE SELLER_ID = '".$_SESSION["SELLER_SESSION"]."' AND PURCHASE_STATUS = 'disbursed' ");
    $disbursed_num = mysqli_fetch_array($disbursed);
?>
<!DOCTYPE html>
<!-- Coding By microlasan-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Developed by Microlasan Technolgies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="./css/admin.css">
    <link href="../images/timave.jpg" rel="shortcut icon">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <title>Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">Admin</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="purchase.php">
                <div class="indicator" id="requests"></div>

                <script>
                    function fetchData() {
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', './realt_time.php', true);
                        xhr.onload = function() {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                document.getElementById('requests').innerHTML = xhr.responseText;
                            } else {
                                console.error('AJAX Error: ' + xhr.statusText);
                            }
                        };
                        xhr.onerror = function() {
                            console.error('AJAX Error: ' + xhr.statusText);
                        };
                        xhr.send();
                    }

                    // Call fetchData every 1 seconds
                    setInterval(fetchData, 1000);

                    // Initial fetch
                    fetchData();
                </script>
                <i class="ri-luggage-cart-line"></i>
                    <span class="link-name">Request </span>
                </a></li>
                <li><a href="post_item.php">
                    <i class="ri-store-2-line"></i>
                    <span class="link-name">Sell Item</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="./logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="ri-shopping-bag-line"></i>
                        <span class="text">Total Items</span>
                        <span class="number"><?php echo($items_num["TOTAL"]) ?></span>
                    </div>
                    <div class="box box2">
                        <i class="ri-shopping-cart-line"></i>
                        <span class="text">Total Disbursed</span>
                        <span class="number"><?php echo($disbursed_num["TOTAL"]) ?></span>
                    </div>
                    <!-- <div class="box box3">
                        <i class="ri-wallet-3-line"></i>
                        <span class="text">Amount Made</span>
                        <span class="number">ZMW <?php echo($amount["COMMISSION_AMOUNT"]); ?></span>
                    </div> -->
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent products</span>
                </div>
                <!-- recycler adapter for the item -->
                <?php
                    $recycler_1 = "SELECT ITEM_NAME FROM ITEM WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'";
                    $display_1 = mysqli_query($connect,$recycler_1);

                    $recycler_2 = "SELECT ITEM_QUANTITY FROM ITEM WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'";
                    $display_2 = mysqli_query($connect,$recycler_2);

                    $recycler_3 = "SELECT POST_DATE FROM ITEM WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'";
                    $display_3 = mysqli_query($connect,$recycler_3);
                 ?>
                <div class="activity-data">
                    <div class="data names">
                        <span class="data-title">Product Name</span>
                        <?php
                            while($names = mysqli_fetch_array($display_1))
                            {
                        ?>
                        <span class="data-list"><?php echo($names["ITEM_NAME"]) ?></span>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="data status">
                        <span class="data-title">Quantity</span>
                        <?php
                            while($quantity = mysqli_fetch_array($display_2))
                            {
                        ?>
                        <span class="data-list"><?php echo($quantity["ITEM_QUANTITY"]) ?></span>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title">Post Date</span>
                        <?php
                            while($date = mysqli_fetch_array($display_3))
                            {
                        ?>
                        <span class="data-list"><?php echo($date["POST_DATE"]) ?></span>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="./js/admin.js"></script>
</body>
</html>