//listening for buttons that pass in the value of clicked button using event.target.value

//----------------------------------------------------------Show Dynamic Reply Form
$("body").on("click", ".dynamicReplyBtn", function (event) {
    event.preventDefault();  
    var replyBtnId = event.target.value;
    
    $("#userBtnBar" + replyBtnId).css("display", "none");
    $("#replyFormContainer_id" + replyBtnId).css("display", "block");
    $("#replyBtn" + replyBtnId).prop("disabled", "true");

    var comment_post_id = $("#comment_post_id" + replyBtnId).val();
    //var comment_post_id = event.target.getAttribute("data-comment_post_id"); //alternative to jQuery Tag

    // $.ajax({
    //   method: "POST",
    //   url: "displaysinglepage.php",
    //   dataType: "text",
    //   data: {
    //       showReplyForm: 1,
    //       comment_parent_id :replyBtnId,
    //       comment_post_id: comment_post_id,
    //   },
    //   success: function (response) {
    //       //console.log(response);

    //       $("#userBtnBar" + replyBtnId).css("display", "none");
    //       $("#replyFormContainer_id" + replyBtnId).css("display", "block");
    //       $("#replyBtn" + replyBtnId).prop("disabled", "true");

    //       $("#commentBox_id" + replyBtnId).append(response);
    //   },
    // });

});

//----------------------------------------------------------------Cancel Dynamic Reply Form
$("body").on("click", ".cancelDynamicReplyBtn", function (event) {
  event.preventDefault();

  var replyBtnId = event.target.value;
  
  $("#replyBtn" + replyBtnId).removeAttr("disabled");
  $("#replyFormContainer_id" + replyBtnId).remove();
  $("#userBtnBar" + replyBtnId).ss("display", "block");
});

//----------------------------------------------------------------Show Update Comment TextArea
$("body").on("click", ".editBtn", function (event) {
  event.preventDefault();
  var editBtnId = event.target.value;

  $("#comment_content" + editBtnId).css("display", "none");
  $("#editTextareaHolder" + editBtnId).css("display", "block");
  $("#editForm" + editBtnId).css("display", "none");
  $("#replyBtn" + editBtnId).css("display", "none");
  
});

//----------------------------------------------Cancel Update Form
$("body").on("click", ".cancelUpdateBtn", function (event) {
  event.preventDefault();
  var editBtnId = event.target.value;

  $("#comment_content" + editBtnId).css("display", "block");
  $("#editTextareaHolder" + editBtnId).css("display", "none");
  $("#editForm" + editBtnId).css("display", "block");
  $("#replyBtn" + editBtnId).css("display", "block");
});
