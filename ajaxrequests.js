function submitComment() {
  return false;
}

$(document).ready(function () {

  //TODO document ready for update
  $("body").on("click", "#submitReplyBtn", function (event) {
    event.preventDefault();

    //alert(event.target.name);
    var replyBtnId = event.target.value;

    var comment_parent_id = event.target.value;
    console.log(comment_parent_id);

    var reply_comment_content = $("#reply_comment_content" + replyBtnId).val();
    console.log(reply_comment_content + " This should be the tag for jQuery");

    var commenter_id_aka_user_id = $("#reply_user_id" + replyBtnId).val();
    console.log(commenter_id_aka_user_id + " commenter id This should be the tag for jQuery");

    var comment_post_id = $("#reply_post_id" + replyBtnId).val();
    console.log(comment_post_id + " comment_post_id This should be the tag for jQuery");

    var commentBox_id = "#commentBox_id" + (replyBtnId);

    if (reply_comment_content != "") {
      $.ajax({
        method: "POST",
        url: "displaysinglepage.php",
        dataType: "text",
        data: {
          replyComment: 1,
          comment_parent_id: comment_parent_id,
          comment_post_id: comment_post_id,
          commenter_id_aka_user_id: commenter_id_aka_user_id,
          comment_content: reply_comment_content,
        },
        success: function (response) {
          console.log(response);
          $(commentBox_id).after("<div class='displayReplyBox'>" + response + "</div>");
          //TODO - Create the shape of the comment Box
        },
      });
    } else {
      alert("you cannot send an empty message from ajax");
    }
    
  });

  //TODO document ready for submit
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

