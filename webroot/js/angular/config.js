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
      // Muestra la ventana para añadir un nuevo bloque
      when('/blocks/add/:row_id', {
        templateUrl: '/angular/template?t=Entry.blocks/add',
        controller: 'BlocksAddCtrl'
      }).
      // Nueva fila
      when('/blocks/addrow/:entry_id', {
        template: '',
        controller: 'BlocksAddRowCtrl'
      }).
      // Borra un bloque
      when('/blocks/delete/:id', {
        template: '',
        controller: 'BlocksDeleteCtrl'
      }).
      // Borra una fila
      when('/blocks/delete_row/:id', {
        template: '',
        controller: 'BlocksDeleteRowCtrl'
      })
  }
]);