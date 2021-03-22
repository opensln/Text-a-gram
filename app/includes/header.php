<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="rwa.danielsmithldn.com/textagram/assets/images/textagram.jpg"/>
    <title>Text-a-gram</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/css.css">
    <link rel="stylesheet" href="./assets/css/login.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="./conversations.php">Text-a-gram</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav userLinks">
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="./create_post.php"><button class="btn btn-primary createEntryButton" style="">Create New Entry</button></a>
        <a class="nav-link" href="#"><?php echo "Hello ".$_SESSION['username']."!"?></a>
        <img class="navAvatarHolder" width="30px" height="30px" src='./assets/images/avatars/<?php echo $_SESSION['avatar_image']?>' alt="<?php echo $_SESSION['avatar_image']?>">
        <a class="nav-link" href="<?php echo './logout.php' ?>">Log out</a>
        <?php else: ?>
            <?php if(isset($_GET['post_id'])) :?>
                <a class="nav-link" href="<?php echo './loginform.php?post_id='.$_GET['post_id']?>">Log in to post or comment!</a>
                <?php else: ?>
                  <a class="nav-link" href="<?php echo './loginform.php'?>">Log in to post or comment!</a>
            <?php endif;?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>