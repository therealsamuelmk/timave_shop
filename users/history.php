<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["USER_SESSION"]))
    {
        header("location:login.php");
    }
    $history = mysqli_query($connect,"SELECT * FROM PURCHASE WHERE USER_ID = '".$_SESSION["USER_SESSION"]."' AND PURCHASE_STATUS = 'disbursed'");
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" developed by Microlasan Technologies">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/history.css">
    <link href="../css/topnav.css" rel="stylesheet" type="text/css">
    <link href="../images/timave.jpg" rel="shortcut icon">
    <title>Timave</title>
</head>

<body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
        <div class="transaction-card">
            <h2><i class="ri-history-line"></i> Purchase History </h2>
            <hr>
            <?php
                while($transact = mysqli_fetch_array($history))
                {
                    $details = mysqli_fetch_array($item_details = mysqli_query($connect,"SELECT * FROM ITEM WHERE ITEM_ID = '".$transact["ITEM_ID"]."'"))
            ?>
            <div class="transaction">
                <div class="transaction-details">
                    <p><strong>Date:</strong> <?php echo(date($transact["PURCHASE_DATE"])) ?></p>
                    <p><strong>Description:</strong> <?php echo($details["ITEM_NAME"]) ?></p>
                    <p><strong>Unit Price: K</strong><?php echo($details["ITEM_PRICE"]) ?></p>
                    <p><strong>Quantity:</strong> <?php echo($transact["QUANTITY"]) ?></p>
                </div>
                <div class="transaction-amount positive">
                    K<?php echo($details["ITEM_PRICE"]) * $transact["QUANTITY"] ?>
                </div>
            </div>
            <hr>
            <?php
                }
            ?>
        </div>
        <div id="page" class="menu">
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
                <a class="nav-link active" href="history.php">
                    <i class="ri-history-line"></i>
                    <span class="nav-text">History</span>
                </a>
                <a class="nav-link" href="profile.php">
                    <i class="ri-user-3-line"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </nav>
        </div>
  </main>
</body>
</html>