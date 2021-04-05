//listening for buttons that pass in the value of clicked button using event.target.value

$("body").on("click", ".replyBtn", function (event) {
  console.log(event.target.value + "----from .replyBtn event target");

  var replyBtnId = event.target.value;

  var reply_comment_content_id = "#reply_comment_content_id"+replyBtnId;
  $(reply_comment_content_id).val(''); //Clear the reply textarea

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
  $(replyFormContainer_id).css("display", "block");

  var userBtnBarTag = "#userBtnBar" + replyBtnId;
  $(userBtnBarTag).css("display", "none");

});

$("body").on("click", ".cancelReplyBtn", function (event) {
  event.preventDefault();
  console.log(event.target.value + "----from .cancelReplyBtn event target");

  var replyBtnId = event.target.value;

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
  
  $(replyFormContainer_id).css("display", "none");

  var userBtnBarTag = "#userBtnBar" + replyBtnId;
  $(userBtnBarTag).css("display", "block");
});

$("body").on("click", ".cancelDynamicReplyBtn", function (event) {
  event.preventDefault();

  var replyBtnId = event.target.value;
  
  var replyBtnTag = "#replyBtn" + replyBtnId;
  $(replyBtnTag).removeAttr("disabled");

  var replyFormContainerTag = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
  $(replyFormContainerTag).remove();

  var userBtnBarTag = "#userBtnBar" + replyBtnId;
  $(userBtnBarTag).css("display", "block");

 
});

//--data- attr are used to get id information from the dynamically created elements which otherwise would not be accesible
$("body").on("click", ".dynamicReplyBtn", function (event) {

    var currentParentId = event.target.value;
    var comment_post_id = event.target.getAttribute("data-comment_post_id");

    var replyBtnId = event.target.value;
    var userBtnBarTag = "#userBtnBar" + replyBtnId;
    $(userBtnBarTag).css("display", "none");

    makeDynamicReplyFormVisible(currentParentId, comment_post_id);
});

function makeDynamicReplyFormVisible(currentParentIdObj, comment_post_idObj) {
  //alert(currentParentIdObj + "from inside makeDynamicReplyFormVisible");

  console.log("current parent Id " + currentParentIdObj);
  console.log("comment post id " + comment_post_idObj);

  var replyBtnTag = "#replyBtn" + currentParentIdObj;
  var commentBoxTag = "#commentBox_id" + (currentParentIdObj); //--remember the # in future
  var replyFormContainerTag = "#replyFormContainer_id" + (currentParentIdObj); //--remember the # in future
  //alert(replyFormContainer_id +" jQuery form hash");
  $(replyFormContainerTag).css("display", "block");

    $.ajax({
      method: "POST",
      url: "displaysinglepage.php",
      dataType: "text",
      data: {
          showReplyForm: 1,
          comment_parent_id :currentParentIdObj,
          comment_post_id: comment_post_idObj,
      },
      success: function (response) {
          //console.log(response);
        
          $(commentBoxTag).append(response);
          $(replyBtnTag).prop("disabled", "true");

      },
    });
}

//--Delete Comment
$("body").on("click", ".delBtn",function (event) {
  event.preventDefault();

  var result = confirm("Are you sure you want to delete this comment?")

  if (result) {
  //console.log("Value from delBtn " + event.target.value);
  var delBtnCommentId = event.target.value;
  //console.log("triggered from delBtn helper");

  var displayReplyBoxTag = "#displayReplyBox" + delBtnCommentId;
  var commentBoxTag = "#commentBox_id" + delBtnCommentId; 

  $.ajax({
    method: "POST",
    url: "displaysinglepage.php",
    dataType: "text",
    data: {
        deleteComment: 1,
        comment_id :delBtnCommentId,
    },
    success: function (response) {
        //console.log(response);

        $(displayReplyBoxTag).remove(); //If this exists then the commentBox with the same Id will note exist due to the auto increment of the comment ids.
        $(commentBoxTag).remove();
    },
  });
} //--End if (result)
});

//--Show Update Comment TextArea
$("body").on("click", ".editBtn", function (event) {
  event.preventDefault();
  //console.log("edit button " + event.target.value);
  var editBtnId = event.target.value;

  var old_comment_contentTag = "#comment_content" + editBtnId;
  var editTextareaHolderTag = "#editTextareaHolder" + editBtnId;
  var editFormTag = "#editForm" + editBtnId;
  var replyBtnTag = "#replyBtn" + editBtnId;

  // console.log("old_comment_contentTag " + old_comment_contentTag);
  // console.log("editTextareaBoxTag " + editTextareaHolderTag);
  // console.log("editFormTag " + editFormTag);
  // console.log("replyBtnTag " + replyBtnTag);

  $(editTextareaHolderTag).css("display", "block");
  $(old_comment_contentTag).css("display", "none");
  $(editFormTag).css("display", "none");
  $(replyBtnTag).css("display", "none");

});

function cancelReplyForm(replyForm) {

    var replyFormContainer_id = "#replyFormContainer_id"+replyForm.value; //--remember the # in future

    $(replyFormContainer_id).css("display", "none");

}