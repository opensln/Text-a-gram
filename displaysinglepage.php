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

<p id="testDiv">Start with something inside</p>

  <a class="backButtonHolder" href='./conversations.php' ><button class="backButton">Back to Post List</button></a>
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

                <textarea name='comment_content' placeholder='type your comment here...'><?php echo $editing_text ?></textarea>
                <button class='commentUpdateBtn btn btn-success' type='submit' name='update-comment'>Update</button>
                <a class='cancelUpdateBtn btn btn-danger float-right' href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId&reply">Cancel Update</a>
            <?php else: ?>
                <textarea id="comment_content" name='comment_content' placeholder='type your comment here...'></textarea>
                <button class='commentSubmitBtn' type='submit' name=''>Submit Comment</button>
            <?php endif;?>

        </form>
    </div>
<?php else: ?>

        <?php if (empty($relatedComments)): ?>
            <p class="makeCommentNotice">Be the first to make a comment.</p>
        <?php else: ?>
            <p class="makeCommentNotice"><a href="./loginform.php?post_id=<?php echo $requestedInfo['post_id'] ?>">Log in</a> to make a comment.</hp>
        <?php endif;?>

<?php endif;?>

    <?php foreach ($relatedComments as $item): ?>
        <?php if ($item['comment_parent_id'] <= 0): ?><!--main if statement-->
            <div class="displayCommentBox" id="comment_id<?php echo $item['comment_id']?>">
                <input hidden type="text" name='comment_id' value='comment_id: <?php echo $item['comment_id'] ?>'>
                <input style='display:none;' type="text" name='comment_post_id' value='comment_post_id: <?php echo $item['comment_post_id'] ?>' style="color:lightgrey;">
                <input style='display:none;' type='text' name='commenter_id_aka_user_id' value=<?php echo $item['commenter_id_aka_user_id'] ?>>
                <img class="avatarHolderSinglePage" width="30px" height="30px" src='./assets/images/avatars/<?php echo $item['avatar_image'] ?>' alt="<?php echo $item['avatar_image'] ?>">
                <p class="commentBoxInfoBar" type='text' name='comment_content' >
                    <span><strong><?php echo $item['username'] ?></strong></span> <?php echo date('F, j, Y', strtotime($item['date'])) ?>:
                </p>
                <p> <?php echo $item['comment_content'] ?></p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId=<?php echo $item['comment_id'] ?>&reply=true" class="btn replyBtn">Reply</a>
                <?php endif;?>

                <?php if ($_GET['parentId'] =="nullSpacer"):?>
                <p>Ola!</p>
                <?php elseif ($_GET['parentId'] == $item['comment_id']): ?> <!--Show Reply Form if this is true--This can only happen if the reply button is clicked-->

            <!--Start Reply Form-->
                <div class='replyFormContainer'>
                    <form method='POST' action='displaysinglepage.php'> 

                    <!--for Debugging-->
                        <p style="display:none">Logged in as: <?php echo $_SESSION['username'] ?></p>
                        <p style="display:none">User Id: <?php echo $_SESSION['user_id'] ?></p>
                        <p style="display:none">Commenting on post_id: <?php echo $requestedInfo['post_id'] ?> <i> <?php echo $requestedInfo['post_title'] ?> </i></p>
                        <p style="display:none">New ParentId: <?php echo $item['comment_id'] ?></p>
                        <p style="display:none">Parent Comment Content<i> <?php echo $item['comment_content'] ?> </i></p>
                    <!--for submission-->
                        <input hidden type='text' name='commenter_id_aka_user_id' value='<?php echo $_SESSION['user_id'] ?>'>
                        <input hidden type='text' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>
                        <input hidden type='text' name='comment_parent_id' value='<?php echo $item['comment_id']?>'>
                        <textarea name='comment_content' placeholder='type your reply here...'><?php echo $editing_text ?></textarea>
                        <button class='submitreplyBtn btn btn-success' type='submit' name='reply-comment'>Reply</button>
                        <a class='cancelReplyBtn btn btn-danger float-right' href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId&reply">Cancel Reply</a>
                    </form>
                </div>
        <?php endif;?>
            <!--End Reply Form-->
 
        <?php if ($update == true && $_SESSION['user_id'] == $item['commenter_id_aka_user_id']): ?> 
        <p class="text-center"> updating comment...</p>
        <?php else: ?> <!--If(1) Show userBar-->
                <!--if user is REPLYING to their own comment then hide edit buttons-->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['commenter_id_aka_user_id'] && $_GET['reply'] == true): ?> <!--If(2)-->
                <!--this is showing nothing as opposed to showing the edit buttons-->
                <?php else: ?>
                        <!--If the user is logged in "NOT REPLYING" and it is their own comment then show the edit and delete buttons-->
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['commenter_id_aka_user_id']): ?> <!--If(3)-->
                            <div class="userBtnBar">
                                <form  id="editForm" method='POST' action='displaysinglepage.php'>
                                    <a class="btn btn-successx editBtn" href="./displaysinglepage.php?post_id=<?php echo $_GET['post_id'] ?>&parentId&editing_id=<?php echo $item['comment_id'] ?>" >Edit</a>
                                    <input type='hidden' name='comment_post_id' value='<?php echo $requestedInfo['post_id'] ?>'>
                                    <input type="hidden" name="comment_id" value="<?php echo $item['comment_id'] ?>">
                                    <input type="submit" name="delete-comment" class="btn btn-dangerx delBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this comment?');">
                                </form>
                            </div>
                        <?php endif;?><!-- end If(3)-->
                <?php endif;?> <!-- end If(2)-->
        <?php endif;?> <!--End If(1) UserBar-->
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
                            <form  id="editForm" method='POST' action='displaysinglepage.php'>
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



    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script>
    function showEditBox() {
    alert("I am an edit Box");
    }
    </script>

    <script type="text/javascript" src="./ajaxrequests.js" ></script>

</body>
</html>