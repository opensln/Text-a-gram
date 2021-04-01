<?php

// include './app/database/dbRequests.php';
$errors = array();
//Create--Comments
$editing_id = '';
$editing_text = '';
$update = false;



//--Submit--comment

if(isset($_POST['submitComment'])) {
   unset($_POST['submitComment']);

    $errors = validateComments($_POST);

    $redirectPostValue = $_POST['comment_post_id'];

    //logProg($errors);

    if (count($errors) === 0) {

    //logProg($_POST);
    //logProg('current redirect value: ' .$redirectPostValue);
  
    $newComment_id = create('comment_table', $_POST);
    //logProg($newComment_id);
    $latestComment = getLatestComment($redirectPostValue);
    //logProg($latestComment);
    exit($latestComment[0]['comment_content']);
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
    //logProg($user_id);
  
    } else {
    logProg($errors);
    
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply&emptycomment=true");
    
    }
}

//--Delete--comment

// if(isset($_POST['delete-comment'])) {
//     //logProg($_POST);

//     $deleting_id = $_POST['comment_id'];
//     //logProg($deleting_id);
 
//     $redirectPostValue = $_POST['comment_post_id'];
//     //logProg($redirectPostValue);

//     $deleting_info = delete('comment_table', $deleting_id);
//     //logProg($deleting_info);

//     header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
// }

//--Fetch--comment--for updating

// if(isset($_GET['editing_id'])) {
//     $editing_id = $_GET['editing_id'];

//     $editing_info = selectOne('comment_table', ['comment_id' => $_GET['editing_id']]);
//     //logProg($editing_info);
//     $editing_text = $editing_info['comment_content'];
//     $update = true;

// }

//--Update--comment

// if(isset($_POST['update-comment'])) {
//     unset($_POST['update-comment']);
//     //logProg($_POST);
//     $redirectPostValue = $_POST['comment_post_id'];
//     //logProg($redirectPostValue);

//     $stored_id_from_page = ($_POST['comment_id']);
//     unset($_POST['comment_id']);
  
//     $updatedEntry_id = update('comment_table', $stored_id_from_page, $_POST);
//     //logProg($updatedEntry_id);

//     header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");

// }

// if(isset($_POST['reply-comment'])) {
//     unset($_POST['reply-comment']);

//     $errors = validateComments($_POST);

//     $redirectPostValue = $_POST['comment_post_id'];

//     if (count($errors) === 0) {

//     //logProg($_POST);
//     //logProg('current redirect value: ' .$redirectPostValue);
//     $user_id = create('comment_table', $_POST);
//     header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
//     //logProg($user_id);
//     } else {
//     //logProg($errors);
    
//     header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply&emptycomment=true");
    
//     }

// }

