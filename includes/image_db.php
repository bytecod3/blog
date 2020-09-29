<?php
try {
    $conn = mysqli_connect("localhost", "root", "", "images");
}catch(Exception $e){
    echo $e;
}