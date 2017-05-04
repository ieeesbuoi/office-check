$( function() {
  var dialog, form;

  function addUser() {
    valid = false;
    //empty string evaluates to false 
    valid = $("#last-name").val() &&
            $("#first-name").val() &&
            $("#email").val();

    if ($("input:radio[name='admin']:checked").val() == "adminYes") {
      valid = valid && $("#username").val() &&
            $("#password").val();
    }

    if ( valid ) {
      var lastname = $( "#last-name" ).val();
      var firstname = $( "#first-name" ).val();
      var email = $( "#email" ).val();
      var slackid = $( "#slackid" ).val();
      var username = $( "#username" ).val();
      var password = $.md5($( "#password" ).val());
      
      if($("input:radio[name='admin']:checked").val() == "adminYes") {
        var admin = 1;
      } else {
        var admin = 0;
      }

      $("add-user-button").prop('disabled', true);
      $.ajax({ type: "POST",
        url: "ajax/doAddUser.php",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        data: {
          lastname : lastname,
          firstname : firstname,
          email : email,
          slackid : slackid,
          username : username,
          password : password,
          admin : admin
        },
        success: function(data) {
          $("#ajax_response").html("");
          if (data.substring(0, 13) == "kataxorisi ok") {
            $("#add-user-form").hide();
            $("#ajax_response").removeClass().addClass("alert alert-success");
            $("#ajax_response").html("Επιτυχής καταχώρηση. Παρακαλώ περιμένετε." + data);
            //refresh table
            $("#users-table tbody").append("<tr><th scope=\"row\">" + data.substring(13, 14) + "</th><td>" + lastname + "</td><td>" +
                                         firstname + "</td><td>" + slackid + "</td><td>" + email + "</td>" +
                                         "<td>" + username + "</td>" + 
                                         "<td><div><img src=\"images/password.png\" class=\"editPassword\">&nbsp;<span>&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span></div><div></div></td>" +
                                         "<td><div><img src=\"images/edit.png\" class=\"editAdmin\">&nbsp;<span>" + (admin ? "ΝΑΙ" : "ΟΧΙ") + "</span></div><div></div></td>" +
                                         "</tr>");
            dialog.dialog( "close" );
            //reset dialog
            $("#ajax_response").html("");
            $("#ajax_response").hide();
            $("add-user-button").removeAttr('disabled');
            $("#add-user-form").show(1000);
            return true;
          } else {
            $("#ajax_response").removeClass().addClass("alert alert-danger");
            $("#ajax_response").html("Αποτυχια καταχώρησης.<br><strong>" + data + "</strong>");
            $("#ajax_response").show();
            $("#ajax_response").delay(10000).fadeOut('slow');
            $("add-user-button").removeAttr('disabled');
            return false;
          }
        }
      }); //$.ajax({ type: "POST"

    } else {
      $("#ajax_response").removeClass().addClass("alert alert-danger");
      $("#ajax_response").html("Πρέπει να συμπληρώσεις τα πεδία.");
      $("#ajax_response").show();
      $("#ajax_response").delay(3000).fadeOut('slow');
    }
    return valid;
  }

  dialog = $( "#dialog-form" ).dialog({
    autoOpen: false,
    height: 400,
    width: 450,
    modal: true,
    buttons: {
      "Δημιουργία": addUser,
      "Άκυρο": function() {
        dialog.dialog( "close" );
        $("#ajax_response").dequeue();
        $("#ajax_response").hide();
      }
    },
    close: function() {
      form[ 0 ].reset();
    }
  });

  form = dialog.find( "form" ).on( "submit", function( event ) {
    event.preventDefault();
    addUser();
  });

  $( "#btnAddNewUser" ).button().on( "click", function() {
    dialog.dialog( "open" );
  });
} );

