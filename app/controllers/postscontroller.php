<?php

//include './app/database/dbRequests.php';

$errors = array();

$post_title = '';
$post_text= '';
$image_filename= '';


if (isset($_POST['create-btn'])) {
    unset($_POST['create-btn']);
    //logProg($_POST);
    $errors = validateCreate($_POST);
    //logProg($errors);
    $jpgCheck = substr($_FILES['image_filename']['name'],-3);

    if ($jpgCheck != "jpg") { 
    array_push($errors, 'You must upload a jpg image file.');
    //logProg($errors);
    } else {

    if (!empty($_FILES['image_filename']['name'])) {
          $imagename = time() . '_' . $_FILES['image_filename']['name'];
          $destination = "./assets/images/" . $imagename;
          //logProg($imagename);
          $result = move_uploaded_file($_FILES['image_filename']['tmp_name'], $destination);
          //logProg($result);
          if($result) {
            $_POST['image_filename'] = $imagename;
            //logProg($_POST);
          } else {
            array_push($errors, 'Failed to upload image');
          }

    } else {
      array_push($errors, 'Phone image required');
    }

  }
    if (count($errors) === 0) {

    $post_id = create('post_table', $_POST);

     $NewEntry = selectOne('post_table', ['post_id' => $post_id]);
     //logProg($NewEntry);
     $_SESSION['message'] = 'Your entry was successful.';
     $_SESSION['type'] = 'success';
     header("Location: ./conversations.php");
   
    } else {

    $post_title = $_POST['post_title'];
    $post_text = $_POST['post_text'];
    //logProg($post_text);

    }
} 

//--Delete--Post

if(isset($_POST['delete-post'])) {
  $delete_post_id = $_POST['post_id'];
  //logProg($delete_post_id);
 
  $deleting_info = delete('post_table', $delete_post_id);
  //logProg($deleting_info);

  header("Location: ./conversations.php");

}



