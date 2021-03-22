<?php
include './app/controllers/userscontroller.php';
?>
<?php include "./app/includes/header.php";?>
<body>

                <form id="loginForm" class="loginForm" name="login-form" action="loginform.php" method="post" enctype="multipart/form-data" >
                    <h2 class="text-center">Log in to your Account</h2>

                    <div class=" form">

                    <?php include "./app/helpers/formErrors.php";?>
                        <hr>

                        <div class=" form-group">
                            <label class="loginFormLabel">Username</label>
                            <input type="text" name="username" class="" placeholder="Duncan or Mona or Lucy or Peter" value=<?php echo $username;?>>
                        </div>

                        <div class="form-group">
                            <label class="registerFormLabel"  >Password</label>
                            <input type="password" name="pwd" placeholder="123" class="" value="">
                        </div>
                        <?php if(isset($_GET['post_id'])): ?>
                            <input type="hidden" name="fromPageInfo" value="<?php echo $_GET['post_id']?>">
                        <?php else: ?>
                            <input type="hidden" name="fromPageInfo" value="<?php echo $redirectPostValue?>">
                        <?php endif; ?>

                        <div class="form-group text-center loginLinkBox" >
                        <button type="submit" name="login-btn" class="btn btn-success">LOG IN</button>
                        <p class="signupLink"><a style="text-decoration:underline;" href="./registerform.php">or sign-up</a></p>
                        </div>

                    </div>
                </form>    
</body>
<html>

<script type="text/javascript" src="./assets/js/bootstrap.js"></script>
