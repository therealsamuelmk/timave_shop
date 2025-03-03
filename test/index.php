<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../images/pamarket-logo-3.png" rel="shortcut icon">
    <title>Ride</title>
    <link href="../css/main.css" rel="stylesheet" type="text/css">
    <link href="../css/topnav.css" rel="stylesheet" type="text/css">
    <link
            href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
            rel="stylesheet"
        />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUmrsht0tDXvnhoT6ZnSc_OO8NBHW0fPo&callback=initMap&maptype=satellite" async defer></script>
    <style>
        #map {
            height: 900px;
            width: 100%;
            max-width: 100%;
            margin-bottom:30px;
            margin-top: 70px;
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <button type="submit">Search</button>
        </div>
    </nav>
    <div id="map"></div>
    <!-- bottom navigation menu -->
    <div id="page" class="menu">
    <nav class="nav">
            <a class="nav-link" href="shop.php">
                <i class="ri-shopping-bag-line"></i>
                <span class="nav-text">Shopping</span>
            </a>
            <a class="nav-link active" href="#">
                <i class="ri-taxi-line"></i>
                <span class="nav-text">Ride</span>
            </a>
            <a class="nav-link" href="ads.php">
                <i class="ri-fire-line"></i>
                <span class="nav-text">Ads</span>
            </a>
            <a class="nav-link" href="profile.php">
                <i class="ri-user-3-line"></i>
                <span class="nav-text">Profile</span>
            </a>
    </nav>
</div>
    <script>
        // Sample locations with custom pin icons
        var locations = [
            <?php 
                $my_location = mysqli_query($connect, "SELECT * FROM USER_LOCATION WHERE USER_ID = '".$_SESSION["USER_SESSION"]."'");
                $my_pin = mysqli_fetch_array($my_location);

                $locations = mysqli_query($connect, "SELECT * FROM CURRENT_LOCATION");
                while($pin = mysqli_fetch_array($locations))
                {
            ?>
            { lat:<?php echo($pin["LATITUDE"]) ?>, lng: <?php echo($pin["LONGITUDE"]) ?>, title: 'driver', icon: '../images/icons/pin2.png' },
            // Add more locations as needed
            <?php 
                }
            ?>
             { lat:<?php echo($my_pin["LATITUDE"]) ?>, lng: <?php echo($my_pin["LONGITUDE"]) ?>, title: 'me', icon: '../drivers/icons/user_location.png' }
        ];

        function initMap() {
            <?php 
                $user_locations = mysqli_query($connect, "SELECT * FROM USER_LOCATION WHERE USER_ID = '".$_SESSION["USER_SESSION"]."'");
                $user_pin = mysqli_fetch_array($user_locations);
            ?>
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: <?php echo($user_pin["LATITUDE"]) ?>, lng: <?php echo($user_pin["LONGITUDE"]) ?> },
                 
                zoom: 18
            });

            // Add markers to the map
            for (var i = 0; i < locations.length; i++) {
                var location = locations[i];
                var marker = new google.maps.Marker({
                    position: { lat: location.lat, lng: location.lng },
                    map: map,
                    title: location.title,
                    icon: location.icon
                });
            }
        }
    </script>
</body>
</html>
