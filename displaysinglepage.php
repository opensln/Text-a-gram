<?php
include './app/controllers/userscontroller.php'; //access to dbRequests through this file
include './app/controllers/commentscontroller.php';
include './app/controllers/postscontroller.php';

?>

<?php

$requestedInfo = selectOneWithPostedByInfo('post_table', ['post_id' => $_GET['post_id']]);
//logProg($requestedInfo);

$relatedComments = getRelatedComments($_GET['post_id']);
//logProg($relatedComments);
?>
<?php include "./app/includes/header.php";?>

<!-- <p id="testDiv">...testDiv</p> -->

  <a class="backButtonHolder" href='./conversations.php' ><button class="backButton">Back to Post List</button></a>
  <!--Post Container-->
  <div class='singlePostContainer'>

        <p style='display:none' ><?php echo $requestedInfo['poster_id_aka_user_id'] ?></p>
        <img class="avatarHolderSinglePage" width="30px" height="30px" src='./assets/images/avatars/<?php echo $requestedInfo['avatar_image'] ?>' alt="<?php echo $requestedInfo['avatar_image'] ?>">
        <p class="infospan infospan1">Posted by: <?php echo $requestedInfo['username'] ?></p>
        <p class="infospan">post_id: <?php echo $requestedInfo['post_id'] ?></p>
        <p class="infospan"><?php echo date('F, j, Y', strtotime($requestedInfo['date'])) ?></p>
        <h2 style="text-align:center;"><?php echo $requestedInfo['post_title'] ?></h2>
        <input style='display:none' type='text' name='image_filename' value='<?php echo $requestedInfo['image_filename'] ?>'>
        <img class="postImg" width="100%" style='background-image:url("./assets/images/<?php echo $requestedInfo['image_filename'] ?>")'>
        <p><?php echo $requestedInfo['post_text'] ?></p>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $requestedInfo['poster_id_aka_user_id']): ?>
            <form method="POST" action="displaysinglepage.php" class="userBtnBar">
                <input type="hidden" name="post_id" value="<?php echo $requestedInfo['post_id'] ?>">
                <input type="submit" name="delete-post" value="Delete" class="btn btn-dangerx delBtn" onclick="return confirm('Are you sure you want to delete this comment? This discussion will be gone forever!!');">
            </form>
        <?php endif;?>

    </div>
    <!--End Post Container-->
    <hr>


<?php if (isset($_SESSION['user_id'])): ?>
    <div class='commentFormContainer'>

                <?php if (isset($_GET['emptycomment'])): ?>
                    <div class="msg error">You cannot submit an empty comment!</div>
                <?php endif;?>

        <form method='POST' action='' onsubmit='return submitComment();'>
            <label style='display:none;' >current user_id</label>
            <input id="commenter_id_aka_user_id" style='display:none;' type='text' name='commenter_id_aka_user_id' value='<?php echo $_SESSION['user_id'] ?>'>
            <label style='display:none;' >comment_post_id:</label>
            <p>Logged in as: <?php echo $_SESSION['username'] ?></p>
            <p style='display:none;'>Commenting on post_id: <?php echo $requestedInfo['post_id'] ?> <i> <?php echo $requestedInfo['post_title'] ?> </i></p>
            <input id="comment_post_id" style='display:none;' type='text' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>

            <?php if ($update == true): ?>
                <input style='display:none;' type='text' name='comment_id' value='<?php echo $editing_id ?>'>

                <textarea id="updatedCommentContent" name='comment_content' placeholder='type your comment here...'><?php echo $editing_text ?></textarea>
                <button id="updateCommentBtn" class='commentUpdateBtn btn btn-success' type='' name=''>Update it</button>
                <a class='cancelUpdateBtn btn btn-danger float-right' href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId&reply">Cancel Update</a>
            <?php else: ?>
                <textarea id="comment_content" name='comment_content' placeholder='type your comment here...'></textarea>
                <button id="commentSubmitBtn" class='commentSubmitBtn' type='' name=''>Submit Comment</button>
            <?php endif;?>

        </form>
    </div>
    <!--Show if user is not logged in-->
<?php else: ?>

        <?php if (empty($relatedComments)): ?>
            <p class="makeCommentNotice">Be the first to make a comment.</p>
        <?php else: ?>
            <p class="makeCommentNotice"><a href="./loginform.php?post_id=<?php echo $requestedInfo['post_id'] ?>">Log in</a> to make a comment.</hp>
        <?php endif;?>

