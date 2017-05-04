$(document).ready(function() {

  $("#inputUsername").bind("keydown", function(e) {
    if ((e.which == 13) && (!$("#inputPassword").val())) { //Enter key is pressed and password is empty
      e.preventDefault(); //Skip default behavior of the enter key
      $("#inputPassword").focus();
    }
  });

  $("#signin-form").validate({
    submitHandler: function(form) {
      $('input[type="submit"]').attr('disabled','disabled');
      $("#ajax_response").html("<img src=\"images/wait.gif\">");

      var inputUsername = $("#inputUsername").val();
      var inputPassword = $.md5($("#inputPassword").val());
      
      $.ajax({ type: "POST",
        url: "ajax/dologin.php",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        data: {
          inputUsername : inputUsername,
          inputPassword : inputPassword
        },
        success: function(data) {
          $("#ajax_response").html("");
          if (data.substring(0, 8) == "login ok") {
            $("#signin-form").hide('Slow');
            $("#ajax_response").removeClass().addClass("alert alert-success");
            $("#ajax_response").html("Επιτυχής είσοδος. Παρακαλώ περιμένετε.");
            window.location.replace("viewusers.php");
            return true;
          } else {
            $("#ajax_response").removeClass().addClass("alert alert-danger");
            $("#ajax_response").html("Αποτυχια εισόδου.");
            $("#ajax_response").delay(15000).fadeOut('slow');
            $('input[type="submit"]').removeAttr('disabled');
            return false;
          }
        }
      }); //$.ajax({ type: "POST"

    } //submitHandler: function(form)

  }); //$("#form-signin").validate(
}); //$(document).ready
