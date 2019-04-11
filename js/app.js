// Dom7
var $ = Dom7;

// Theme
var theme = 'auto';
var sound = 'plop.mp3';
var iOS = false;;
var Android = false;

if (document.location.search.indexOf('theme=') >= 0) {
  theme = document.location.search.split('theme=')[1].split('&')[0];
}
var sound = 'plop.mp3';
// Init App

Framework7.use(debugPlugin);

var app = new Framework7({
  id: 'com.phone403.app',
  root: '#app',
  theme: theme,
  swipeout: {
    noFollow: true,
    removeElements: false
  },
  //enable debugger
  debugger: false,
  on: {
    init: function () {
      // console.log('App initialized')
    },
    pageInit: function (page) {
      console.log('Page initialized')
      // console.log(page.router.currentRoute.query);
      console.log(page.name);

      localStorage.to_user_id = page.router.currentRoute.query.to_user_id;
      localStorage.header = page.router.currentRoute.query.header;
      localStorage.to_user_name = page.router.currentRoute.query.to_user_name;
      localStorage.avatar = page.router.currentRoute.query.avatar;
    },
  },

  routes: routes,
});


var view = app.views.create('.view-main');

var listDataChats = [];
var listDataContacts = [];

var sortByProperty = function (property) {
  //console.log('sortByProperty');
    return function (x, y) {
        return ((x[property] === y[property]) ? 0 : ((x[property] > y[property]) ? 1 : -1));
    };
};

listDataContacts.sort(sortByProperty('to_user_name'));

listDataChats.sort(sortByProperty('last_activity'));

function createItemDiv() {
  var d = document.createElement('div');
  d.className = 'list-group moving-div';
  var u = document.createElement('ul');
  d.appendChild(u);
  return { d, u };
}

function onVirtualBeforeInsert(vlist, fragment) {
    var self = this;
    var list = Dom7(vlist.ul);

    var virtualItems = [];
    var first = true;
    var top;
    while (fragment.hasChildNodes()) {
      var c = fragment.removeChild(fragment.firstChild);
      if (first) {
        first = false;
        top = c.style.top;
      }
      Dom7(c).css('top', '');
      virtualItems.push(c);
    }

    var previousName = null;
    var addedHeaders = [];
    var e;

    virtualItems.forEach(item => {
      var headerName = Dom7(item).attr('data-header-name');
      if (previousName !== headerName) {
        previousName = headerName;
        e = createItemDiv();
        fragment.appendChild(e.d);
        Dom7(e.d).css('top', top);
        var h = document.createElement('li');
        h.className = 'list-group-title';
        h.appendChild(document.createTextNode(headerName));
        e.u.appendChild(h);
        addedHeaders.push(e);
      }

      e.u.appendChild(item);

    });

    vlist.setListSize();
    list.css({ height: `${list.height() + ((app.theme == 'ios' ? 31 : 48) * addedHeaders.length)}px` });
  }

