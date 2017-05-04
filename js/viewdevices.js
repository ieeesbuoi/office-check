$( function() {
  var dialog, form;

  function addDevice() {
    valid = false;
    //empty string evaluates to false 
    valid = $("#mac").val();

    if ( valid ) {
      var mac = $( "#mac" ).val();
      var user_id = $( "#user_id" ).text();

      $("add-device-button").prop('disabled', true);
      $.ajax({ type: "POST",
        url: "ajax/doAddDevice.php",
        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
        data: {
          mac : mac,
          user_id : user_id
        },
        success: function(data) {
          $("#ajax_response").html("");
          if (data.substring(0, 13) == "kataxorisi ok") {
            $("#add-device-form").hide();
            $("#ajax_response").removeClass().addClass("alert alert-success");
            $("#ajax_response").html("Επιτυχής καταχώρηση. Παρακαλώ περιμένετε." + data);
            //refresh table
            $("#devices-table tbody").append("<tr><th scope=\"row\">-</th><td>" + mac + "</td><td>" + data.substring(13) + "</td><td>-</td></tr>");
            dialog.dialog( "close" );
            //reset dialog
            $("#ajax_response").html("");
            $("#ajax_response").hide();
            $("add-device-button").removeAttr('disabled');
            $("#add-device-form").show(1000);
            return true;
          } else {
            $("#ajax_response").removeClass().addClass("alert alert-danger");
            $("#ajax_response").html("Αποτυχια καταχώρησης.<br><strong>" + data + "</strong>");
            $("#ajax_response").show();
            $("#ajax_response").delay(10000).fadeOut('slow');
            $("add-device-button").removeAttr('disabled');
            return false;
          }
        }
      }); //$.ajax({ type: "POST"

    } else {
      $("#ajax_response").removeClass().addClass("alert alert-danger");
      $("#ajax_response").html("Πρέπει να συμπληρώσεις το πεδίο.");
      $("#ajax_response").show();
      $("#ajax_response").delay(3000).fadeOut('slow');
    }
    return valid;
  }

  dialog = $( "#dialog-form" ).dialog({
    autoOpen: false,
    height: 200,
    width: 450,
    modal: true,
    buttons: {
      "Δημιουργία": addDevice,
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

  $( "#btnAddNewDevice" ).button().on( "click", function() {
    dialog.dialog( "open" );
  });
} );

$(function() {
  $('.delDevice').click(function(){
      var id = $(this).parent().parent().parent().children('th:first').text();
      var mac = $(this).parent().parent().parent().children('td:first').text();
      var currentDiv = $(this).parent();
      currentDiv.hide();
      currentDiv.next().show();
      currentDiv.next().html("Να την διαγράψω;<br>" +
                            "<button type=\"button\" id=\"btnDelDeviceOK" + id + "\" class=\"btn btn-success btn-sm\">OK</button>&nbsp;" +
                            "<button type=\"button\" id=\"btnDelDeviceCancel" + id + "\" class=\"btn btn-secondary btn-sm\">Άκυρο</button>");
      $("#btnDelDeviceCancel" + id).click(function(){
        currentDiv.show();
        currentDiv.next().hide();
      });

      $("#btnDelDeviceOK" + id).click(function(){
        $("#btnDelDeviceOK" + id).prop('disabled', true);
        $("#btnDelDeviceCancel" + id).prop('disabled', true);
        $.ajax({ type: "POST",
          url: "ajax/doDelDevice.php",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          data: {
            mac : mac
          },
          success: function(data) {
            if (data.substring(0, 9) == "delete ok") {
              currentDiv.parent().parent().remove();
              return true;
            } else {
              return false;
            }
          }
        }); //$.ajax({ type: "POST"
        $("#btnDelDeviceOK" + mac).prop('disabled', false);
        $("#btnDelDeviceCancel" + mac).prop('disabled', false);
        currentDiv.show();
        currentDiv.next().hide();
      });

    });
});

