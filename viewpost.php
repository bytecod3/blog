<?php
require('./includes/config.php');
require('./includes/image_db.php');



$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate, link_id FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

// get the lnk id from the blog post
$linkNumber = $row['link_id'];

// get the image that matches the exact link id of the post
$qry = "SELECT file_name FROM images WHERE link_id LIKE $linkNumber";
$q = $conn->query($qry);

// fetch image assoc array
$image_row = $q->fetch_assoc();

$imageURL = './uploads/'.$image_row['file_name'];

//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">

		<h1>Blog</h1>
		<hr />
		<p><a href="./">Blog Index</a></p>


		<?php	
			echo '<div>';
			?>

        <img src="<?php echo $imageURL ?>" alt="Card">
        <?php
				echo '<h1>'.$row['postTitle'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
				echo '<p>'.$row['postCont'].'</p>';				
			echo '</div>';
		?>

	</div>

</body>
</html>