$(document).on('page:afterin', '.page[data-name="index"]', function (e) {
  // Do something here when page with data-name="about" attribute loaded and initialized
  console.log('page:afterin');

  //   virtualListChats.deleteAllItems();
  //
  //   function dynamicSort(property) {
  //       var sortOrder = 1;
  //       if(property[0] === "-") {
  //           sortOrder = -1;
  //           property = property.substr(1);
  //       }
  //       return function (a,b) {
  //           var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
  //           return result * sortOrder;
  //       }
  // }

  var data = JSON.parse(localStorage.listDataChats);

  // console.log('data');
  // console.log(data);

  var sortBy = (function () {
    var toString = Object.prototype.toString,
        // default parser function
        parse = function (x) { return x; },
        // gets the item to be sorted
        getItem = function (x) {
          var isObject = x != null && typeof x === "object";
          var isProp = isObject && this.prop in x;
          return this.parser(isProp ? x[this.prop] : x);
        };
    return function sortby (array, cfg) {
      if (!(array instanceof Array && array.length)) return [];
      if (toString.call(cfg) !== "[object Object]") cfg = {};
      if (typeof cfg.parser !== "function") cfg.parser = parse;
      cfg.desc = !!cfg.desc ? -1 : 1;
      return array.sort(function (a, b) {
        a = getItem.call(cfg, a);
        b = getItem.call(cfg, b);
        return cfg.desc * (a < b ? -1 : +(a > b));
      });
    };

}());

  sortBy(data, {
      prop: "last_activity",
      desc: true,
      parser: function (item) {
          //ignore case sensitive
          return item.toUpperCase();
      }
});

  // console.log('data');
  // console.log(data);

  localStorage.listDataChats = JSON.stringify(data);

  virtualListChats.deleteAllItems();
  virtualListChats.prependItems(JSON.parse(localStorage.listDataChats));

})


    var virtualListContacts = app.virtualList.create({
      el: '.virtual-list-contacts',
      items: listDataContacts,

      searchAll: function (query, items) {
          var found = [];
          for (var i = 0; i < items.length; i++) {
            if (items[i].to_user_id.toLowerCase().indexOf(query.toLowerCase()) >= 0 || query.trim() === '') found.push(i);
            if (items[i].to_user_name.toLowerCase().indexOf(query.toLowerCase()) >= 0 || query.trim() === '') found.push(i);
          }
          return found; //return array with mathced indexes
        },

    // itemTemplate:
    renderItem:function(item){
      var obj=app.utils.extend(item,{index:this.items.indexOf(item)});
      obj.initials = obj.to_user_name.charAt(0);
      var tmpl=
      '<li data-to_user_id="{{to_user_id}}" class="list-data-contacts swipeout" data-header-name="{{header}}">' +

          '<div class="swipeout-content">'+

            '<a href="/messages/?to_user_id={{to_user_id}}&header={{header}}&to_user_name={{to_user_name}}&avatar={{avatar}}" data-index="{{@index}}" class="item-link item-content" >' +

              '<div class="item-avatar">' +
                // '<div class="message-avatar message-avatar{{to_user_id}}" style="background-image:url({{avatar}});"></div>' +
                // '<div class="message-avatar{{to_user_id}}“>' +

                // '</div>' +
                // '<div class="circle">' +
                //   '<span class="initials">{{to_user_name}}</span>' +
                // '</div>' +

                '<div id="container" class="container{{to_user_id}}">' +
                  '<div id="name">' +
                    '{{initials}}' +
                   '</div>' +
                '</div>' +


              '</div>' +



              '<div class="item-inner">' +
                '<div class="item-title">' +
                  '<div class="item-header">{{to_user_name}} : {{to_user_id}}</div>' +
                '</div>' +
                '<div class="item-footer last-message{{to_user_id}}">{{last_message}}</div>' +
                '<div class="item-footer typing{{to_user_id}}" style="display:none;" >Typing...</div>' +
              '</div>' +

              '<div class="item-after-new item-after{{to_user_id}}"> ' +

                '<div class="item-after-time item-after-time{{to_user_id}}"> ' +

                  '<span class="time">{{editTimeStamp}}</span> ' +

                '</div>' +

                '<div class="item-after-badge item-after-badge{{to_user_id}}"> ' +

                  '{{waitingmessagesInsert}}' +

                '</div>' +

              '</div>' +

            '</a>' +

          '</div>' +

          '<div class="swipeout-actions-right">' +
            '<a href="#" class="swipeout-delete swipeout-overswipe">Delete</a>' +
          '</div>' +

        '</li>';
          return Template7.compile(tmpl)(obj);
        },

      height: app.theme === 'ios' ? 63 : (app.theme === 'md' ? 73 : 46),

      on: {
        itemsBeforeInsert: onVirtualBeforeInsert
      }
    });

    var virtualListChats = app.virtualList.create({


      // List Element
      el: '.virtual-list-chats',
      // Pass array with items
      items: listDataChats,
      // Custom search function for searchbar
      searchAll: function (query, items) {
        var found = [];
        for (var i = 0; i < items.length; i++) {
          if (items[i].to_user_id.toLowerCase().indexOf(query.toLowerCase()) >= 0 || query.trim() === '') found.push(i);
          if (items[i].to_user_name.toLowerCase().indexOf(query.toLowerCase()) >= 0 || query.trim() === '') found.push(i);
        }
        return found; //return array with mathced indexes
      },
      renderItem:function(item){

      var object=app.utils.extend(item,{index:this.items.indexOf(item)});

      object.editTimeStamp = moment(object.last_message_time).calendar(null, {
          sameDay: 'HH:mm',
          lastDay: '[Yesterday]',
          lastWeek: '[Last] dddd',
          sameElse: 'DD/MM/YYYY'
      });

      if(object.waitingmessages > 0) {
      // console.log('object.waitingmessages > 0');
      // console.log('object.waitingmessages : '+object.waitingmessages);

      var waitingmessagesvalue = JSON.stringify(object.waitingmessages);
      //console.log('waitingmessagesvalue : ' + waitingmessagesvalue);


        if(localStorage.getItem('bagde'+object.to_user_id)){
                //console.log('localStorage : ' + localStorage.getItem('bagde'+object.to_user_id));

                waitingmessagesvalue = parseInt(localStorage.getItem('bagde'+object.to_user_id)) + parseInt(object.waitingmessages);
                //console.log('waitingmessagesvalue : ' + waitingmessagesvalue);

                localStorage.setItem('bagde'+object.to_user_id, waitingmessagesvalue);

                object.waitingmessagesInsert = '<span id="badge" class="badge">' + waitingmessagesvalue + '</span>';
                //console.log('object.waitingmessagesInsert : ' + object.waitingmessagesInsert);

        }
        else
        {
          //console.log('NO localStorage : ');

          localStorage.setItem('bagde'+object.to_user_id, waitingmessagesvalue);

          object.waitingmessagesInsert = '<span id="badge" class="badge">' + waitingmessagesvalue + '</span>';
        //  console.log('object.waitingmessagesInsert : ' + object.waitingmessagesInsert );

        }





      }
      else {
        object.waitingmessagesInsert = '<span id="badge" class="badge-space"></span>';
      }
      object.initials = object.to_user_name.charAt(0);

      var tmpl=
      '<li id="swipeout-delete" data-to_user_id="{{to_user_id}}" class="list-data-chats swipeout">' +

        '<div class="swipeout-content">'+

            '<a href="/messages/?to_user_id={{to_user_id}}&header={{header}}&to_user_name={{to_user_name}}&avatar={{avatar}}" data-index="{{@index}}" class="item-link item-content">' +

              '<div class="item-avatar">' +
                // '<div class="message-avatar message-avatar{{to_user_id}}" style="background-image:url({{avatar}});"> </div>' +
                '<div id="container" class="container{{to_user_id}}">' +
                  '<div id="name">' +
                    '{{initials}}' +
                   '</div>' +
                '</div>' +

              '</div>' +

                '<div class="item-inner">' +
                  '<div class="item-title">' +
                          '<div class="item-header">{{to_user_name}}  : {{to_user_id}} </div>' +
                  '</div>' +
                          '<div class="item-footer last-message{{to_user_id}}">{{last_message}}</div>' +
                          '<div class="item-footer typing{{to_user_id}}" style="display:none;" >Typing...</div>' +
                '</div>' +


                '<div class="item-after-new item-after{{to_user_id}}"> ' +

                  '<div class="item-after-time item-after-time{{to_user_id}}"> ' +

                    '<span class="time">{{editTimeStamp}}</span> ' +

                  '</div>' +

                  '<div class="item-after-badge item-after-badge{{to_user_id}}"> ' +

                    '{{waitingmessagesInsert}}' +

                  '</div>' +

                '</div>' +

              '</a>' +

          '</div>' +

          '<div class="swipeout-actions-right">' +
            '<a href="#" class="swipeout-delete swipeout-overswipe">Delete</a>' +
          '</div>' +

        '</li>';

          return Template7.compile(tmpl)(object);
        },
      height: app.theme === 'ios' ? 63 : (app.theme === 'md' ? 73 : 46),
    });

    if(localStorage.listDataChats){
      //console.log('localStorage.listDataChats NOT empty');
      //console.log(JSON.parse(localStorage.listDataChats));





      virtualListChats.prependItems(JSON.parse(localStorage.listDataChats));
    }else{
      console.log('localStorage.listDataChats IS empty');


    }

    if(localStorage.listDataContacts){
      //console.log('localStorage.listDataContacts NOT empty');
      //console.log(JSON.parse(localStorage.listDataContacts));


      virtualListContacts.appendItems(JSON.parse(localStorage.listDataContacts));
    }else{
      console.log('localStorage.listDataContacts IS empty');
    }




