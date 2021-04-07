<?php

// include './app/database/dbRequests.php';
$errors = array();

//------------------------------------------------Submit & Prepare Comment

if(isset($_POST['submitComment'])) {
   unset($_POST['submitComment']);

    $errors = validateComments($_POST);
    $redirectPostValue = $_POST['comment_post_id'];
    //logProg($errors);

    if (count($errors) === 0) {
    //logProg($_POST);
  
    $newComment_id = create('comment_table', $_POST);
    //logProg($newComment_id);
    $latestComment = getLatestComment($redirectPostValue);

    $humanDate = date('F, j, Y', strtotime($latestComment[0]['date']));
    //logProg($latestComment);
    $responseString = "<div class='displayCommentBox' id='commentBox_id".$latestComment[0]['comment_id']."'>";
    $responseString .="<input hidden id='comment_post_id".$latestComment[0]['comment_id']."' type='text' name='comment_post_id' value='".$latestComment[0]['comment_post_id']."' >";
    $responseString .="<input hidden id='commenter_id_aka_user_id' value".$latestComment[0]['comment_id']."' type='text' name='commenter_id_aka_user_id' value=".$latestComment[0]['commenter_id_aka_user_id'].">";
    $responseString .="<img class='avatarHolderSinglePage' width='30px' height='30px' src='./assets/images/avatars/".$latestComment[0]['avatar_image']."' alt='".$latestComment[0]['avatar_image']."'>";
    $responseString .="<p  class='commentBoxInfoBar' type='text' name='comment_content'>";
    $responseString .="<span><strong>".$latestComment[0]['username']."</strong></span>"." ".$humanDate.":";
    $responseString.= "<p id='comment_content".$latestComment[0]['comment_id']."'>".$latestComment[0]['comment_content']."</p>";

    $responseString.= "<div id='editTextareaHolder".$latestComment[0]['comment_id']."' class='editTextareaHolder'>
    <textarea id='textareaEditBox".$latestComment[0]['comment_id']."' style='width:100%;'> ".$latestComment[0]['comment_content']." </textarea>
    <button id=''
    class='commentUpdateBtn btn btn-success'
    value='".$latestComment[0]['comment_id']."'
    >Update it</button>
    <a class='cancelUpdateBtn btn btn-danger float-right'>Cancel Update</a>
    </div>";

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

    $responseString.=  "<div id='replyFormContainer_id".$latestComment[0]['comment_id']."' class='dynamicReplyFormContainer' style='display:none'>
                        <form method='POST' onsubmit='return submitComment()'>
                        <input id='reply_user_id".$latestComment[0]['comment_id']."' hidden type='text' name='commenter_id_aka_user_id' value='".$_SESSION['user_id']."'>
                        <input id='reply_post_id".$latestComment[0]['comment_id']."' hidden type='text' name='comment_post_id' value='".$latestComment[0]['comment_post_id']."'>
                        <textarea id='reply_comment_content_id".$latestComment[0]['comment_id']."' name='comment_content' placeholder='type your reply here...'></textarea>
                        <button  id='submitReplyBtn'
                                class='submitReplyBtn btn btn-success'
                                type=''
                                name='reply-comment'
                                value='".$latestComment[0]['comment_id']."'
                                >Submit Reply</button>
                        <button class='cancelDynamicReplyBtn btn btn-danger float-right' value='".$latestComment[0]['comment_id']."' onclick=''>Cancel Reply</button>
                        </form></div>";

    //If the user is logged in "NOT REPLYING" and it is their own comment then show the edit and delete buttons-->
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $latestComment[0]['commenter_id_aka_user_id']) { //If(3)-->
    $responseString.= "<div id='userBtnBar".$latestComment[0]['comment_id']."' class='userBtnBar'>
    <form  id='editForm".$latestComment[0]['comment_id']."' class='.editForm' method='POST' onsubmit='return submitComment();' style='width:70%; position:absolute; bottom: 5px;right: 5px;'>
        <button class='btn btn-successx editBtn' value='".$latestComment[0]['comment_id']."' >Edit</button>
        <input type='hidden' name='comment_post_id' value='".$latestComment[0]['comment_post_id']."'>
        <input type='hidden' name='comment_id' value='".$latestComment[0]['comment_id']."'>
        <button type='' name='delete-comment' class='btn btn-dangerx delBtn' value='".$latestComment[0]['comment_id']."'>Delete</button>
    </form></div>";

     } else//end If(3)
     $responseString.= "</div>";
    exit($responseString);
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
  
    } else {
    logProg($errors);
    
    header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply&emptycomment=true");
    }
}

