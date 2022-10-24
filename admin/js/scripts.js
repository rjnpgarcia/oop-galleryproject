$(document).ready(function () {
  // Edit Photo Side Bar Toggle
  $(".info-box-header").click(function () {
    $(".inside").slideToggle("fast");
    $("#toggle")
      .toggleClass("glyphicon-menu-down")
      .toggleClass("glyphicon-menu-up");
  });

  // for Summernote
  $("#summernote").summernote({
    height: 300,
  });
});
