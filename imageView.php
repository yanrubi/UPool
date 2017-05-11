<?php
    $host = "localhost";
    $user = "upooluser";
    $password = "pass";
    $database = "upooldb";
    $db = mysqli_connect($host, $user, $password, $database);
    
    if(isset($_GET['image_id'])) {
        $sql = "SELECT imageType,image FROM usertable WHERE userid=" . $_GET['image_id'];
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);
        header("Content-type: " . $row["imageType"]);
        echo $row["image"];
    }
    mysqli_close($db);
?>