//
//
// });
//




app.on('tabShow', function (el) {
  // console.log('tabShow:');
  // console.log(el.id);

  if(el.id === 'tab-chats'){
    $('.view-main .navbar .title').html('Recente Chats');
    // console.log('tab-chats');
    $(".searchbar-enable.chats").show();
    $(".searchbar-enable.contacts").hide();
    //document.getElementById("tabs").style.transform = "translate3d(0px, 0px, 0px)";
    document.getElementById("floatingButtonAddChat").style.display = "block";
    document.getElementById("floatingButtonAddContact").style.display = "none";
  }

  if(el.id === 'tab-contacts'){
    $('.view-main .navbar .title').html('Contacts');
    // console.log('tab-contacts');
    $(".searchbar-enable.contacts").show();
    $(".searchbar-enable.chats").hide();

    //document.getElementById("tabs").style.transform = "translate3d(-360px, 0px, 0px)";
    document.getElementById("floatingButtonAddChat").style.display = "none";
    document.getElementById("floatingButtonAddContact").style.display = "block";
  }

});

// if(!localStorage.myKey){
//   console.log('Make myKey');
//   var myKey = new DSA();
//   localStorage.myKey = JSON.stringify(myKey);
// }


// if(!localStorage.myKey){
//   console.log('Make myKey');
//   var myKey = new DSA();
//   console.log("myKey");
//   console.log(myKey);
//
//   var string = myKey.packPrivate(myKey);
//   console.log(string);
//   console.log("string");
//
//   localStorage.myKey = string;
//
//   console.log(localStorage.myKey);
// }

