$(document).ready(function () { 
    //load our Firebase
    var myDataRef = new Firebase('https://post-away.firebaseio.com/');
    
    //submit message to Firebase
    $('#submitMessage').click(function () {
        var name = $('#nameInput').val();
        var text = $('#messageInput').val();
        myDataRef.push({name: name, text: text});
        $('#messageInput').val('');
        $("#nameInput").val("");
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
