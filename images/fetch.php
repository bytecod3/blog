
<?php

require_once("../includes/image_db.php");
// get images from the database
$sql = "SELECT * FROM images ORDER BY uploaded_on DESC";
$query = $db->query($sql);

if ($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL  = '../uploads/'.$row['file_name'];?>

        <img src="<?php echo $imageURL; ?>" alt="" /> <?php
    }
}else{ ?>
    <p>No images found</p>

    <?php
}

?>