<?php
include './app/controllers/userscontroller.php';
?>
<?php include "./app/includes/header.php";?>
<body>
<form id="createEntry" class="registerForm" name="create-account" action="registerform.php" method="post" enctype="multipart/form-data" >
                    <h2 class="text-center">Create an Account</h2>

                    <div class=" form">

                    <?php include "./app/helpers/formErrors.php"; ?>
                        <hr>

                        <div class=" form-group">
                            <label class="registerFormLabel">User Name</label>
                            <input type="text" name="username" class="" value=<?php echo $username;?>>
                        </div>

                        <div class="form-group">
                            <label class="registerFormLabel">email</label>
                            <input type="email" name="email" class="" value=<?php echo $email;?>>
                        </div>


                        <div class="form-group">
                            <label class="registerFormLabel"  >Password</label>
                            <input type="password" name="pwd" class="" value=<?php echo $pwd;?>>
                        </div>

                        <div class="form-group">
                            <label class="registerFormLabel" >Confirm Your Password</label>
                            <input type="password" name="pwdConf" class="" value=<?php echo $pwdConf;?>>
                        </div>

                        <div class="form-group">
                        <label>Image Upload (must be a .jpg file)</label>
                            <input type="file" name="image_filename" value="holder.jpg" class="imageInput" value=<?php echo $image_filename;?>>
                        </div>

                        <div class="form-group text-center loginLinkBox" >
                        <label></label>
                        <button type="submit" name="register-btn" class="btn btn-success">REGISTER</button>
                        </div>

                    </div>
                </form>    
</body>
</html>