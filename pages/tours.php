<h2>Select Tours</h2>
<hr>
<?php
print_r(PDO::getAvailableDrivers());
$mysqli = connect();

echo '<div class="form-inline">';
echo '<select name="countryid" id="countryid"
onchange="showCities(this.value)">';
echo '<option value="0">select country</option>';
$res = mysqli_query($mysqli, 'select * from countries');
while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo '<option value="' . $row[0] . '">' . $row[1] . '
</option>';
}
echo '</select>';
//list of cities
echo '<select name="cityid" id="citylist"
onchange="showHotels(this.value)"></select>';
echo '</div>';
//list of hotels
echo '<div id="h"></div>';
//javascript functions
?>
<script>
    function showCities(countryid) {
        if (countryid == "0") {
            document.getElementById('citylist').innerHTML = "";
        }
        //если выбрана страна

        //creating AJAX object
        if (window.XMLHttpRequest) {
            ao = new XMLHttpRequest();
        } else {
            ao = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //creating callback function accepting result
        ao.onreadystatechange = function() {
            // 4 - вернулся ответ, 200 - статус, что нет ошибок от сервера
            if (ao.readyState == 4 && ao.status == 200) {
                document.getElementById('citylist').innerHTML = ao.responseText;
            }
        }
        //creating and sending AJAX request
        ao.open('GET', "pages/ajax1.php?cid=" + countryid, true);
        ao.send(null);
    }

    function showHotels(cityid) {
        var h = document.getElementById('h');
        if (cityid == "0") {
            h.innerHTML = "";
        }

        //creating AJAX object
        if (window.XMLHttpRequest) {
            ao = new XMLHttpRequest();
        } else {
            ao = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //creating callback function accepting result
        ao.onreadystatechange = function() {
            if (ao.readyState == 4 && ao.status == 200) {
                h.innerHTML = ao.responseText;
            }
        }
        //creating and sending AJAX request
        ao.open("POST", "pages/ajax2.php", true);
        ao.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
        ao.send("cid=" + cityid);
    }
</script>