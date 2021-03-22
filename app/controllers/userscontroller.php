<?php

include './app/database/dbRequests.php';
include './app/helpers/validateforms.php';
$errors = array();

$username = '';
$email = '';
$pwd = '';
$pwdConf = '';
$image_filename = '';
$redirectPostValue ='';

if (isset($_POST['register-btn'])) {
    //logProg($_POST);
    $errors = validateReg($_POST);
    //logProg($errors);
    $jpgCheck = substr($_FILES['image_filename']['name'],-3);

    //Imagestuff will happen here
    if ($jpgCheck != "jpg") { 
        array_push($errors, 'You must upload a jpg image file.');
        //logProg($errors);
        } else {
    
        if (!empty($_FILES['image_filename']['name'])) {
              $imagename = time() . '_' . $_FILES['image_filename']['name'];
              $destination = "./assets/images/avatars/" . $imagename;
              //logProg($imagename);
              $result = move_uploaded_file($_FILES['image_filename']['tmp_name'], $destination);
              //logProg($result);
              if($result) {
                $_POST['avatar_image'] = $imagename;
                //logProg($_POST);
              } else {
                array_push($errors, 'Failed to upload image');
              }
    
        } else {
          array_push($errors, 'Phone image required');
        }
    }

    if (count($errors) === 0) {

        unset($_POST['register-btn']);
        unset($_POST['pwdConf']);

        $_POST['pwd'] = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        //logProg($_POST);
        $NewEntryId = create('user_table', $_POST);
        $NewEntry = selectOne('user_table', ['user_id' => $NewEntryId]);
        //logProg($NewEntry);
        //log in user
        $_SESSION['user_id'] = $NewEntry['user_id'];
        $_SESSION['username'] = $NewEntry['username'];
        $_SESSION['avatar_image'] = $NewEntry['avatar_image'];
        $_SESSION['message'] = 'You are currently logged in';
        $_SESSION['type'] = 'success';

        header("Location: ./conversations.php");
        exit();
        
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $pwdConf = $_POST['pwdConf'];
    }

}


if (isset($_POST['login-btn'])) {
    //logProg($_POST);
    $errors = validateLogin($_POST);
    //logProg($errors);
    if(isset($_POST['fromPageInfo'])) {
    $redirectPostValue = $_POST['fromPageInfo'];
    }
    //logProg($redirectPostValue);

    if (count($errors) === 0) {
        $currentUser = selectOne('user_table', ['username' => $_POST['username']]);
        //logProg($currentUser);
        if ($currentUser && password_verify($_POST['pwd'], $currentUser['pwd'])) {
            //log in user
            $_SESSION['user_id'] = $currentUser['user_id'];
            $_SESSION['username'] = $currentUser['username'];
            $_SESSION['avatar_image'] = $currentUser['avatar_image'];
            $_SESSION['message'] = 'You are currently logged in';
            $_SESSION['type'] = 'success';

            if($redirectPostValue == null ) {
                header("Location: ./conversations.php");
                exit();
            } else {
                header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&&parentId&reply");
            exit();
            }
        } else {
            echo "You have some errors";
            array_push($errors, 'Your login details are incorrect!');
        }
    }
    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $redirectPostValue = $_POST['fromPageInfo'];

}