// var myKey2 = JSON.parse(DSA (string));
//
// console.log(myKey2);
// console.log("myKey2");




if(!localStorage.getItem("from_user_id")) {

  console.log('We NOT loged in!');
  // router.navigate({ name: 'main' });
  var ls = app.loginScreen.create({ el: '.login-screen' });
  ls.open(false);

}
else
{
    console.log('We loged in!');
    $('.navbar').removeClass('navbar-hidden');

};

$('#floatingButtonAddChat').on('click', function () {
console.log('floatingButtonAddChat');

});


$('#floatingButtonAddContact').on('click', function () {
console.log('floatingButtonAddContact');

});





$('#my-login-screen .login-button').on('click', function () {
  var from_user_id = $('#my-login-screen input[name="from_user_id"]:checked').val();
  var password = $('#my-login-screen input[name="password"]').val();

  // console.log('level');
  // console.log(level);
  console.log('from_user_id!!!');
  console.log(from_user_id);

  localStorage.from_user_id = from_user_id;
  app.preloader.show();
  console.log('button pressed // Login Screen');

  // app.request.promise.json('php/jsonUserCheck.php', { from_user_id: from_user_id, password:password })
  //   .then(function (data) {
  //     console.log('Load was performed');
  //     //console.log(data);
  //
  //     if(data)
  //     {
  //           if(data.active === '1' ){
  //
  //           var level = data.level;
  //           var recruiter = data.from_user_id + ' ' + data.sureName;
  //           console.log('level');
  //           console.log(level);
  //           console.log('recruiter');
  //           console.log(recruiter);
  //
  //           $('.level').html(level);
  //           $('.recruiter').html(recruiter);
  //
  //           localStorage.setItem("recruiter", recruiter);
  //
  //
  //           // totalRecords
  //           app.request.promise.json('php/jsonTotalRecords.php', { })
  //             .then(function (data) {
  //               console.log('jsonTotalRecords');
  //               console.log(data);
  //
  //               $('.totalRecords').html(data);
  //           });
  //
  //           app.preloader.hide();
  //
  //           app.loginScreen.close('#my-login-screen');
  //
  //           }
  //     }
  //     else {
  //           app.preloader.hide();
  //           app.dialog.alert('Sorry no user with this email or password. ');
  //     }
  //   })

          // bypass login check


          // $('.level').html(level);
          $('.from_user_id').html(from_user_id);

          localStorage.setItem("from_user_id", from_user_id);

          app.preloader.hide();

          app.loginScreen.close('#my-login-screen');



          var generateKeys = function () {

            console.log('generateKeys function');
            // var sKeySize = $('#key-size').attr('data-value');
            var sKeySize = 2048;

            var keySize = parseInt(sKeySize);
            var crypt = new JSEncrypt({default_key_size: keySize});

            crypt.getKey();
            var PrivateKey = crypt.getPrivateKey()
            console.log(PrivateKey);
            // localStorage.PrivateKey = JSON.stringify(PrivateKey);
            localStorage.PrivateKey = PrivateKey;

            var PublicKey = crypt.getPublicKey();
            console.log(PublicKey);
            //localStorage.PublicKey = JSON.stringify(PublicKey);
            localStorage.PublicKey = PublicKey;


            // uplaod PublicKey
            app.request.promise.post('https://app.phone403.com/php/update_publickey.php', { from_user_id:localStorage.getItem("from_user_id"), publickey:localStorage.PublicKey })
              .then(function (result) {
                console.log(result);
            });

          };

          // If they wish to generate new keys.
          // $('#generate').click(generateKeys);


              if(!localStorage.PublicKey || !localStorage.PrivateKey){
                      app.dialog.preloader('One moment, We creating keys...');
                      console.log('call generateKeys');
                      setTimeout(function(){
                        generateKeys();
                      },500);
              }

              if(!localStorage.listDataContacts){

                listDataContacts =[];
                console.log('listDataContacts');
                console.log(listDataContacts);


                var sortByProperty = function (property) {
                    return function (x, y) {
                        return ((x[property] === y[property]) ? 0 : ((x[property] > y[property]) ? 1 : -1));
                    };
                };

                console.log('We import default contacts...');

                listDataContacts.push(
                  {
                    "to_user_id":"AABBCCDD",
                    "header":"M",
                    "to_user_name":"Macbook Chrome",
                    "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                  },
                  {
                    "to_user_id":"99DD88FF",
                    "header":"I",
                    "to_user_name":"iMac chrome",
                    "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                  },
                    {
                      "to_user_id":"A8JE3NSR",
                      "header":"S",
                      "to_user_name":"Samsung",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"NSS7KK23",
                      "header":"I",
                      "to_user_name":"imac Safari",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"MSSS522B",
                      "header":"M",
                      "to_user_name":"Marcel",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"LAAW100K",
                      "header":"S",
                      "to_user_name":"Sveta",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"QPSY230S",
                      "header":"B",
                      "to_user_name":"Bas",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"KSYX28DA",
                      "header":"A",
                      "to_user_name":"Annemiek",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"DDU7Q9SD",
                      "header":"M",
                      "to_user_name":"Marie",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"39SD63NS",
                      "header":"T",
                      "to_user_name":"Tom",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"0DHE61HS",
                      "header":"M",
                      "to_user_name":"Mark",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    },
                    {
                      "to_user_id":"D89DH27D",
                      "header":"B",
                      "to_user_name":"Bob",
                      "avatar":"https://cdn.framework7.io/placeholder/people-100x100-7.jpg"
                    }

                  );


                listDataContacts.sort(sortByProperty('to_user_name'));

                localStorage.listDataContacts = JSON.stringify(listDataContacts);
                virtualListContacts.appendItems(JSON.parse(localStorage.listDataContacts));

                console.log('BULK NAMES IMPORTED');

                //$('.navbar').removeClass('navbar-hidden');

                setTimeout(function(){
                  app.dialog.close();
                   //$('.view').removeClass('navbar-hidden');
                },2000);

              } // end if(!localStorage.listDataContacts)]

              else
              {

                var ls = app.loginScreen.create({ el: '.login-screen' });

                ls.open(false);

                // $('.navbar').removeClass('navbar-hidden');

                setTimeout(function() {
                    ls.close();
                     //$('.view').removeClass('navbar-hidden');
                },10000)


              }



          if(!localStorage.getItem("login_details_id")) {

            console.log('No LS login_details_id ask release one.')

            console.log(localStorage.getItem("from_user_id"))
            app.request.promise.post('https://app.phone403.com/php/login.php', { from_user_id:localStorage.getItem("from_user_id")})
              .then(function (data) {
                console.log(data);
                localStorage.setItem('login_details_id',data);
            });
          }
          else
          {
          console.log('YES LS login_details_id skip.')
          }

});













// $(document).ready(function(){

	fetch_users();

	setInterval(function(){
		update_last_activity();
		fetch_users();
    fetch_chat_messages(); //have to import decrupt publickeys

    //fetch_chat_messages_history(); have to import decrupt publickeys


		// update_chat_history_data();
		// fetch_group_chat_history();

	}, 7000);


  function fetch_user(to_user_id)
  {
      //console.log('Fn fetch_user > ' + to_user_id);

      if(localStorage.getItem("from_user_id") !== to_user_id){
          app.request.promise.post('https://app.phone403.com/php/fetch_user.php', { from_user_id:localStorage.getItem("from_user_id"),to_user_id:to_user_id})
            .then(function (result) {

              if(result !== 'null') {

              var obj = JSON.parse(result)
              if(obj){

                // console.log('active:'+obj.active);
                // console.log('waitingmessages:'+obj.waitingmessages);
                // console.log('is_type:'+obj.is_type);
                // console.log('to_user_id:'+obj.to_user_id);
                // console.log('last_activity:'+obj.last_activity);
                // console.log('user_avatar:'+obj.user_avatar);



                if(obj.publickey) {
                  //console.log('publickey : '+ to_user_id + ' = '+obj.publickey);
                  localStorage.setItem('PublicKey-' + to_user_id, obj.publickey);
                }

                    if(obj.waitingmessages != 0){
                      //$('.item-after-badge'+obj.to_user_id).html('<span class="badge">' + obj.waitingmessages + '</span>');
                    }

                    if(obj.is_type === 'no'){
                      $('.last-message'+obj.to_user_id).show();
                      $('.typing'+obj.to_user_id).hide();
                    }
                    else
                    { // yes typing
                      //console.log('Yes Typing...');
                      $('.last-message'+obj.to_user_id).hide();
                      $('.typing'+obj.to_user_id).show();
                    }

                    var lastseen = moment(obj.last_activity).format("dddd, MMMM Do, HH:mm");

                    if(obj.active === '1'){
                      //console.log(obj.to_user_id + ' : is Online');
                      // $('.message-avatar'+obj.to_user_id).addClass('message-avatar-online');
                      $('.container'+obj.to_user_id).addClass('online');
                    }
                    else
                    {
                      // $('.message-avatar'+obj.to_user_id).removeClass('message-avatar-online');
                      $('.container'+obj.to_user_id).removeClass('online');
                    }



                  }
              }

          });
      }
  }

  function fetch_users()
  {
  		//console.log('Fn fetch_users');
      // console.log(virtualListChats.currentToIndex);
        if(localStorage.listDataContacts){
            var obj = JSON.parse(localStorage.listDataContacts);
            //console.log(obj);
            for (var key in obj) {
                var data = obj[key];
                //console.log(data);
                if (data.to_user_id != null) {
                    var to_user_id = data.to_user_id;
                    //console.log(to_user_id);
                    fetch_user(to_user_id);

            }
          }
        }
  }









	function update_last_activity()
	{
		//console.log('https://app.phone403.com/php/update_last_activity:' + localStorage.getItem("login_details_id"));
    app.request.promise.post('https://app.phone403.com/php/update_last_activity.php', { login_details_id:localStorage.getItem("login_details_id")})
      .then(function (data) {

      });

	}


	function fetch_user_chat_history(to_user_id)
	{
		// console.log('https://app.phone403.com/php/fetch_user_chat_history ' + to_user_id);
    //
    // // app.request.promise.post('https://app.phone403.com/php/fetch_user_chat_history.php', { from_user_id:localStorage.getItem("from_user_id"), to_user_id:to_user_id})
    //     app.request.promise.post('https://app.phone403.com/php/fetch_chat_messages.php', { from_user_id:localStorage.getItem("from_user_id"), to_user_id:to_user_id})
    //   .then(function (data) {
    //   });
	}




// function fetch_chat_message(to_user_id)
// {
// 	//console.log('https://app.phone403.com/php/fetch_chat_messages : '+to_user_id);
//     app.request.promise.post('https://app.phone403.com/php/fetch_chat_message.php', { from_user_id:localStorage.getItem("from_user_id"), to_user_id:to_user_id})
//       .then(function (receiveData) {
//         //localStorage.setItem('messages'+to_user_id, messageDumpReceived);
//
//           if ( receiveData.length > 10) {
//
//             console.log(receiveData);
//
//             console.log(' !!! NEW MESSAGES !!');
//
//           self.messages.addMessages(receiveData);
//
//           }
//       });
// }




function fetch_chat_messages_history(to_user_id)
{

//console.log('https://app.phone403.com/php/fetch_chat_messages_history : '+to_user_id);

if(to_user_id !== localStorage.to_user_id) {
    app.request.promise.post('https://app.phone403.com/php/fetch_chat_messages_history.php', { from_user_id:localStorage.getItem("from_user_id"), to_user_id:to_user_id})
      .then(function (messageDumpReceived) {
          if(messageDumpReceived.length > 20){
              console.log('Receive We have new data! app.js');
              //console.log(messageDumpReceived);
              var obj = JSON.parse(messageDumpReceived);
              //console.log(obj);
              if(obj.avatar === '')
                {
                //console.log('obj.avatar = empty');
                obj.avatar='https://cdn.framework7.io/placeholder/people-100x100-7.jpg'
              };

              var waitingmessages = obj.waitingmessages;
              var last_activity = moment();
              var last_message_time = obj.timestamp
              //console.log('last_message_time : ' +last_message_time);
              // search to_user_name in localsession contacts
              //console.log('search name from contacts storage');

              var data = JSON.parse(localStorage.listDataContacts);
              //console.log(obj.from_user_id);

              var objIndex = data.findIndex((x => x.to_user_id == obj.from_user_id));
              //console.log(objIndex);

              var to_user_name = data[objIndex].to_user_name;

              //console.log(to_user_name);

              var crypt = new JSEncrypt();
              crypt.setKey(localStorage.getItem('PrivateKey'));

              var crypted = obj.chat_message;
              //console.log('crypted : '+ crypted);
              var decrypted = crypt.decrypt(crypted);
              //console.log(decrypted);
              obj.chat_message = decrypted;
              obj.text = decrypted;

              if(obj.chat_message === ''){
                console.log('maybe image ;?');
                obj.chat_message = 'Image received...';
                obj.text = 'Image received...';
              }

              var item =
              {
                  "to_user_id":obj.from_user_id,
                  "header":obj.header,
                  "to_user_name":to_user_name,
                  "avatar":obj.avatar,
                  "last_activity":last_activity,
                  "waitingmessages":waitingmessages,
                  "last_message":obj.chat_message,
                  "last_message_time":last_message_time
                };




              if(virtualListChats.items.find(x => x.to_user_id === to_user_id))
              {
                   console.log('id is in virtualListChats');

                   var data = JSON.parse(localStorage.listDataChats);
                   // var last_activity = moment();
                   //
                   // objIndex = data.findIndex((obj => obj.to_user_id == to_user_id)); // find index
                   //
                   // //data[objIndex].last_activity = last_activity; // update last_activity
                   //
                   // data.splice(objIndex, 1); // delete op index find
                   var objIndex = virtualListChats.items.findIndex(obj => obj.to_user_id === to_user_id);
                   console.log('id is in virtualListChats objIndex: ' +objIndex );
                   virtualListChats.deleteItem(objIndex);
                   virtualListChats.prependItem(item);
                   localStorage.listDataChats = JSON.stringify(virtualListChats.items);
              }
              else
              {
                 console.log('virtualListChats.items');
                 console.log(virtualListChats.items);
                 virtualListChats.prependItem(item);
                 localStorage.listDataChats = JSON.stringify(virtualListChats.items);
                 console.log('localStorage.listDataChats');
                 console.log(localStorage.listDataChats);
                 console.log('id is not in virtualListChats');
              }

              if(localStorage.getItem('messages'+to_user_id))
              {
                console.log('localStorage : ' +to_user_id);
                var data = [];
                var objHistory = JSON.parse(localStorage.getItem('messages'+to_user_id));
                // console.log('obj ' + obj);
                // console.log(obj);
                for (var key in objHistory) {
                    var object = objHistory[key];
                    data.push(object);
                }

                var obj = JSON.parse(messageDumpReceived);
                obj.footer = '';
                var crypt = new JSEncrypt();
                crypt.setKey(localStorage.getItem('PrivateKey'));
                var crypted = obj.chat_message;
                //console.log('crypted : '+ crypted);
                var decrypted = crypt.decrypt(crypted);
                //console.log(decrypted);
                obj.chat_message = decrypted;
                obj.text = decrypted;


                data.push(obj);
                localStorage.setItem('messages'+to_user_id, JSON.stringify(data));
              }
              else
              {

                  console.log('Dont localStorage : ' +to_user_id);

                  var data = [];
                  var obj = JSON.parse(messageDumpReceived);

                  obj.footer = '';
                  var crypt = new JSEncrypt();
                  crypt.setKey(localStorage.getItem('PrivateKey'));
                  var crypted = obj.chat_message;
                  console.log('crypted : '+ crypted);
                  var decrypted = crypt.decrypt(crypted);
                  console.log(decrypted);
                  obj.chat_message = decrypted;
                  obj.text = decrypted;

                  data.push(obj);

                  localStorage.setItem('messages'+to_user_id, JSON.stringify(data));

                  //localStorage.setItem('messages'+to_user_id, messageDumpReceived);
              }
              console.log('notifications');

              var notificationCallbackOnClose = app.notification.create({
                icon: '<i class="icon demo-icon">'+obj.avatar+'</i>',
                title: '403 Chat - ' + obj.from_user_id,
                titleRightText: 'now',
                // subtitle: 'Notification with close on click',
                text: obj.text,
                closeOnClick: true,
                on: {
                  close: function () {
                    console.log('Notification closed');
                  },
                },
              });


playNotificationSound(sound);

              notificationCallbackOnClose.open();
              console.log('notifications');
              setTimeout(function() {
                  notificationCallbackOnClose.close();
              },4000);

          };
      });
    }
    else {
      //console.log('Global check message skip active user : ' +to_user_id);
    }

      // end if
}

function fetch_chat_messages()
{
		console.log('Check in background all accounts for new message.');
      if(localStorage.listDataContacts){
          var obj = JSON.parse(localStorage.listDataContacts);
          //console.log(obj);
          for (var key in obj) {
              var data = obj[key];
              //console.log(data);
              if (data.to_user_id != null) {
                  var to_user_id = data.to_user_id;
                  //console.log('Fn fetch_chat_messages' + to_user_id);
                  // fetch_chat_message(to_user_id);
                  fetch_chat_messages_history(to_user_id);
          }
        }
      }
}










	function update_chat_history_data()
	{
		console.log('1update_chat_history_data : ' );

		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');

			fetch_user_chat_history(to_user_id);

		});
	}





  // $('.messagebar-area').on('focus', function(){
  //   console.log('chat_message blur START typing' + localStorage.getItem("login_details_id"));
	// 	var is_type = 'yes';
  //
  //   app.request.promise.post('https://app.phone403.com/php/update_is_type_status.php', { login_details_id:localStorage.getItem("login_details_id"), is_type:is_type })
  //     .then(function (data) {
  //       console.log(data);
  //       console.log(localStorage.getItem("from_user_id"));
  //     });
	// });
  //
	// $('.messagebar-area').on('blur', function(){
  //   console.log('chat_message blur stop typing' + localStorage.getItem("from_user_id"));
	// 	var is_type = 'no';
  //
  //   app.request.promise.post('https://app.phone403.com/php/update_is_type_status.php', { login_details_id:localStorage.getItem("login_details_id"), is_type:is_type })
  //     .then(function (data) {
  //       console.log(data);
  //       console.log(localStorage.getItem("from_user_id"));
  //     });
	// });


	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#is_active_group_chat_window').val('no');
	});

	// $(document).on('focus', '.messagebar', function(){
  //   console.log('chat_message blur START typing' + localStorage.getItem("login_details_id"));
	// 	var is_type = 'yes';
  //
  //   app.request.promise.post('https://app.phone403.com/php/update_is_type_status.php', { login_details_id:localStorage.getItem("login_details_id"), is_type:is_type })
  //     .then(function (data) {
  //       console.log(data);
  //       console.log(localStorage.getItem("from_user_id"));
  //     });
	// });
  //
	// $(document).on('blur', '.messagebar', function(){
  //   console.log('chat_message blur stop typing' + localStorage.getItem("from_user_id"));
	// 	var is_type = 'no';
  //
  //   app.request.promise.post('https://app.phone403.com/php/update_is_type_status.php', { login_details_id:localStorage.getItem("login_details_id"), is_type:is_type })
  //     .then(function (data) {
  //       console.log(data);
  //       console.log(localStorage.getItem("from_user_id"));
  //     });
	// });

	// $('#group_chat_dialog').dialog({
	// 	autoOpen:false,
	// 	width:400
	// });

	// $('#group_chat').click(function(){
	// 	$('#group_chat_dialog').dialog('open');
	// 	$('#is_active_group_chat_window').val('yes');
	// 	fetch_group_chat_history();
	// });

	// $('#send_group_chat').click(function(){
	// 	var chat_message = $('#group_chat_message').html();
	// 	var action = 'insert_data';
	// 	if(chat_message != '')
	// 	{
	// 		$.ajax({
	// 			url:"group_chat.php",
	// 			method:"POST",
	// 			data:{chat_message:chat_message, action:action},
	// 			success:function(data){
	// 				$('#group_chat_message').html('');
	// 				$('#group_chat_history').html(data);
	// 			}
	// 		})
	// 	}
	// });

	function fetch_group_chat_history()
	{
		console.log('fetch_group_chat_history');
		var group_chat_dialog_active = $('#is_active_group_chat_window').val();
		var action = "fetch_data";
		if(group_chat_dialog_active == 'yes')
		{
			$.ajax({
				url:"https://app.phone403.com/php/group_chat.php",
				method:"POST",
				data:{action:action},
				success:function(data)
				{
					$('#group_chat_history').html(data);
				}
			})
		}
	}

	// $('#uploadFile').on('change', function(){
	// 	$('#uploadImage').ajaxSubmit({
	// 		target: "#group_chat_message",
	// 		resetForm: true
	// 	});
	// });
