$(document).ready(function () {

  // $("body").on("click", "????", function (event) {
  //   event.preventDefault();
  // }

  //TODO document ready for update
  $("body").on("click", "#submitReplyBtn", function (event) {
    event.preventDefault();

    var replyCommentContent = $("#replyCommentContent").val();
    var commenter_id_aka_user_id = $("#replyUserId").val();
    var comment_post_id = $("#replyPostId").val();
    var comment_parent_id = $("#replyParentId").val();

    alert("replyBtn submission");
    alert(replyCommentContent, "content");
    alert(commenter_id_aka_user_id);
    alert(comment_post_id);
    alert(comment_parent_id);

    // if (comment_content != "") {
    //   $.ajax({
    //     method: "POST",
    //     url: "displaysinglepage.php",
    //     dataType: "text",
    //     data: {
    //       submitComment: 1,
    //       comment_post_id: comment_post_id,
    //       commenter_id_aka_user_id: commenter_id_aka_user_id,
    //       comment_content: updatedContent,
    //     },
    //     success: function (response) {
    //       $("#commentListDiv").prepend(response);
    //       //TODO - Create the shape of the comment Box
    //     },
    //   });
    // } else {
    //   alert("you cannot send an empty message from ajax");
    // }

  });

  //TODO document ready for submit
  $("body").on("click", "#commentSubmitBtn", function (event) {
    event.preventDefault();

    var comment_content = $("#comment_content").val();
    var commenter_id_aka_user_id = $("#commenter_id_aka_user_id").val();
    var comment_post_id = $("#comment_post_id").val();
    //alert("Here instead of form submission");
  
    if (comment_content != "") {
      $.ajax({
        method: "POST",
        url: "displaysinglepage.php",
        dataType: "text",
        data: {
          submitComment: 1,
          comment_post_id: comment_post_id,
          commenter_id_aka_user_id: commenter_id_aka_user_id,
          comment_content: comment_content,
        },
        success: function (response) {
          $("#commentListDiv").prepend(response);
          //TODO - Create the shape of the comment Box
        },
      });
    } else {
      alert("you cannot send an empty message from ajax");
    }
  });
  return false;
});
