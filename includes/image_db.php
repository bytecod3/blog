<?php
try {
    $db = mysqli_connect("localhost", "root", "", "images");
}catch(Exception $e){
    echo $e;
}