$(function() {
  $('.editAdmin').click(function(){
      var userid = $(this).parent().parent().parent().children('th:first').text();
      var currentDiv = $(this).parent();
      currentDiv.hide();
      currentDiv.next().show();
      currentDiv.next().html("Να είναι διαχειριστής;<br>" +
                            "<button type=\"button\" id=\"btnEditAdminYes" + userid + "\" class=\"btn btn-success btn-sm\">Ναι</button>&nbsp;" +
                            "<button type=\"button\" id=\"btnEditAdminNo" + userid + "\" class=\"btn btn-danger btn-sm\">Όχι</button>&nbsp;" +
                            "<button type=\"button\" id=\"btnEditAdminCancel" + userid + "\" class=\"btn btn-secondary btn-sm\">Άκυρο</button>");
      $("#btnEditAdminCancel" + userid).click(function(){
        currentDiv.show();
        currentDiv.next().hide();
      });

      $("#btnEditAdminYes" + userid).click(function(){
        $("#btnEditAdminNo" + userid).prop('disabled', true);
        $("#btnEditAdminYes" + userid).prop('disabled', true);
        $("#btnEditAdminCancel" + userid).prop('disabled', true);
        $.ajax({ type: "POST",
          url: "ajax/doEditUser.php",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          data: {
            userid : userid,
            admin : 1
          },
          success: function(data) {
            if (data.substring(0, 9) == "change ok") {
              currentDiv.children("span").html("ΝΑΙ");
              return true;
            } else {
              return false;
            }
          }
        }); //$.ajax({ type: "POST"
        $("#btnEditAdminNo" + userid).prop('disabled', false);
        $("#btnEditAdminYes" + userid).prop('disabled', false);
        $("#btnEditAdminCancel" + userid).prop('disabled', false);
        currentDiv.show();
        currentDiv.next().hide();
      });

      $("#btnEditAdminNo" + userid).click(function(){
        $("#btnEditAdminNo" + userid).prop('disabled', true);
        $("#btnEditAdminYes" + userid).prop('disabled', true);
        $("#btnEditAdminCancel" + userid).prop('disabled', true);
        $.ajax({ type: "POST",
          url: "ajax/doEditUser.php",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          data: {
            userid : userid,
            admin : 0
          },
          success: function(data) {
            if (data.substring(0, 9) == "change ok") {
              currentDiv.children("span").html("ΟΧΙ");
              return true;
            } else {
              return false;
            }
          }
        }); //$.ajax({ type: "POST"
        $("#btnEditAdminNo" + userid).prop('disabled', false);
        $("#btnEditAdminYes" + userid).prop('disabled', false);
        $("#btnEditAdminCancel" + userid).prop('disabled', false);
        currentDiv.show();
        currentDiv.next().hide();
      });

    });
});

$(function() {
  $('.editPassword').click(function(){
      var userid = $(this).parent().parent().parent().children('th:first').text();
      var currentDiv = $(this).parent();
      currentDiv.hide();
      currentDiv.next().show();
      currentDiv.next().html( '<input type="text" name="password' + userid + '" id="password' + userid + '" class="text ui-widget-content ui-corner-all"><br>' +
                            "<button type=\"button\" id=\"btnEditPassOk" + userid + "\" class=\"btn btn-success btn-sm\">OK</button>&nbsp;" +
                            "<button type=\"button\" id=\"btnEditPassCancel" + userid + "\" class=\"btn btn-secondary btn-sm\">Άκυρο</button>");
      $("#btnEditPassCancel" + userid).click(function(){
        currentDiv.show();
        currentDiv.next().hide();
      });

      $("#btnEditPassOk" + userid).click(function(){
        if ($( "#password" + userid ).val()) { //if not empty   (empty fields evaluates to false)
          $("#btnEditPassOk" + userid).prop('disabled', true);
          $("#btnEditPassCancel" + userid).prop('disabled', true);
          var password = $.md5($( "#password" + userid ).val());
          $.ajax({ type: "POST",
            url: "ajax/doEditUser.php",
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            data: {
              userid : userid,
              password : password
            },
            success: function(data) {
              if (data.substring(0, 9) == "change ok") {
                currentDiv.children("span").html("Ο κωδικός άλλαξε.");
                return true;
              } else {
                currentDiv.children("span").html("Ο κωδικός ΔΕΝ άλλαξε.");
                return false;
              }
            }
          }); //$.ajax({ type: "POST"
          $("#btnEditPassOk" + userid).prop('disabled', false);
          $("#btnEditPassCancel" + userid).prop('disabled', false);
          currentDiv.next().hide();
          currentDiv.show();
        }
      });

    });
});
