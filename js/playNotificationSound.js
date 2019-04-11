
function playNotificationSound(sound) {
    console.log('----------- playSound event -----------');

        if (sound) {
            console.log('----------- have sound -----------' + sound);
            if (iOS)
            {
              console.log('iOS');
                    if(typeof Media !== "undefined") {
                                    console.log('+++Play Sound PLATFORM = iOS ' );
                                    var snd = new Media('sounds/'+sound, mediaSuccess);
                                    snd.play();
                                    function mediaSuccess() {
                                        // sessionStorage.setItem('soundIsPlaying', '2');
                                        console.log('+++FINISH Play Sound PLATFORM = iOS' );
                                    }
                    }
            }
            else
            if (Android)
            {
              console.log('Android');
                    if(typeof Media !== "undefined") {
                                    console.log('+++Play Sound PLATFORM = android' );
                                    var snd = new Media('/android_asset/www/sounds/'+sound, mediaSuccess);
                                    snd.play();
                                    function mediaSuccess() {
                                        // sessionStorage.setItem('soundIsPlaying', '2');
                                        console.log('+++FINISH Play Sound PLATFORM =  android' );
                                    }
                    }
            }
            else
            {
              console.log('Media');

              var sound_click = new Howl({
                  urls: ['sounds/'+sound],
                  volume: 50,
                  onend: function() {
                      // sessionStorage.setItem('soundIsPlaying', '2');
                  }
              });
              sound_click.play();

                // if(typeof Media !== "undefined") {
                //                console.log('+++Play Sound PLATFORM = NOT  BLACKBERRY10 || iOS || android' );
                //                 var sound_click = new Howl({
                //                     urls: ['sounds/'+sound],
                //                     volume: 50,
                //                     onend: function() {
                //                         // sessionStorage.setItem('soundIsPlaying', '2');
                //                     }
                //                 });
                //                 sound_click.play();
                //             }
              }
        }
        else
        {
            console.log('----------- have saved sound 2-----------')
            if (iOS)
            {
                if(typeof Media !== "undefined") {
                                var snd = new Media('sounds/'+localStorage.getItem('playNotificationSound'), mediaSuccess);
                                snd.play();
                                function mediaSuccess() {
                                    // sessionStorage.setItem('soundIsPlaying', '2');
                                }
                }
            }
            else
            if (Android)
            {
                    if(typeof Media !== "undefined") {
                                    console.log('+++Play Sound PLATFORM = android' );
                                    var snd = new Media('/android_asset/www/sounds/'+localStorage.getItem('playNotificationSound'), mediaSuccess);
                                    snd.play();
                                    function mediaSuccess() {
                                        // sessionStorage.setItem('soundIsPlaying', '2');
                                        console.log('+++FINISH Play Sound PLATFORM =  android' );
                                    }
                    }
            }
            else
            {
                if(typeof Media !== "undefined") {
                                var sound_click = new Howl({
                                    urls: ['sounds/'+localStorage.getItem('sound')],
                                    volume: localStorage.getItem('volume'),
                                    onend: function() {
                                        // sessionStorage.setItem('soundIsPlaying', '2');
                                    }
                                });
                                sound_click.play();
                          }
              }
        }
    // }

    // else

    // {

    //     console.log('----------- SOUND BUSY -----------');
    // }
}

// $$('input[name="sound"]').on('change', function() {
//     if (this.checked) {
//         //console.log('we have sound');
//         console.log(this.value);
//         var playsound = this.value;
//         localStorage.setItem('sound', playsound);
//         localStorage.setItem('playNotificationSound', playsound);
//         console.log('------------ SYNC START playNotificationSound = ' + playsound);
//         //console.log('SOUND = ' +playsound);
//
//         if (device.platform === 'iOS' || device.platform === 'andoid')
//         {
//             console.log('+++Play Sound PLATFORM =  iOS || android' );
//             if(typeof Media !== "undefined") {
//             var snd = new Media('sounds/'+playsound);
//             snd.play();
//             }
//         }
//         else
//         {
//             if(typeof Media !== "undefined") {
//
//             var sound_click = new Howl({
//                 urls: ['sounds/'+playsound],
//                 volume: 50
//               });
//             sound_click.play();
//             }
//         }
//     }
// });
