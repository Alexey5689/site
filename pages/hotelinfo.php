<?php
    session_start();
    include_once ("function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/info.css">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_GET['hotel'])){
            $hotel=$_GET['hotel'];
            $mysqli= connect();
            $sel = 'SELECT hotel, city, country, info 
                    FROM hotels h, countries co, cities ci 
                    WHERE h.countryid=co.id AND h.cityid=ci.id AND h.id = ' . $hotel;
            $res=mysqli_query($mysqli, $sel);

            // выбраный отель
            $hotel_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
            mysqli_free_result($res);
            echo '<h2 class="text-uppercase textcenter">'. $hotel_data['hotel']. '</h2>';
            echo '<div class="row">
                    <h3>Location:</h3> 
                    <p>' . $hotel_data['city'] . '( ' . $hotel_data['country'] . ' )</p>
                    <div>';
            echo '<div class="row">
                    <h3>Description:</h3>
                    <p>' . $hotel_data['info'] . '</p>
                  <div>';



            echo '<div class="row"><div class="col-md-6 text-center">';

            //connect();
            $sel='SELECT imagepath from images where hotelid='.$hotel;

            $res=mysqli_query($mysqli,$sel);

            echo '<span class="label label-info">Watch our pictures</span>';

            echo'<ul id="gallery">';
            $i=0;
            while($row=mysqli_fetch_array($res,MYSQLI_NUM)){
                echo ' <li><img style="width: 300px"  src = "../'. $row[0].'"></li>';
            }
            mysqli_free_result($res);
            echo ' </ul>';
        }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>