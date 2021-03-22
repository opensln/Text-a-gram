<?php
include './app/controllers/postscontroller.php';
include './app/controllers/userscontroller.php';
?>

<?php
$requestedInfo = selectAllWithAvatar('post_table', $conditionsData =[]);
//logProg($requestedInfo);
?>

<?php include "./app/includes/header.php";?>
<?php if(isset($_SESSION['user_id'])): ?>
    <h4 class="postPageTitle">Conversations</h4>
<?php else: ?>
    <h4 class="postPageTitle">Click on a post to read the comments or Log in to join the conversation.</h4>
<?php endif;?>

<section>

    <?php foreach ($requestedInfo as $item): ?>
        <div class='postContainer'>
        <div class="postTitleBar">
            <img class="avatarHolder" width="30px" height="30px" src='./assets/images/avatars/<?php echo $item['avatar_image']?>' alt="<?php echo $item['avatar_image']?>">
            <h4 class="postTitle"><?php echo $item['post_title']?></h4>
        </div>
        <div class="linkInfo">
            <input type='text' name='poster_id_aka_user_id' value='poster_id: <?php echo $item['poster_id_aka_user_id']?>'>
            <input type='text' name='post_id' value='post_id: <?php echo $item['post_id']?>'>
        </div>
        <!-- <input type='text' name='image_filename' value='<?php echo $item['image_filename']?>'> -->
        <img class="postImg" width="100%" style='background-image:url("./assets/images/<?php echo $item['image_filename']?>")'>
        <p><?php echo substr($item['post_text'], 0, 30). '...'?></p>
        <input type='hidden' name='date' value='<?php echo $item['date']?>'>
        <a href='./displaysinglepage.php?post_id=<?php echo $item['post_id']?>&parentId&reply'><button class="readMore">Read More...</button></a>
       
    </div>
    <?php endforeach; ?>

</section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>

