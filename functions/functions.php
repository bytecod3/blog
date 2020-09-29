<?php

// generate a random number to be used as relationship between image and its
// corresponding post
$randomNumber = rand();

// todo:initialize blog post details


// this function inserts blog post data into database
function insertData(){
    // call image inserter because they have different databases
    $result = imageInserter();

    // check the return value from image inserter
    // if true, continue to insert other details into database
    // else, end function with a false code
    if($result){
        // insert blog details into database
        require_once("../includes/config.php");

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
                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
                    $stmt->execute(array(
                        ':postTitle' => $postTitle,
                        ':postDesc' => $postDesc,
                        ':postCont' => $postCont,
                        ':postDate' => date('Y-m-d H:i:s')
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
    }

}

function imageInserter(){
    require("../includes/image_db.php");
    $statusMsg = "";

    if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
        // file upload path
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // allow certain file file formats
        $allowTypes = array('jpg','png','jpeg');
        if (in_array($fileType, $allowTypes)){
            // upload file to server
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){
                // insert filename into database
                $query = "INSERT INTO images(file_name, uploaded_on) VALUES ('".$fileName."', NOW())";
                $insert = $db->query($query);

                if ($insert){
//                    $statusMsg = "File uploaded successfully.";
                    return false;
                }else{
//                    $statusMsg = "File upload failed. Please try again";
                    return false;
                }
            }else{
//                $statusMsg = "Sorry. There was an error in uploading your file.";
                return false;
            }

        }else{
//            $statusMsg = "Sorry. Only jpg, png or jpeg files are allowed.";
            return false;
        }
    }else{
//        $statusMsg = "Please select an image to upload.";
        return false;
    }


}

