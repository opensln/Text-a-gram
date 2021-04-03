

//listen for any reply button but pas in the value of clicked button using event.target.name

$("body").on("click", ".replyBtn", function (event) {
  console.log(event.target.value + "----from .replyBtn event target");

  var replyBtnId = event.target.value;

  var reply_comment_content_id = "#reply_comment_content_id"+replyBtnId;

  $(reply_comment_content_id).val(''); //Clear the reply textarea

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future

  $(replyFormContainer_id).css("display", "block");

});

$("body").on("click", ".cancelReplyBtn", function (event) {
  event.preventDefault();
  console.log(event.target.value + "----from .cancelReplyBtn event target");

  var replyBtnId = event.target.value;

  var replyFormContainer_id = "#replyFormContainer_id" + replyBtnId; //--remember the # in future
  
  $(replyFormContainer_id).css("display", "none");
});

$("body").on("click", ".cancelDynamicReplyBtn", function (event) {
  event.preventDefault();

  var replyBtnId = event.target.value;
  var replyFormContainerTag = "#replyFormContainer_id" + replyBtnId; //--remember the # in future

  var replyBtnTag = "#replyBtn" + replyBtnId;
  $(replyBtnTag).removeAttr("disabled");

  $(replyFormContainerTag).remove();
});

//--data- attr are used to get id information from the dynamically created elements which otherwise would not be accesible
$("body").on("click", ".dynamicReplyBtn", function (event) {

    var currentParentId = event.target.value;
    var commenter_id_aka_user_id = event.target.getAttribute("data-commenter_id_aka_user_id");
    var comment_post_id = event.target.getAttribute("data-comment_post_id");

    makeDynamicReplyFormVisible(currentParentId, comment_post_id, commenter_id_aka_user_id );
});

function makeDynamicReplyFormVisible(currentParentIdObj, comment_post_idObj, commenter_id_aka_user_idObj) {
  //alert(currentParentIdObj + "from inside makeDynamicReplyFormVisible");

  console.log("current parent Id " + currentParentIdObj);
  console.log("comment post id " + comment_post_idObj);
  console.log("user id " + commenter_id_aka_user_idObj);

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
          commenter_id_aka_user_id :commenter_id_aka_user_idObj,
      },
      success: function (response) {
          //console.log(response);
        
          $(commentBoxTag).append(response);
          $(replyBtnTag).prop("disabled", "true");

      },
    });
}

function cancelReplyForm(replyForm) {

    var replyFormContainer_id = "#replyFormContainer_id"+replyForm.value; //--remember the # in future

    $(replyFormContainer_id).css("display", "none");

}
