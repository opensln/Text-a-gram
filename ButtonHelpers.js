//listening for buttons that pass in the value of clicked button using event.target.value

//----------------------------------------------------------Show Dynamic Reply Form
$("body").on("click", ".dynamicReplyBtn", function (event) {
    event.preventDefault();  
    var replyBtnId = event.target.value;
    
    $("#userBtnBar" + replyBtnId).css("display", "none");
    $("#replyFormContainer_id" + replyBtnId).css("display", "block");
    $("#replyBtn" + replyBtnId).prop("disabled", "true");

    var comment_post_id = $("#comment_post_id" + replyBtnId).val();
});

//----------------------------------------------------------------Cancel Dynamic Reply Form
$("body").on("click", ".cancelDynamicReplyBtn", function (event) {
  event.preventDefault();

  var replyBtnId = event.target.value;
  
  $("#userBtnBar" + replyBtnId).css("display", "block");
  $("#replyFormContainer_id" + replyBtnId).css("display", "none");
  $("#replyBtn" + replyBtnId).removeAttr("disabled");
 
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