<?php endif;?> <!--Options for user who is not logged in-->
<?php echo $reply ?>
<div id="commentListDiv">
    <?php foreach ($relatedComments as $item): ?>
        <?php if ($item['comment_parent_id'] <= 0): ?><!--main if statement-->
            <div class="displayCommentBox" id="commentBox_id<?php echo $item['comment_id'] ?>">
                <input hidden type="text" name='comment_id' value='comment_id: <?php echo $item['comment_id'] ?>'>
                <input id='comment_post_id<?php echo $item['comment_id'] ?>'  style='display:none;' type="text" name='comment_post_id' value='<?php echo $item['comment_post_id'] ?>' style="color:lightgrey;">
                <input id='commenter_id_aka_user_id<?php echo $item['comment_id'] ?>'  style='display:none;' type='text' name='commenter_id_aka_user_id' value=<?php echo $item['commenter_id_aka_user_id'] ?>>
                <img class="avatarHolderSinglePage" width="30px" height="30px" src='./assets/images/avatars/<?php echo $item['avatar_image'] ?>' alt="<?php echo $item['avatar_image'] ?>">
                <p class="commentBoxInfoBar" type='text' name='comment_content' >
                    <span><strong><?php echo $item['username'] ?></strong></span> <?php echo date('F, j, Y', strtotime($item['date'])) ?>:
                </p>
                <p> <?php echo $item['comment_content'] ?></p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button id='replyBtn<?php echo $item['comment_id'] ?>' type='button' onclick='' value='<?php echo $item['comment_id'] ?>' class='btn replyBtn' name='replyBtn<?php echo $item['comment_id'] ?>'>Reply</button>
                <?php endif;?>

                    <!--If the user is logged in and it is their own comment then show the edit and delete buttons-->
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['commenter_id_aka_user_id']): ?>
                            <div id='userBtnBar<?php echo $item['comment_id'] ?>' class="userBtnBar">
                                <form  id='editForm<?php echo $item['comment_id'] ?>' class='.editForm' method='POST' action='displaysinglepage.php' style='width:70%; position:absolute; bottom: 5px;right: 5px;'>
                                    <a class="btn btn-successx editBtn" href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId&editing_id=<?php echo $item['comment_id'] ?>&reply" >Edit</a>
                                    <input type='hidden' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>
                                    <input type="hidden" name="comment_id" value="<?php echo $item['comment_id'] ?>">
                                    <input type="submit" name="delete-comment" class="btn btn-dangerx delBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this comment?');">
                                </form>
                            </div>
                        <?php endif;?>

                <!--Start Reply Form-->
                <div id='replyFormContainer_id<?php echo $item['comment_id'] ?>' class='replyFormContainer'> <!--Only visible by folloeing the reply url-->
                    <form method='POST' action='' onsubmit='return submitComment();'>

                    <!--for submission-->
                        <input hidden id='reply_user_id<?php echo $item['comment_id'] ?>' hiddenx type='text' name='commenter_id_aka_user_id' value='<?php echo $_SESSION['user_id'] ?>'>
                        <input hidden id='reply_post_id<?php echo $item['comment_id'] ?>' hiddenx type='text' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>
                        <input hidden id='reply_parent_id<?php echo $item['comment_id'] ?>' hiddenx type='text' name='comment_parent_id' value='<?php echo $item['comment_id'] ?>'>
                        <textarea id='reply_comment_content_id<?php echo $item['comment_id'] ?>' name='comment_content' placeholder='type your reply here...'></textarea>
                        <button id='submitReplyBtn<?php echo $item['comment_id'] ?>'
                                class='submitReplyBtn btn btn-success'
                                type=''
                                value='<?php echo $item['comment_id'] ?>'
                                name=''
                                data-commenter_id_aka_user_id='<?php echo $_SESSION['user_id'] ?>'
                                data-comment_post_id='<?php echo $requestedInfo['post_id'] ?>'
                                data-comment_parent_id='<?php echo $item['comment_id'] ?>'
                                >Reply</button>
                        <button id='cancelReplyBtn<?php echo $item['comment_id'] ?>' class='cancelReplyBtn btn btn-danger float-right' type='' value='<?php echo $item['comment_id'] ?>' onclick=''>Cancel Reply</button>
                    </form>
                </div>
            <!--End Reply Form-->

    </div>
    <!--Start Reply loop-->
    <?php foreach ($relatedComments as $reply): ?>
        <?php if ($reply['comment_parent_id'] == $item['comment_id']): ?>
            <div class="displayReplyBox">
                <input hidden value="<?php echo $reply['comment_parent_id'] ?>">
                <input hidden type="text" name='comment_id' value='comment_id: <?php echo $reply['comment_id'] ?>'>
                <input style='display:none;' type="text" name='comment_post_id' value='comment_post_id: <?php echo $reply['comment_post_id'] ?>' style="color:lightgrey;">
                <input style='display:none;' type='text' name='commenter_id_aka_user_id' value=<?php echo $reply['commenter_id_aka_user_id'] ?>>
                <img class="avatarHolderSinglePage" width="30px" height="30px" src='./assets/images/avatars/<?php echo $reply['avatar_image'] ?>' alt="<?php echo $reply['avatar_image'] ?>">
                <p class="commentBoxInfoBar" type='text' name='comment_content' >
                    <span><strong><?php echo $reply['username'] ?></strong></span> <?php echo date('F, j, Y', strtotime($reply['date'])) ?>:
                </p>
                <p> <?php echo $reply['comment_content'] ?></p>

                    <!--Start Reply Edit Form--->
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $reply['commenter_id_aka_user_id']): ?>
                        <br>
                        <div class="userBtnBar">
                            <form  id="editForm<?php echo $reply['comment_id'] ?>" method='POST' action='displaysinglepage.php'>
                                <input type='hidden' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>
                                <input type="hidden" name="comment_id" value="<?php echo $reply['comment_id'] ?>">
                                <input type="submit" name="delete-comment" class="btn btn-dangerx delBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this reply?');">
                            </form>
                        </div>
                    <?php endif;?>
                    <!--End Reply Edit Form-->
            </div> <!--End-Display Reply Box-->
        <?php endif;?>
    <?php endforeach;?>
     <!--End Reply Loop-->

<?php endif;?><!--end main if statement-->
    <?php endforeach;?>
</div> End test2Div


    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script>
    function showEditBox() {
    alert("I am an edit Box");
    }
    </script>

    <script type="text/javascript" src="./ajaxFormSubmissions.js" ></script>
    <script type="text/javascript" src="./helpers.js" ></script>

</body>
</html>