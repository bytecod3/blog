<?php //include config
    require_once('../includes/config.php');
    require_once ('../functions/functions.php');

    //if not logged in redirect to login page
    if(!$user->is_logged_in()){ header('Location: login.php'); }

    if (isset($_POST['submit'])){
        // when the form is submitted

        // generate a random number to be used as relationship between image and its
        // corresponding post
        $randomNumber = rand();


        $filename = $_FILES['image']['name'];
        $fileTempName = $_FILES['image']['tmp_name'];
        $postTitle = $_POST['postTitle'];
        $postDesc = $_POST['postDesc'];
        $postCont = $_POST['postCont'];


        // call the insert data function
        insertData($filename, $fileTempName, $postTitle, $postDesc, $postCont, $randomNumber);

    }



?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Post</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Add Post</h2>

	<?php


	?>

	<form action='add-post.php' method='post' enctype="multipart/form-data">

        <p><label>Add image Card</label></p>
        <input type="file" name="image">

        <p><label>Title</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>


		<p><label>Description</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
