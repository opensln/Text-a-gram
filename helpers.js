

//listen for any reply button but pas in the value of clicked button using event.target.name

$("body").on("click", ".replyBtn", function (event) {
  console.log(event.target.value + "----from .replyBtn event target");

  var replyBtnId = event.target.value;

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future

  $(replyFormContainer_id).css("display", "block");

  // makeReplyFormVisible(replyBtnId );
});

$("body").on("click", ".cancelReplyBtn", function (event) {
  event.preventDefault();
  console.log(event.target.value + "----from event target");

  var replyBtnId = event.target.value;

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future

  $(replyFormContainer_id).css("display", "none");
});

$("body").on("click", ".dynamicReplyBtn", function (event) {

    var currentParentId = event.target.value;

    console.log(currentParentId + "----from .dynamicReplyBtn event target");
    console.log(event.target.getAttribute("data-commenter_id_aka_user_id") + "----does data-work for me");
    console.log(event.target.getAttribute("data-comment_post_id") + "----postId data-work for me");


    var commenter_id_aka_user_id = event.target.getAttribute("data-commenter_id_aka_user_id");
    console.log(commenter_id_aka_user_id + "commenter id from data-dash");

    var comment_post_id = event.target.getAttribute("data-comment_post_id");
    console.log(comment_post_id + "comment post id if from data-dash");



   
   
    makeDynamicReplyFormVisible(currentParentId, comment_post_id, commenter_id_aka_user_id );
});

function makeDynamicReplyFormVisible(currentParentIdObj, comment_post_idObj, commenter_id_aka_user_idObj) {
  //alert(currentParentIdObj + "from inside makeDynamicReplyFormVisible");

  var comment_parent_id = currentParentIdObj;
  console.log(comment_parent_id);

  var comment_post_id = comment_post_idObj;
  console.log("comment post id " + comment_post_id);

  var commenter_id_aka_user_id = commenter_id_aka_user_idObj;
  console.log("user id " + commenter_id_aka_user_id);

  var replyBtnTag = "#replyBtn" + currentParentIdObj;
  var commentBox_id = "#commentBox_id" + (currentParentIdObj); //--remember the # in future
  console.log(commentBox_id  + "commentbox hash for jquery");
  var replyFormContainer_id = "#replyFormContainer_id" + (comment_parent_id); //--remember the # in future
  alert(replyFormContainer_id +" jQuery form hash");
  $(replyFormContainer_id).css("display", "block");

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
        
          $(commentBox_id).append(response);
          $(replyBtnTag).prop("disabled", "true");

      },
    });
}

// function cancelReplyForm(replyForm) {

//     var replyFormContainer_id = "#replyFormContainer_id"+replyForm.value; //--remember the # in future

//     $(replyFormContainer_id).css("display", "none");

// }
