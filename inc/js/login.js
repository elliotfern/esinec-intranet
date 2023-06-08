// AJAX PROCESS > PHP - LOGIN
$(function () {
  $("#btnLogin").click(function () {
    // check values
    $("#createBookMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();

    $.ajax({
      type: "POST",
      url: "./login-process.php",
      data: {
        username: $("#username").val(),
        password: $("#password").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#loginMessageOk").show();
          $("#loginMessageErr").hide();
          // redirect page
          setTimeout(function () {
            window.location = "/admin";
          }, 1300);
        } else {
          // show error message
          $("#loginMessageOk").hide();
          $("#loginMessageErr").show();
        }
      },
    });
  });
});
