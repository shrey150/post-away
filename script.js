$(document).ready(function () { 
    //load our Firebase
    var myDataRef = new Firebase('https://post-away.firebaseio.com/');
    
    //set name
    var name = $.cookie("name");
    if (name) {
        $("#nameInput").val(name);
        $('#rememberMe').attr('checked','checked');
    }

    //submit message to Firebase and set cookie for name
    $('#submitMessage').click(function () {
        var name = $('#nameInput').val();
        var text = $('#messageInput').val();
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        if($("#rememberMe").is(":checked")) {
            $.cookie("name",name,{expires:date});
        }
        else {
            $.removeCookie("name");
            $("#nameInput").val("")
        }
        myDataRef.push({name: name, text: text});
        $('#messageInput').val('');
    });
    
      //retrieve messages from Firebase
      myDataRef.on('child_added', function(snapshot) {
        var message = snapshot.val();
        displayChatMessage(message.name, message.text);
      });
      
      function displayChatMessage(name, text) {
        $('<div/>').text(text).prepend($('<em/>').text(name+" posted: \"")).appendTo($('#messagesDiv')).append("\"");
        $('#messagesDiv')[0].scrollTop = $('#messagesDiv')[0].scrollHeight;
      }
      
      function popUp(url) {
        var popupWindow = window.open(
        url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
      }

});
