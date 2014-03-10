// BlocksAddCtrl
// Añade un block nuevo
adminApp.controller( 'BlocksAddCtrl', function( $scope, $routeParams, $http, $compile, $rootScope) {
    if( $routeParams.entry_id) {
      $scope.entry_id = $routeParams.entry_id;
    }
    
    if( $routeParams.entry_id && $routeParams.type) {
      $http.post( '/rest/entry/blocks/add.json', {
        entry_id: $routeParams.entry_id,
        type: $routeParams.type
      }).success(function( data){
        $scope.block = data.block;
        $rootScope.entry.Block.push( data.block);

        if( $routeParams.type) {
          $scope.template = '/angular/template?t=Entry.blocks/types/' + $routeParams.type;
        }
        
        // Añade el HTML del nuevo block
        var html = '<div id="entry-block-' + data.block.Block.id + '" class="inline-entry-block-sortable" ng-include="template"></div>';
        angular.element( '.blocks').append( $compile( html)($scope))
      });      
    }    
});

adminApp.controller( 'BlocksEditCtrl', function( $scope, $routeParams, $http, $compile, $rootScope) {
    $http.get('/rest/entry/blocks/edit/' + $routeParams.id +'.json').success( function(data) {
      $scope.block = data.block;
      $scope.template = '/angular/template?t=Entry.blocks/edit/' + data.block.Block.type;
    });
    
    $scope.submitBlock = function( action){
      $http.post( '/admin/entry/blocks/' + action + '.json', $scope.block.Block).success( function( data){

      })
    }
    
    // Actualiza el bloque
    $scope.update = function(){
      var id = $scope.block.Block.id;
      $http.get( '/entry/blocks/view/' + id).success( function( data){
        angular.element( '#entry-block-' + id).html( data);
        angular.element( '#entry-block-' + id + ' a').bind('click', function(e) {
          // this part keeps it from firing the click on the document.
          e.stopPropagation();
        });
      });
      
      
    }
});

adminApp.controller( 'EntriesViewCtrl', function( $scope, $routeParams, $http) {
  

});
