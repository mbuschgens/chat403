document.addEventListener('deviceready', function(){
  tries = 100;

  var interval = setInterval(function(){
    if(--tries < 0){
      clearInterval(interval);
      document.getElementById('token').innerHTML = 'Firebase Token could not be acquired!';
      console.log('Firebase Token could not be acquired!');
    }
    FCMPlugin.getToken(function(token){
      if(token !== null && token !== ''){
        document.getElementById('token').innerHTML = 'Firebase Token: '+token;
        document.getElementById('tokenFound').innerHTML = token;
        clearInterval(interval);
        console.log('Firebase Token Upload to server');
        console.log(token);

        localStorage.setItem('tokenId',token);
        app.request.promise.post('https://app.phone403.com/php/update_token.php', { from_user_id:localStorage.getItem("from_user_id"), tokenId:token})
          .then(function (result) {
            console.log('Token update = ' + result);
        });

        console.log('Token send');

      }
    }, function(e){
      document.getElementById('token').innerHTML = JSON.stringify(e);
    });
  }, 100);

  FCMPlugin.onNotification(function(data){

    console.log('notification');
    console.log(JSON.stringify(data));

    if(data.setBadge){
      console.log('data.setBadge');
      cordova.plugins.notification.badge.get(function (badge) {
        cordova.plugins.notification.badge.increase(1, function (badge) {
            // badge is now 11 (10 + 1)
            console.log('setBadge = set : '+badge);
        });
      });



    }

    if(data.wasTapped){
      //Notification was received on device tray and tapped by the user.
      alert(JSON.stringify(data));



    }else{
      //Notification was received in foreground. Maybe the user needs to be notified.
      //alert(JSON.stringify(data));

    }
  });
}, false);
