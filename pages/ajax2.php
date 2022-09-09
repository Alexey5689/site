<?php
include_once('function.php');
$mysqli = connect();
$cid=$_POST['cid'];
$sel='select id,hotel,stars,cost from hotels where
cityid='.$cid;
$res=mysqli_query($mysqli, $sel);
echo '<table class="table table-stripped"
id="table1"><thead><tr><th>Hotel</th><th>Cost</
th><th>Stars</th>
<th>Details</th></thead><tbody>';
while ($row=mysqli_fetch_array($res,MYSQLI_NUM)) {
echo '<tr><td>'.$row[1].'</
td><td>'.$row[3].'$</td><td>'.$row[2];
echo '<td>
<a href="pages/hotelinfo.php?hotel='.$row[0].'" target="_blank"
class="btn btn-default btn-xs">details</a>
</td></tr>';
}
echo '</tbody></table>';
mysqli_free_result($res);
?>
