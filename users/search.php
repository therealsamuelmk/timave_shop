<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["USER_SESSION"]))
    {
        header("location:login.php");
    }
    elseif(!isset($_GET['search_item'])){
        header("location:shop.php");

    }
    else{

        $search_query = isset($_GET['search_item']) ? $_GET['search_item'] : '';

        $search_query = mysqli_real_escape_string($connect, $search_query);

        
        if (!empty($search_query)) {
            $sql = "SELECT * FROM ITEM WHERE ITEM_NAME LIKE '%$search_query%' AND ITEM_QUANTITY > 0";
            $result = mysqli_query($connect, $sql);
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" developed by Microlasan Technologies">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/shop.css">
    <link href="../css/topnav.css" rel="stylesheet" type="text/css">
    <link href="../images/timave.jpg" rel="shortcut icon">
    <title>Timave</title>
</head>

<body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
        <div class="products">
            <?php
                while($item = mysqli_fetch_array($result))
                {
                   
            ?>
            <div class="product-card" id="<?php echo($item["ITEM_ID"]) ?>">
                <img src="../images/item_photos/<?php echo($item["ITEM_PICTURE"]) ?>" alt="Product Image" class="product-image">
                <div class="product-info"> 
                    <h3 class="product-title"><?php echo($item["ITEM_NAME"]) ?></h3>
                    <p class="product-owner">By: TIMAVE  <i class="ri-verified-badge-fill" style="color: blue;"></i></p>
                    <p class="product-price">ZMW <?php echo($item["ITEM_PRICE"]) ?></p>
                    <button class="add-to-cart-btn" ><a href="single_item.php?id=<?php echo($item["ITEM_ID"]) ?>" class="cart_btn">View (<?php echo($item["ITEM_QUANTITY"]) ?> Remaining)</a></button>
                </div>
            </div>
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
                <a class="nav-link" href="ads.php">
                    <i class="ri-fire-line"></i>
                    <span class="nav-text">Ads</span>
                </a>
                <a class="nav-link" href="profile.php">
                    <i class="ri-user-3-line"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <a class="nav-link active" href="history.php">
                    <i class="ri-history-line"></i>
                    <span class="nav-text">History</span>
                </a>
            </nav>
        </div>
    </main>
</body>
</html>