<?php
require('includes/config.php');
require('includes/image_db.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">

		<h1>Blog</h1>
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate, link_id FROM blog_posts ORDER BY postID DESC');

                while($row = $stmt->fetch()){


                    // get the lnk id from the blog post
                    $linkNumber = $row['link_id'];

                    // get the image that matches the exact link id of the post
                    $qry = "SELECT file_name FROM images WHERE link_id LIKE $linkNumber";
                    $q = $conn->query($qry);

                    // fetch image assoc array
                    $image_row = $q->fetch_assoc();

                    $imageURL = './uploads/'.$image_row['file_name'];


                    echo '<div>';

                        ?>

                    <img src="<?php echo $imageURL ?>" alt="Image Card">
                        <?php


						echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
						echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>


</body>
</html>