<?php
    include "./backend/connection.php";
    session_start();

    if(!isset($_GET['search_item'])){
        header("location:index.php");

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
    <link rel="stylesheet" href="./css/shop.css">
    <link href="./css/topnav.css" rel="stylesheet" type="text/css">
    <link href="./images/timave.jpg" rel="shortcut icon">
    <title>Pa Market</title>
</head>

<body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
        <div class="products">
            <div class="logo-cart">
                <a href="index.php#<?php echo($item["ITEM_ID"]) ?>"><i class='bx bx-arrow-back'></i>Back</a>
            </div>
            <?php
                while($item = mysqli_fetch_array($result))
                {
                    //finding the seller
                    $seller = mysqli_query($connect, "SELECT BUSINESS_NAME FROM SELLER WHERE USER_ID = '".$item["USER_ID"]."'");
                    $name = mysqli_fetch_array($seller);
            ?>
            <div class="product-card" id="<?php echo($item["ITEM_ID"]) ?>">
                <img src="./images/item_photos/<?php echo($item["ITEM_PICTURE"]) ?>" alt="Product Image" class="product-image">
                <div class="product-info"> 
                    <h3 class="product-title"><?php echo($item["ITEM_NAME"]) ?></h3>
                    <p class="product-owner">By: <?php echo($name["BUSINESS_NAME"]) ?> <i class="ri-verified-badge-fill" style="color: blue;"></i></p>
                    <p class="product-price">ZMW <?php echo($item["ITEM_PRICE"]) ?></p>
                    <button class="add-to-cart-btn" ><a href="single_item.php?id=<?php echo($item["ITEM_ID"]) ?>" class="cart_btn">View (<?php echo($item["ITEM_QUANTITY"]) ?> Remaining)</a></button>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
  </main>
</body>
</html>