//--------------------------------------------------------Submit & Prepare Reply

if(isset($_POST['submitReply'])) {
    unset($_POST['submitReply']);

    $errors = validateComments($_POST);

    $redirectPostValue = $_POST['comment_post_id'];

    if (count($errors) === 0) {

    //logProg($_POST);
    $newComment_id = create('comment_table', $_POST);
    //logProg($newComment_id);
    $latestComment = getLatestComment($redirectPostValue);
    $humanDate = date('F, j, Y', strtotime($latestComment[0]['date']));

    $responseString = "<div class='displayReplyBox' id='displayReplyBox".$latestComment[0]['comment_id']."'>
    <input hidden type='text' name='comment_parent_id' value='comment_id:".$latestComment[0]['comment_parent_id']."'>
    <input hidden type='text' name='commenter_id_aka_user_id' value='".$latestComment[0]['commenter_id_aka_user_id']."'>
    <img class='avatarHolderSinglePage' width='30px' height='30px' src='./assets/images/avatars/".$latestComment[0]['avatar_image']."' alt='".$latestComment[0]['avatar_image']."'>
    <p class='commentBoxInfoBar' type='text' name='comment_content' >
        <span><strong>".$latestComment[0]['username']."</strong></span>"." ".$humanDate.":
    </p>
    <p>".$latestComment[0]['comment_content']."</p>";

        //Start Reply Delete Form--->
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $latestComment[0]['commenter_id_aka_user_id']) {
    $responseString.= "<div class='userBtnBar'>
               <form  id='editForm".$latestComment[0]['comment_id']."' method='POST' action='displaysinglepage.php' >
                    <input type='hidden' name='comment_post_id' value='".$latestComment[0]['comment_post_id']."'>
                    <input type='hidden' name='comment_id' value='".$latestComment[0]['comment_id']."'>
                    <button type='submit' name='delete-comment' class='btn btn-dangerx delBtn' value='".$latestComment[0]['comment_id']."'>Delete</button>
                </form>
            </div>";
        } 
        //End Reply Edit Form-->
    $responseString.= "</div>";

    exit($responseString);
    } else {
    exit("Sorry, there seems to be a problem with this feature");
    }
 }

//----------------------------------------------------------Delete--comment

if(isset($_POST['deleteComment'])) {
    //logProg($_POST);

    $deleting_id = $_POST['comment_id'];
    // $redirectPostValue = $_POST['comment_post_id'];

    $deleting_info = delete('comment_table', $deleting_id);
    //logProg($deleting_info);
    exit("entry ".$deleting_id." Deleted");
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
}

//--------------------------------------------------------Update--comment

if(isset($_POST['updateComment'])) {
    unset($_POST['updateComment']);
    //logProg($_POST);
    $redirectPostValue = $_POST['comment_post_id'];
    //logProg($redirectPostValue);

    $stored_id_from_page = ($_POST['comment_id']);
    unset($_POST['comment_id']); //The comment_id must be separate in the query and removed from the data bundle
    //logProg($_POST);
    $updatedEntry_id = update('comment_table', $stored_id_from_page, $_POST);
    //logProg($updatedEntry_id);
    $editedComment = selectOne('comment_table', ['comment_id' => $stored_id_from_page]);
    //logProg($editedComment);
    exit($editedComment['comment_content']);
    //header("Location: ./displaysinglepage.php?post_id=$redirectPostValue&parentId&reply");
}