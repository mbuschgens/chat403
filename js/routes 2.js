routes = [
  {
    path: '/',
    url: './index.html',
  },
  {
    path: '/about/',
    url: './pages/about.html',
  },
  {
    path: '/chat/',
    url: './pages/chat.html',
  },
  {
    path: '/new-registration/',
    url: './pages/new-registration.html',
  },
  {
    path: '/new-registration-living/',
    url: './pages/new-registration-living.html',
  },
  {
    path: '/new-registration-details/',
    url: './pages/new-registration-details.html',
  },
  {
    path: '/new-registration-bank/',
    url: './pages/new-registration-bank.html',
  },
  {
    path: '/job-selection/',
    url: './pages/job-selection.html',
  },
  {
    path: '/job-selection-additional/',
    url: './pages/job-selection-additional.html',
  },
  {
    path: '/first-impression/',
    url: './pages/first-impression.html',
  },
  {
    path: '/registration-finished/',
    url: './pages/registration-finished.html',
  },
  {
    path: '/file-uploader/',
    url: './pages/file-uploader.html',
  },
  {
    path: '/edit-registration/',
    url: './pages/edit-registration.html',
  },
  {
    path: '/search-registration/',
    url: './pages/search-registration.html',
  },
  {
    path: '/job-selection-experience/',
    url: './pages/job-selection-experience.html',
  },









  // Left View Pages
  {
    path: '/left-page-1/',
    url: './pages/left-page-1.html',
  },
  {
    path: '/left-page-2/',
    url: './pages/left-page-2.html',
  },
  // Page Loaders & Router
  {
    path: '/page-loader-template7/:user/:userId/:posts/:postId/',
    templateUrl: './pages/page-loader-template7.html',
  },
  {
    path: '/page-loader-component/:user/:userId/:posts/:postId/',
    componentUrl: './pages/page-loader-component.html',
  },
  {
    path: '/request-and-load/user/:userId/',
    async: function (routeTo, routeFrom, resolve, reject) {
      // Router instance
      var router = this;

      // App instance
      var app = router.app;

      // Show Preloader
      app.preloader.show();

      // User ID from request
      var userId = routeTo.params.userId;

      // Simulate Ajax Request
      setTimeout(function () {
        // We got user data from request
        var user = {
          firstName: 'Vladimir',
          lastName: 'Kharlampidi',
          about: 'Hello, i am creator of Framework7! Hope you like it!',
          links: [
            {
              title: 'Framework7 Website',
              url: 'http://framework7.io',
            },
            {
              title: 'Framework7 Forum',
              url: 'http://forum.framework7.io',
            },
          ]
        };
        // Hide Preloader
        app.preloader.hide();

        // Resolve route to load page
        resolve(
          {
            componentUrl: './pages/request-and-load.html',
          },
          {
            context: {
              user: user,
            }
          }
        );
      }, 1000);
    },
  },
  // Default route (404 page). MUST BE THE LAST
  {
    path: '(.*)',
    url: './pages/404.html',
  },
];