//
// });






$(document).on('click', '.remove_chat', function(){
  var chat_message_id = $(this).attr('id');
  if(confirm("Are you sure you want to remove this chat?"))
  {
    app.request.promise.post('https://app.phone403.com/php/remove_chat.php', { from_user_id:localStorage.getItem("from_user_id"), chat_message_id:chat_message_id })
      .then(function (data) {
        console.log(data);
        console.log(localStorage.getItem("from_user_id"));
      });

   // $.ajax({
   //  url:"https://app.phone403.com/php/remove_chat.php",
   //  method:"POST",
   //  data:{chat_message_id:chat_message_id},
   //  success:function(data)
   //  {
   //   update_chat_history_data();
   //  }
   // })
  }
 });

 function playNotificationSound(sound) {
     //console.log('----------- playSound event -----------');

         if (sound) {
             //console.log('----------- have sound -----------' + sound);
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




 $('.list-data-chats.swipeout').on('swipeout:open', 'li', function () {
   console.log('list-data-chats swipeout:open');
   var index = $(this).index();

   console.log('index : ' + index);

   virtualListChats.deleteItem(index);

   localStorage.listDataChats = JSON.stringify(virtualListChats.items);

 })

 $('.tab-contacts .swipeout').on('swipeout:open', 'li', function () {

   console.log('list-data-contacts swipeout:open');
   var index = $(this).index();

   console.log('index : ' + index);

   // virtualListContacts.deleteItem(index);
   //
   // localStorage.listDataChats = JSON.stringify(virtualListContacts.items);

 })

 $('.tab-contacts .swipeout').on('open',function () {
 console.log('swipeout-delete');
 });

 $('.tab-contacts .swipeout').on('opened',function () {
 console.log('swipeout-delete');
 });

 $('.swipeout-delete').on('click', 'li', function () {
 console.log('swipeout-delete click');
 var index = $(this).index();

 console.log('index : ' + index);
 });


 $('.deleted-callback').on('swipeout:deleted', function () {
   console.log('Thanks, item removed!');
 });

 // $$(document).on('page:init', function (e) {
 //   // Do something here when page loaded and initialized
 // })


//
//
// var to_user_id = $('a').data('to_user_id');
// console.log(to_user_id);
