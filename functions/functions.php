<?php

// require databases
require_once("../includes/config.php");
require_once("../includes/image_db.php");


// initialize blog post details


// this function inserts blog post data into database
function insertData($filename, $fileTempName, $postTitle, $postDesc, $postCont, $randomNumber){
    global $db;
    // call image inserter because they have different databases
    $result = imageInserter($filename, $fileTempName, $randomNumber);

    // check the return value from image inserter
    // if true, continue to insert other details into database
    // else, end function with a false code
    if($result){
        // insert blog details into database

        //if form has been submitted process it
        if(isset($_POST['submit'])){

            $_POST = array_map( 'stripslashes', $_POST );

            //collect form data
            extract($_POST);

            //very basic validation
            if($postTitle ==''){
                $error[] = 'Please enter the title.';
            }

            if($postDesc ==''){
                $error[] = 'Please enter the description.';
            }

            if($postCont ==''){
                $error[] = 'Please enter the content.';
            }

            if(!isset($error)){

                try {

                    //insert into database
                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate, link_id) VALUES (:postTitle, :postDesc, :postCont, :postDate, :randomNumber)') ;
                    $stmt->execute(array(
                        ':postTitle' => $postTitle,
                        ':postDesc' => $postDesc,
                        ':postCont' => $postCont,
                        ':postDate' => date('Y-m-d H:i:s'),
                        ':randomNumber' => $randomNumber
                    ));

                    //redirect to index page
                    header('Location: index.php?action=added');
                    exit;

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }

            }

        }

        //check for any errors
        if(isset($error)){
            foreach($error as $error){
                echo '<p class="error">'.$error.'</p>';
            }
        }
    }else{
        // return false
        echo "Not inserted";
        return false;
    }

    return true;
}

function imageInserter($filename, $fileTempName, $randomNumber){
    global $conn;
//    require("../includes/image_db.php");
    $statusMsg = "";

    if (!empty($filename)){
        // file upload path
        $targetDir = "../uploads/";
        $fileName = basename($filename);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // allow certain file file formats
        $allowTypes = array('jpg','png','jpeg');
        if (in_array($fileType, $allowTypes)){
            // upload file to server
            if (move_uploaded_file($fileTempName, $targetFilePath)){
                // insert filename into database
                $query = "INSERT INTO images(file_name, uploaded_on, link_id) VALUES ('".$fileName."', NOW(), '$randomNumber')";
                $insert = $conn->query($query);

                if ($insert){
//                    $statusMsg = "File uploaded successfully.";
                    return true;
                }else{
                    echo "Failed 1";
//                    $statusMsg = "File upload failed. Please try again";
                    return false;
                }
            }else{
//                $statusMsg = "Sorry. There was an error in uploading your file.";
                echo "Failed 2";
                return false;
            }

        }else{
//            $statusMsg = "Sorry. Only jpg, png or jpeg files are allowed.";
            echo "Failed 3";
            return false;
        }
    }else{
//        $statusMsg = "Please select an image to upload.";
        echo "Failed 4";
        return false;
    }


}

