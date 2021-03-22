<?php
include './app/controllers/userscontroller.php'; //access to dbRequests through this file
include './app/controllers/postscontroller.php';
?>
<?php include "./app/includes/header.php";?>
<body>
<form id="createEntry" class="createForm" name="create-phone-entry" action="create_post.php" method="post" enctype="multipart/form-data" >
                <h2 class="text-center">Create a New Entry</h2>

                    <div class="form">
                    <?php include "./app/helpers/formErrors.php"; ?>

                        <hr />
                        <div class="form-group">
                            <input type="hidden" name="poster_id_aka_user_id" class="" value="<?php echo $_SESSION['user_id']?>">
                        </div>

                        <div class="form-group">
                            <label>Post Title</label>
                            <input type="text" name="post_title" class="" value=<?php echo $post_title;?>>
                        </div>

                        <div class="form-group">
                            <label>Post Content</label>
                            <textarea type="text" name="post_text" class="" placeholder="Enter your text here..."><?php echo $post_text;?></textarea>
                        </div>

                        <div class="form-group">
                        <label>Image Upload (must be a .jpg file)</label>
                            <input type="file" name="image_filename" value="holder.jpg" class="imageInput" value=<?php echo $image_filename;?>>
                        </div>

                        <div class="form-group text-center" >
                        <label></label>
                        <button type="submit" name="create-btn" class="btn btn-success">SUBMIT ENTRY</button>
                        <!-- <button type="button" onclick="location.href='../phones'" class="btn btn-primary">BACK TO LIST</button> -->
                        </div>
                    </div>
                </form>
</body>
</html>