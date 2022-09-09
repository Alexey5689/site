<?php

if (!isset($_SESSION['radmin'])){
    echo "<h3/><span style='color:red;'>For Administrators Only!</span><h3/>";
    exit();
}
?>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- section A: for form Countries -->
        <?php
        $mysqli = connect(); // подключение к базе данныйх
        $sel = 'SELECT * 
                FROM countries'; //запрос в базу
        $res = mysqli_query($mysqli, $sel); // подключение к базе данныйх
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcountry">';
        //таблица текущих стран
        echo '<table class="table table-striped">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) { //Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
            echo '<td>' . $row[1] . '</td>';
            echo '<td><input type="checkbox" name="cb' . $row[0] . '"></td>'; //чекбокс cb
            echo '</tr>';
        }
        echo '</table>';
        mysqli_free_result($res); //освобождает память от результата запроса
        //добавить страну
        echo '<input type="text" name="country" placeholder="Country">';
        echo '<input type="submit" name="addcountry" value="Add" class="btn btn-sm btn-info">';
        //удалить страну
        echo '<input type="submit" name="delcountry" value="Delete" class="btn btn-sm btn-warning">';
        echo '</form>';
        //добавление страны
        if (isset($_POST['addcountry'])) {
            $country = trim(htmlspecialchars($_POST['country'])); // trim Удаляет пробелы (или другие символы) из начала и конца строки    htmlspecialchars  Преобразует специальные символы в HTML-сущности
            if ($country == "") {
                exit();
            }

            $ins = 'INSERT into countries(country) values("' . $country . '")';
            mysqli_query($mysqli, $ins); // подключение к базе данныйх
            //обновление страници
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        //удаление страны
        if (isset($_POST['delcountry'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "cb") { //подспроку от 0 символа до 2
                    $idc = substr($k, 2); //подспроку от 2 символа до конца
                    $del = 'DELETE 
                            FROM countries 
                            WHERE id=' . $idc;
                    mysqli_query($mysqli, $del); // подключение к базе данныйх
                }
            }
            //обновление страници
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }


        ?>

    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 right">
        <!-- section B: for form Cities -->
        <?php
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcity">';
        $sel = 'SELECT ci.id, ci.city, co.country 
                FROM countries co, cities ci 
                WHERE ci.countryid=co.id';
        $res = mysqli_query($mysqli, $sel); // подключение к базе данныйх
        echo '<table class="table table-striped">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) { //Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
            echo '<td>' . $row[1] . '</td>';
            echo '<td>' . $row[2] . '</td>';
            echo '<td><input type="checkbox" name="ci' . $row[0] . '"></td>';
            echo '</tr>';
        }
        echo '</table>';
        mysqli_free_result($res); //освобождает память от результата запроса
        $res = mysqli_query($mysqli, 'SELECT * 
                                      FROM countries');
        echo '<select name="countryname" class="form-control">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) { //Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
        echo '</select>';
        echo '<input type="text" name="city" placeholder="City">';
        //добавить город
        echo '<input type="submit" name="addcity" value="Add" class="btn btn-sm btn-info">';
        //удалить город
        echo '<input type="submit" name="delcity" value="Delete"class="btn btn-sm btn-warning">';
        echo '</form>';
        //обработчик формы для городов
        if (isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city'])); // trim Удаляет пробелы (или другие символы) из начала и конца строки    htmlspecialchars  Преобразует специальные символы в HTML-сущности
            if ($city == "") {
                exit();
            }

            $countryid = trim(htmlspecialchars($_POST['countryname'])); // trim Удаляет пробелы (или другие символы) из начала и конца строки    htmlspecialchars  Преобразует специальные символы в HTML-сущности
            $ins = 'INSERT into cities (city,countryid) values("' . $city . '",' . $countryid . ')';
            mysqli_query($mysqli, $ins); // подключение к базе данныйх
            $err = mysqli_errno($mysqli);  //Возвращает код ошибки последнего вызова функции
            if ($err) {
                echo 'Error code:' . $err . '<br>';
                exit();
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        //удаление города
        if (isset($_POST['delcity'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "ci") { //подспроку от 0 символа до 2
                    $idc = substr($k, 2);  //подспроку от 2 символа до конца
                    $del = 'delete from cities where id=' . $idc;
                    mysqli_query($mysqli, $del); // подключение к базе данныйх
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }

        ?>
    </div>
</div>
<hr />
<div class="row">
    <div class=" col-sm-6 col-md-6 col-lg-6 left ">
        <!-- section C: for form Hotels -->
        <?php


        echo '<form action="index.php?page=4" method="post" class="input-group" id="formhotel">';
        $sel = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country
                  FROM cities AS ci, hotels AS ho, countries AS co
                  WHERE ho.cityid=ci.id and ho.countryid=co.id';

        $res = mysqli_query($mysqli, $sel); // подключение к базе данныйх
        $err = mysqli_errno($mysqli); //Возвращает код ошибки последнего вызова функции
        echo '<table class="table" width="100%">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) { //Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
            echo '<tr>';
            echo '<td>' . $row[2] . '</td>';
            echo '<td>' . $row[1] . "-" . $row[9] . '</td>';
            echo '<td>' . $row[3] . '</td>';
            echo '<td>' . $row[6] . '</td>';
            echo '<td><input type="checkbox" name="hb' . $row[2] . '"></td>';//чекбокс hb
            echo '</tr>';
        }
        echo '</table>';
    
        mysqli_free_result($res); //освобождает память от результата запроса
        $sel = 'SELECT ci.id, ci.city, co.country, co.id
                  FROM countries AS co, cities AS ci
                  WHERE ci.countryid=co.id';

        $res = mysqli_query($mysqli, $sel);
        $csel = array();
        echo '<select name="hcity" class="">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . " : " . $row[2] . '</option>';
            $csel[$row[0]] = $row[3]; // массив
        }
        echo '</select>';
        echo '<input type="text" name="hotel" placeholder="Hotel">';
        echo '<input type="text" name="cost" placeholder="Cost">';
        echo '&nbsp;&nbsp;Stars: <input type="number" name="stars" min="1" max="5">';
        echo '<br><textarea name="info" placeholder="Description">';
        echo '</textarea><br>';
        echo '<input type="submit" name="addhotel" value="добавить" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delhotel" value="удалить"class="btn btn-sm btn-warning">';
        echo '</form>';
        mysqli_free_result($res);


        if (isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = intval(trim(htmlspecialchars($_POST['cost']))); //intval — Возвращает целое значение переменной
            $stars = intval($_POST['stars']); //intval — Возвращает целое значение переменной
            $info = trim(htmlspecialchars($_POST['info']));
            if ($hotel == "" || $cost == "" || $stars == "") {
                exit();
            }
            $cityid = $_POST['hcity'];
            $countryid = $csel[$cityid]; //
            $ins = 'INSERT into hotels (hotel,cityid,countryid,stars,cost,info)values("' . $hotel . '",' . $cityid;
            $ins .= "," . $countryid . ',' . $stars . ',' . $cost . ',"' . $info;
            $ins .= '")';
            mysqli_query($mysqli, $ins);
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        if (isset($_POST['delhotel'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "hb") {
                    $idc = substr($k, 2);
                    $del = 'DELETE 
                              FROM  hotels 
                              WHERE id=' . $idc;
                    mysqli_query($mysqli, $del);
                }
                if ($err) {
                    echo 'Error code:' . $err . '<br>';
                    exit();
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        ?>
    </div>
    <div class=" col-sm-6 col-md-6 col-lg-6 right ">
        <!-- section D: for form Images -->
        <?php
        // таблица с изображениями
        $sel = 'SELECT i.id, i.imagepath, h.hotel, c.city 
        FROM images AS i 
        JOIN hotels AS h ON i.hotelid=h.id 
        JOIN cities AS c ON h.cityid = c.id';
        $res = mysqli_query($mysqli, $sel);
        $err = mysqli_errno($mysqli);   
        echo '<table class="table" width="100%">';
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
            echo '<td>' . $row[1] . '</td>';
            echo '<td>' . $row[2] . '</td>';
            echo '<td>' . $row[3] . '</td>';
            echo '<tr>';
        }
        echo "</table>";
        
        
        echo '<form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">';
        // enctype="multipart/form-data" обязательно для формы загрузки для пкетной загрузки файлов
        echo '<select name="hotelid">';
        $sel = 'SELECT ho.id, co.country,ci.city,ho.hotel
                  FROM countries AS co, cities AS ci, hotels AS ho
                  WHERE co.id=ho.countryid AND ci.id=ho.cityid
                  ORDER BY co.country';
        $res = mysqli_query($mysqli, $sel);
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<option value="' . $row[0] . '">';
            echo $row[1] . '&nbsp;&nbsp;' . $row[2] . '&nbsp;&nbsp;' . $row[3] .
                '</option>';
        }
        mysqli_free_result($res);
        echo '<input type="file" name="file[]" multiple accept="images/*">';
        echo '<input type="submit" name="addimage" value="Add" class="btn btn-sm btn-info">';
        echo '</select>';
        echo '</form>';

        if (isset($_REQUEST['addimage'])) { // массив который   содержит все запросы POST GET COOK

            foreach ($_FILES['file']['name'] as $k => $v) {

                if ($_FILES['file']['error'][$k] != 0) {
                    echo '<script>alert("Upload file error:' . $v . '")</script>';
                    continue;
                }
                if (move_uploaded_file($_FILES['file']['tmp_name'][$k], 'images/' . $v)) {
                    $ins = 'INSERT INTO images(hotelid,imagepath)
                              VALUES(' . $_REQUEST['hotelid'] . ',"images/' . $v . '")';
                    mysqli_query($mysqli, $ins);
                }
            }
            echo "<script>";
            echo "window.location=document.URL;";
            echo "</script>";
        }
        echo '</div>';
        ?>
    </div>
</div>

