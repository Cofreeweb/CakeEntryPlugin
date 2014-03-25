/**
* BlocksAddRowCtrl

* Creación de una fila
*
*/
adminApp.controller( 'BlocksAddRowCtrl', function( $scope, $routeParams, $http, $compile, $rootScope, $location) {
    if( $routeParams.entry_id) {
      $scope.entry_id = $routeParams.entry_id;
    }
        
    // Creación de un nuevo bloque
    if( $routeParams.entry_id) {
      $http.post( '/entry/blocks/addrow.json', {
        entry_id: $routeParams.entry_id,
      }).success(function( data){
        $scope.row_id = data.row_id;
        
        $scope.template = '/angular/template?t=Entry.blocks/row';
        // Añade el HTML de la nueva fila
        var html = '<div id="entry-row-' + data.row_id + '" class="row inline-entry-row-sortable" ng-include="template">asdfsd</div>'
        angular.element( '.blocks').append( $compile( html)($scope))
      });      
    }    
});


// BlocksAddCtrl
// Añade un block nuevo
adminApp.controller( 'BlocksAddCtrl', function( $scope, $routeParams, $http, $compile, $rootScope, $location) {
    if( $routeParams.row_id) {
      $scope.row_id = $routeParams.row_id;
    }
    // Creación de un nuevo bloque
    if( $routeParams.row_id && $routeParams.type) {
      $http.post( '/entry/blocks/add.json', {
        row_id: $routeParams.row_id,
        type: $routeParams.type
      }).success(function( data){
        $scope.block = data.block;
        $rootScope.entry.Entry.rows[data.block.row_key].blocks.push( data.block);
        
        // Es un tipo de bloque que se va a renderizar de inmediato, una vez creado
        if( $routeParams.type && data.afterCreate == 'render') {
          $scope.template = '/angular/template?t=Entry.blocks/types/' + $routeParams.type;
        } else if( data.afterCreate == 'edit'){
          $location.url( '/blocks/edit/' + data.block.id);
          $scope.template = '/angular/template?t=Entry.blocks/elements/button_edit';
        } else {
          $scope.template = '/angular/template?t=Entry.blocks/elements/button_edit';
        }
        
        
        // Añade el HTML del nuevo block
        var html = '<div id="entry-block-' + data.block.id + '" class="block connected-sortable inline-entry-block-sortable" ng-include="template"></div>';
        angular.element( '#entry-row-' + $routeParams.row_id + ' .row-group').append( $compile( html)($scope))
      });      
    }    
});

/**
* Edición de los bloques con cuadro de edición, es decir, los que no son inline
*
*/
adminApp.controller( 'BlocksEditCtrl', function( $scope, $routeParams, $http, $compile, $rootScope) {
    $http.get('/entry/blocks/edit/' + $routeParams.id +'.json').success( function(data) {
      $scope.block = data.block;
      $scope.template = '/angular/template?t=Entry.blocks/edit/' + data.block.type;
    });
    
    $scope.submitBlock = function( action){
      $http.post( '/admin/entry/blocks/edit.json', $scope.block).success( function( data){

      })
    }
    
    // Actualiza el bloque
    $scope.update = function(){
      if( !$scope.block) {
        return;
      }
      
      var id = $scope.block.id;
      $http.get( '/entry/entries/block/' + id).success( function( data){
        angular.element( '#entry-block-' + id).html( data);
        angular.element( '#entry-block-' + id + ' a').bind('click', function(e) {
          // this part keeps it from firing the click on the document.
          e.stopPropagation();
        });
      });
      
      
    }
});

/**
* Borrado de los bloques
*
*/
adminApp.controller( 'BlocksDeleteCtrl', function( $scope, $routeParams, $http) {
    $http.get('/entry/blocks/delete/' + $routeParams.id +'.json').success( function(data) {
    });
    
    angular.element( '#entry-block-' + $routeParams.id).remove();
});


adminApp.controller( 'EntriesViewCtrl', function( $scope, $routeParams, $http) {
  

});
