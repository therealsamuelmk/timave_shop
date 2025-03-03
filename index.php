<?php
    include "./backend/connection.php";
    $checking = mysqli_query($connect,"SELECT COUNT(*) AS ITEMS FROM ITEM");
    $validated = mysqli_fetch_array($checking);
    if($validated["items"]<1)
    {
        header("location:home.html");
    }
    else{
        $products = "SELECT * FROM ITEM WHERE ITEM_QUANTITY > 0 ORDER BY POST_DATE DESC";
        $display = mysqli_query($connect,$products);
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
    <title>Timave</title>
</head>

<body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
        <nav class="top-nav">
            <form method="get" action="search.php">
                <div class="search-bar">
                    <input type="text" placeholder="Search..." name="search_item" required>
                    <button type="submit">Search</button>
                </div>
            </form>
        </nav>
        <div id="searchResults"></div>
        <div class="products">
            <?php
                while($item = mysqli_fetch_array($display))
                {
                    //finding the seller
                    $seller = mysqli_query($connect, "SELECT BUSINESS_NAME,USER_PHONE_NUMBER FROM SELLER WHERE USER_ID = '".$item["USER_ID"]."'");
                    $name = mysqli_fetch_array($seller);
            ?>
            <div class="product-card" id="<?php echo($item["ITEM_ID"]) ?>">
                <img src="./images/item_photos/<?php echo($item["ITEM_PICTURE"]) ?>" alt="Product Image" class="product-image">
                <div class="product-info"> 
                    <h3 class="product-title"><?php echo($item["ITEM_NAME"]) ?></h3>
                    <p class="product-owner">By: <?php echo($name["BUSINESS_NAME"]) ?> <i class="ri-verified-badge-fill" style="color: blue;"></i></p>
                    <p class="product-owner">Call: <a href="tel:<?php echo($name["USER_PHONE_NUMBER"]) ?>"><?php echo($name["USER_PHONE_NUMBER"]) ?></a></p>
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