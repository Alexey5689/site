<?php
    $mysqli=connect();
    echo '<form action="index.php?page=5" method="post" enctype="multipart/form-data" class="input-group">';
    echo '<select name="userid">';
    $sel='SELECT * 
            FROM users 
            WHERE roleid=2 
            ORDER BY login';
    $res=mysqli_query($mysqli, $sel);
    while($row=mysqli_fetch_array($res,MYSQLI_NUM)){
        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
    }
    mysqli_free_result($res);
    echo '</select>';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="500000"/>';
    echo '<input type="file" name="file" accept="image/*">';
    echo '<input type="submit" name="addadmin" value="Add" class="btn btn-sm btn-info">';
    echo '</form>';
    if(isset($_POST['addadmin'])){
        $userid=$_POST['userid'];
        $fn=$_FILES['file']['tmp_name'];
        $file=fopen($fn,'rb');//fopen — Открывает файл или URL
        $img=fread($file, filesize($fn));//fread — Бинарно-безопасное чтение файла
        fclose($file);//fclose — Закрывает открытый дескриптор файла
        $img=addslashes($img);//addslashes — Экранирует строку с помощью слешей
        $ins='UPDATE users set avatar="'.$img.'",roleid=1 where id ='.$userid;
        mysqli_query($mysqli,$ins);
    }
    $sel='SELECT * FROM users WHERE roleid=1 ORDER BY login';
    $res=mysqli_query($mysqli,$sel);
    echo '<table class="table table-striped">';
    while($row=mysqli_fetch_array($res,MYSQLI_NUM)){
        echo '<tr>';
        echo '<td>'.$row[0].'</td>';
        echo '<td>'.$row[1].'</td>';
        echo '<td>'.$row[3].'</td>';
        $img=base64_encode($row[6]);//base64_encode — Кодирует данные в формат MIME base64    base64_decode — Декодирует данные, закодированные MIME base64
        //эта кодировка предназначена для корректной передачи бинарных данных по протоколам, не поддерживающим 8-битную передачу, например, для отправки тела письма.Данные, закодированные base64 занимают на 33% больше места по сравнению с оригинальными данными.
        echo '<td><img width="100px"src="data:image/jpeg; base64,'.$img.'"/></td>';
}
    mysqli_free_result($res);
    echo '</table>';
?>