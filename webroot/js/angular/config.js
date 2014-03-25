adminApp.config( ['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      // Edición de bloque
      when('/blocks/edit/:id', {
        templateUrl: '/angular/template?t=Entry.blocks/edit',
        controller: 'BlocksEditCtrl'
      }).
      // Nuevo bloque
      when('/blocks/type/:row_id/:type', {
        template: '',
        controller: 'BlocksAddCtrl'
      }).
      when('/blocks/add/:row_id', {
        templateUrl: '/angular/template?t=Entry.blocks/add',
        controller: 'BlocksAddCtrl'
      }).
      when('/blocks/addrow/:entry_id', {
        template: '',
        controller: 'BlocksAddRowCtrl'
      }).
      when('/blocks/delete/:id', {
        template: '',
        controller: 'BlocksDeleteCtrl'
      })
  }
]);