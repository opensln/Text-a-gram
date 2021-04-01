function submitComment() {

//alert("Here instead of form submission");

var comment_content = $("#comment_content").val();
//console.log(comm_id);
var commenter_id_aka_user_id = $("#commenter_id_aka_user_id").val();
//console.log(date);
var comment_post_id = $("#comment_post_id").val();
//console.log(message);

// $("#testDiv").append(comment_content);
// $("#testDiv").append(commenter_id_aka_user_id);
// $("#testDiv").append(comment_post_id);

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
        $(".commentFormContainer").prepend("<p>"+ response + "</p>");
        //TODO - Create the shape of the comment Box
      },
    });
  } else {
    alert("you cannot send an empty message");
  }

return false;
}