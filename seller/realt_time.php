<?php
    include "../backend/connection.php";
    session_start();
    $purchase = mysqli_query($connect,"SELECT COUNT(*) AS TOTAL FROM PURCHASE WHERE SELLER_ID = '".$_SESSION["SELLER_SESSION"]."' AND PURCHASE_STATUS = 'not disbursed' ");
    $purchase_num = mysqli_fetch_array($purchase);

    $updated_value = $purchase_num["TOTAL"];
    echo($updated_value);
?>