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

    //items purchased by customer
    $purchase = mysqli_query($connect,"SELECT COUNT(*) AS TOTAL FROM PURCHASE WHERE SELLER_ID = '".$_SESSION["SELLER_SESSION"]."' AND PURCHASE_STATUS = 'not disbursed' ");
    $purchase_num = mysqli_fetch_array($purchase);

    //items disbursed
    $disbursed = mysqli_query($connect,"SELECT COUNT(*) AS TOTAL FROM PURCHASE WHERE SELLER_ID = '".$_SESSION["SELLER_SESSION"]."' AND PURCHASE_STATUS = 'disbursed' ");
    $disbursed_num = mysqli_fetch_array($disbursed);

    //items not disbursed to customer
    $not_disbursed = mysqli_query($connect,"SELECT * FROM PURCHASE WHERE SELLER_ID = '".$_SESSION["SELLER_SESSION"]."' AND PURCHASE_STATUS = 'not disbursed' ");

?>
<!DOCTYPE html>
<!-- Coding By microlasan-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developed by Microlasan Technolgies">
    <title>Timave Seller</title>
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="./css/admin.css">
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
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
    rel="stylesheet"
/>

    <title>Admin Dashboard Panel</title>
</head>
<body>
    <!-- MDB -->
    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"
    ></script>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">Admin</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="#">
                <div class="indicator"><?php echo($purchase_num["TOTAL"]) ?></div>
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
                    <div class="box box3">
                        <i class="ri-wallet-3-line"></i>
                        <span class="text">Total Income</span>
                        <span class="number">ZMW <?php echo($amount["COMMISSION_AMOUNT"]); ?></span>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                    <tr>
                    <th>Customer Name</th>
                    <th>Item Purchased</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($requests = mysqli_fetch_array($not_disbursed))
                        {
                            //fetch user_details
                            $user_details = mysqli_query($connect,"SELECT * FROM USERS WHERE USER_ID = '".$requests["USER_ID"]."' ");
                            $user_fetch = mysqli_fetch_array($user_details);

                            //fetch item details
                            $item_details = mysqli_query($connect,"SELECT * FROM ITEM WHERE ITEM_ID = '".$requests["ITEM_ID"]."' ");
                            $item_fetch = mysqli_fetch_array($item_details);
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                            <img
                                src="../images/profile_photos/<?php echo($user_fetch["PROFILE_PICTURE"]); ?>"
                                class="rounded-circle"
                                alt=""
                                style="width: 45px; height: 45px"
                                />
                            <div class="ms-3">
                                <p class="fw-bold mb-1"><?php echo($user_fetch["USER_FULL_NAME"]); ?></p>
                                <p class="text-muted mb-0"><?php echo($user_fetch["USER_EMAIL_ADDRESS"]); ?></p>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="fw-normal mb-1"><?php echo($item_fetch["ITEM_NAME"]); ?></p>
                            <p class="text-muted mb-0"><b>QNTY: <?php echo($requests["QUANTITY"]); ?></b></p>
                        </td>
                        <td>
                            <span class="badge badge-primary rounded-pill d-inline"
                                ><a href="tel:<?php echo($user_fetch["USER_PHONE_NUMBER"]); ?>"><?php echo($user_fetch["USER_PHONE_NUMBER"]); ?></a></span
                            >
                        </td>
                        <td><?php echo($requests["USER_DISTRICT"]); ?><br> <?php echo($requests["USER_ADDRESS"]); ?></td>
                        <td>
                            <form method="post">
                                <button type="submit" class="btn btn-link btn-rounded btn-sm fw-bold" data-mdb-ripple-color="dark" name="ITM<?php echo($requests["PURCHASE_ID"]); ?>">
                                Disburse
                                </button>
                            </form>
                            <?php
                                if(isset($_POST["ITM".$requests["PURCHASE_ID"]]))
                                {
                                    //comminssion
                                    $income = ($item_fetch["ITEM_PRICE"] * $requests["QUANTITY"]);
                                    $commission = mysqli_query($connect,"UPDATE COMMISSION SET COMMISSION_AMOUNT = COMMISSION_AMOUNT + $income WHERE USER_ID = '".$_SESSION["SELLER_SESSION"]."'");
                                    $app_commission = mysqli_query($connect, "UPDATE APP_COMMISSION SET COMMISSION_AMOUNT = COMMISSION_AMOUNT + $income WHERE ID = 1");
                                    $item_status = mysqli_query($connect,"UPDATE PURCHASE SET PURCHASE_STATUS  = 'disbursed' WHERE PURCHASE_ID = '".$requests["PURCHASE_ID"]."' ");
                                    echo(
                                        "
                                            <script>
                                                alert('Item Disbursed Successfully, you are advised to contact the buyer');
                                                window.location.assign('purchase.php');
                                            </script>
                                        "
                                    );
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
                </table>
        </div>
    </section>

    <script src="./js/admin.js"></script>
</body>
</html>