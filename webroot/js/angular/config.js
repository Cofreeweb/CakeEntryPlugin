adminApp.config( ['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/blocks/edit/:id', {
        templateUrl: '/angular/template?t=Entry.blocks/edit',
        controller: 'BlocksEditCtrl'
      }).
      when('/blocks/type/:entry_id/:type', {
        template: '',
        controller: 'BlocksAddCtrl'
      }).
      when('/blocks/add/:entry_id', {
        templateUrl: '/angular/template?t=Entry.blocks/add',
        controller: 'BlocksAddCtrl'
      })
  }
]);