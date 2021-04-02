function makeReplyFormVisible(replyForm) {

    var comment_parent_id = replyForm.value;
    console.log(comment_parent_id);

    var comment_post_idTag = "#comment_post_id"+replyForm.value;
    console.log(comment_post_idTag + " comment Post"); 
    var comment_post_id = $(comment_post_idTag).val();
    console.log("comment post id "+comment_post_id);

    var commenter_id_aka_user_idTag = "#commenter_id_aka_user_id"+replyForm.value;
    console.log(commenter_id_aka_user_idTag + " commenter_id_aka_user_id");
    var commenter_id_aka_user_id = $(commenter_id_aka_user_idTag).val();
    console.log("user id " + commenter_id_aka_user_id);

    var commentBox_id = "#commentBox_id"+replyForm.value; //--remember the # in future

      $.ajax({
        method: "POST",
        url: "displaysinglepage.php",
        dataType: "text",
        data: {
            showReplyForm: 1,
            comment_parent_id :comment_parent_id,
            comment_post_id: comment_post_id,
            commenter_id_aka_user_id :commenter_id_aka_user_id,
        },
        success: function (response) {
            console.log(response);
            $(commentBox_id).after(response);
        },
      });
 
    }

    function cancelReplyForm(replyForm) {
        
        var replyFormContainer_id = "#replyFormContainer_id"+replyForm.value; //--remember the # in future

        $(replyFormContainer_id).css("display", "none");
     
    }