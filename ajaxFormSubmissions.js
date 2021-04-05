function submitComment() {
  return false;
}

$(document).ready(function () {

  //----------------------------------------------------------Submit-Reply
  $("body").on("click", ".submitReplyBtn", function (event) {
    event.preventDefault();

    //alert(event.target.name);
    var replyBtnId = event.target.value;
    //alert("target value " + event.target.value);

    var comment_parent_id = replyBtnId;
    var comment_post_id = $("#reply_post_id" + replyBtnId).val(); //Tagging variables for jQuery
    var commenter_id_aka_user_id = $("#reply_user_id" + replyBtnId).val(); //Tagging variables for jQuery
    var reply_comment_content_id = $("#reply_comment_content_id" + replyBtnId).val();  //Tagging variables for jQuery
   
    var commentBox_id = "#commentBox_id" + (replyBtnId);
    console.log(commentBox_id);

// console.log("comment_parent_id" + comment_parent_id);
// console.log(comment_post_id);
// console.log(commenter_id_aka_user_id);
// console.log(reply_comment_content_id);

    if (reply_comment_content_id != "") {
      $.ajax({
        method: "POST",
        url: "displaysinglepage.php",
        dataType: "text",
        data: {
          submitReply: 1,
          comment_parent_id: comment_parent_id, //Which comment is it attached to?
          comment_post_id: comment_post_id, //Which post is it attached to?
          commenter_id_aka_user_id: commenter_id_aka_user_id, //Who is writing the comment?
          comment_content: reply_comment_content_id, //What are they saying/submitting?
        },
        success: function (response) {
          //console.log(response);
          $(commentBox_id).after(response);
    
          var replyFormContainerTag = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
          $(replyFormContainerTag).remove();
          var replyBtnTag = "#replyBtn" + replyBtnId;
          $(replyBtnTag).removeAttr("disabled"); //Re-enable the reply button

          var userBtnBarTag = "#userBtnBar" + replyBtnId; //Bring back the edit and delete buttons
          $(userBtnBarTag).css("display", "block");

        },
      });
    } else {
      alert("you cannot send an empty message from ajax");
    }
    
  });

  //-----------------------------------------------------------Submit-Comment
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
          var commentTextareaTAG = "#comment_content";
          $(commentTextareaTAG).val('');
        },
      });
    } else {
      alert("you cannot send an empty message from ajax");
    }
  });
});

//-----------------------------------------------------------------Submit Update Comment
$("body").on("click", ".commentUpdateBtn", function (event) {
  event.preventDefault();

var editBtnId = event.target.value;

var textareaEditBoxVal = $("#textareaEditBox" + editBtnId).val();
    textareaEditBoxVal += "...(edited)";
var comment_post_idVal = $("#comment_post_id" + editBtnId).val();

//console.log("textareaEditBox " + textareaEditBoxVal);
//console.log("comment_post_idVal " + comment_post_idVal);

$.ajax({
  method: "POST",
  url: "displaysinglepage.php",
  dataType: "text",
  data: {
      updateComment: 1,
      comment_id : editBtnId,
      comment_content: textareaEditBoxVal,
      comment_post_id: comment_post_idVal,
  },
  success: function (response) {
      //console.log(response);
      //location.reload();

      var editTextareaHolderTag = "#editTextareaHolder" + editBtnId;
      $(editTextareaHolderTag).css("display", "none");

      var old_comment_contentTag = "#comment_content" + editBtnId;
      $(old_comment_contentTag).html(response);
      $(old_comment_contentTag).css("display", "block");

      var replyBtnTag = "#replyBtn" + editBtnId;
      $(replyBtnTag).css("display", "block");
    
      var editFormTag = "#editForm" + editBtnId;
      $(editFormTag).css("display", "block");
  },
});

});
