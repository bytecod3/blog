<?php
require_once ('../functions/functions.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Images</title>
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        Select image:
        <input type="file" name="file" id="">
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
