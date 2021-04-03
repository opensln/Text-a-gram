<?php

// include './app/database/dbRequests.php';
$errors = array();
//Create--Comments
$editing_id = '';
$editing_text = '';
$update = false;
$replyFormFlag ='';


//--Show Reply Form 

if(isset($_POST['showReplyForm'])) {
 
    //logProg($_POST);

    $responseString = "<div id='replyFormContainer_id".$_POST['comment_parent_id']."' class='dynamicReplyFormContainer'>";
    $responseString.= "<form method='POST' onsubmit='return submitComment()'>";
    $responseString.= "<input hidden type='text' name='commenter_id_aka_user_id' value='".$_POST['commenter_id_aka_user_id']."'>";
    $responseString.= "<input hidden type='text' name='commenter_id_aka_user_id' value='".$_SESSION['user_id']."'>";
    $responseString.= "<input hidden type='text' name='comment_post_id' value='".$_POST['comment_post_id']."'>";
    $responseString.= "<input hidden type='text' name='comment_parent_id' value='".$_POST['comment_parent_id']."'>";
    $responseString.= "<textarea name='comment_content' placeholder='type your reply here...'></textarea>";
    $responseString.= "<button id='submitReplyBtn' class='submitReplyBtn btn btn-success' type='' name='reply-comment'>Reply</button>";
    $responseString.= "<button class='cancelDynamicReplyBtn btn btn-danger float-right' value='".$_POST['comment_parent_id']."' onclick=''>Cancel Reply</button>";
    $responseString.= "</form></div>";

    exit($responseString);
}

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

    $HumanDate = date('F, j, Y', strtotime($latestComment[0]['date']));
    //logProg($latestComment);
    //exit($latestComment[0]['comment_content']);
    $responseString = "<div class='displayCommentBox' id='commentBox_id".$latestComment[0]['comment_id']."'>";
    $responseString .="<input hidden type='text' name='comment_id' value='comment_id:".$latestComment[0]['comment_id']."'>";
    $responseString .="<input style='display:none;' type='text' name='comment_post_id' value='comment_post_id:".$latestComment[0]['comment_post_id']."' style='color:lightgrey;'>";
    $responseString .="<input style='display:none;' type='text' name='commenter_id_aka_user_id' value=".$latestComment[0]['commenter_id_aka_user_id'].">";
    $responseString .="<img class='avatarHolderSinglePage' width='30px' height='30px' src='./assets/images/avatars/".$latestComment[0]['avatar_image']."' alt='".$latestComment[0]['avatar_image']."'>";
    $responseString .="<p class='commentBoxInfoBar' type='text' name='comment_content'>";
    $responseString .="<span><strong>".$latestComment[0]['username']."</strong></span>"." ".$HumanDate.":";
    $responseString.= "<p>".$latestComment[0]['comment_content']."</p>";
    $responseString.= "<button
                        id='replyBtn".$latestComment[0]['comment_id']."'
                        type='button' 
                        onclick='' 
                        value='".$latestComment[0]['comment_id']."'
                        class='btn dynamicReplyBtn'
                        name='replyBtn".$latestComment[0]['comment_id']."'
                        data-commenter_id_aka_user_id='".$latestComment[0]['commenter_id_aka_user_id']."'
                        data-comment_post_id='".$latestComment[0]['comment_post_id']."'
                        >Reply</button>";

    //If the user is logged in "NOT REPLYING" and it is their own comment then show the edit and delete buttons-->
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $latestComment[0]['commenter_id_aka_user_id']) { //If(3)-->
    $responseString.= "<div class='userBtnBar'>";
    $responseString.= "<form  id='editForm' method='POST' action='displaysinglepage.php'>";
    $responseString.= "<a class='btn btn-successx editBtn' href='./displaysinglepage.php?post_id=".$redirectPostValue."&parentId&editing_id=".$latestComment[0]['comment_id']."&reply' >Edit</a>";
    $responseString.= "<input type='hidden' name='comment_post_id' value='".$latestComment[0]['comment_post_id']."'>";
    $responseString.= "<input type='hidden' name='comment_id' value='".$latestComment[0]['comment_id']."'>";
    $responseString.= "<input type='submit' name='delete-comment' class='btn btn-dangerx delBtn' value='Delete' onclick='return confirm('Are you sure you want to delete this comment?');'>";
    $responseString.= "</form></div>";

     } else//end If(3)
     $responseString.= "</div>";
    exit($responseString);
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
    //logProg($user_id);
  
    } else {
    logProg($errors);
    
    header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply&emptycomment=true");
    
    }
}

//--Delete--comment

if(isset($_POST['delete-comment'])) {
    //logProg($_POST);

    $deleting_id = $_POST['comment_id'];
    //logProg($deleting_id);
 
    $redirectPostValue = $_POST['comment_post_id'];
    //logProg($redirectPostValue);

    $deleting_info = delete('comment_table', $deleting_id);
    //logProg($deleting_info);

    header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
}

//--Fetch--comment--for updating

if(isset($_GET['editing_id'])) {
    $editing_id = $_GET['editing_id'];

    $editing_info = selectOne('comment_table', ['comment_id' => $_GET['editing_id']]);
    //logProg($editing_info);
    $editing_text = $editing_info['comment_content'];
    $update = true;

}

//--Update--comment

if(isset($_POST['update-comment'])) {
    unset($_POST['update-comment']);
    //logProg($_POST);
    $redirectPostValue = $_POST['comment_post_id'];
    //logProg($redirectPostValue);

    $stored_id_from_page = ($_POST['comment_id']);
    unset($_POST['comment_id']);
  
    $updatedEntry_id = update('comment_table', $stored_id_from_page, $_POST);
    //logProg($updatedEntry_id);

    header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");

}

if(isset($_POST['replyComment'])) {
    unset($_POST['replyComment']);

    $errors = validateComments($_POST);

    $redirectPostValue = $_POST['comment_post_id'];

    if (count($errors) === 0) {

    //logProg($_POST);
    //logProg('current redirect value: ' .$redirectPostValue);
    $newComment_id = create('comment_table', $_POST);
    //logProg($newComment_id);
    $latestComment = getLatestComment($redirectPostValue);

    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");


    //TODO Build dynamic replyDisplayBox from here to send back to the ajax
    exit($latestComment[0]['comment_content']);
    } else {
    //logProg($errors);
    
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply&emptycomment=true");
    
    }

 }

