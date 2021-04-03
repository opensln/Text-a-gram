function submitComment() {
  return false;
}

$(document).ready(function () {

  //Submit-Reply
  $("body").on("click", ".submitReplyBtn", function (event) {
    event.preventDefault();

    //alert(event.target.name);
    var replyBtnId = event.target.value;

    var comment_parent_id = event.target.value;
    //Tagging variables for jQuery
    var reply_comment_content_id = $("#reply_comment_content_id" + replyBtnId).val();
    var commenter_id_aka_user_id = $("#reply_user_id" + replyBtnId).val();
    var comment_post_id = $("#reply_post_id" + replyBtnId).val();
    var commentBox_id = "#commentBox_id" + (replyBtnId);

    if (reply_comment_content_id != "") {
      $.ajax({
        method: "POST",
        url: "displaysinglepage.php",
        dataType: "text",
        data: {
          replyComment: 1,
          comment_parent_id: comment_parent_id,
          comment_post_id: comment_post_id,
          commenter_id_aka_user_id: commenter_id_aka_user_id,
          comment_content: reply_comment_content_id,
        },
        success: function (response) {
          console.log(response);
          $(commentBox_id).after("<div class='displayReplyBox'>" + response + "</div>");
          $("#replyFormContainer_id").remove();
          //TODO - Create the shape of the comment Box
          var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
          $(replyFormContainer_id).css("display", "none");
          // $(replyFormContainer_id).html('');

        },
      });
    } else {
      alert("you cannot send an empty message from ajax");
    }
    
  });

  //Submit-Comment
  $("body").on("click", "#commentSubmitBtn", function (event) {
    event.preventDefault();

    //alert("trigger detection");

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
});

