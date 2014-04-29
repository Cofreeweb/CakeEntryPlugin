adminApp.directive('uploadGallery', function( $rootScope) {
  return {
    restrict: 'A',
    // scope: {
    //   uploadedFilesModel: '='
    // },
    link: function( scope, element, attr) {
      scope.uploader = new qq.FineUploader({
        debug: false,
        element: element[0],
        multiple: true,
        request: {
          endpoint: attr.uploadDestination,
          inputName: 'filename'      
        },
        validation: {
          allowedExtensions: attr.uploadExtensions.split(',')
        },
        text: {
            uploadButton: attr.buttonText || '<i class="icon-upload icon-white"></i> Upload File(s)'
        },
        template: '<div class="qq-uploader">' +
                    '<pre class="qq-upload-drop-area"><span>{dragZoneText}</span></pre>' +
                    '<div class="qq-upload-button btn btn-info" style="width:auto;">{uploadButtonText}</div>' +
                    '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
                    '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
                  '</div>',
        classes: {
          success: 'alert alert-success',
          fail: 'alert alert-error'
        },
        fileTemplate: "<li>" +
            "<div class=\"qq-progress-bar\"></div>" +
            "<span class=\"qq-upload-spinner\"></span>" +
            "<span class=\"qq-upload-finished\"></span>" +
            "<span class=\"qq-upload-image\"></span>" +
            "<span class=\"qq-upload-file\"></span>" +
            "<span class=\"qq-upload-size\"></span>" +
            "<a class=\"qq-upload-cancel\" href=\"#\">{cancelButtonText}</a>" +
            "<a class=\"qq-upload-retry\" href=\"#\">{retryButtonText}</a>" +
            "<span class=\"qq-upload-status-text\">{statusText}</span>" +
            "</li>",
        callbacks: {
          onComplete: function( id, name, response, xhr){
              // ERROR
              if( !response.upload){
                return;
              }
              
              // Actualiza el scope
              eval( 'if($rootScope.' + attr.scopeVar + ') {$rootScope.' + attr.scopeVar + '.push( response.upload); $rootScope.$apply();}');

              // Si hubiera sido seteado en los atributos el element de flexslider, éste se actualiza
              if( attr.flexslider) {
                var options = $(attr.flexslider).data( 'flexslider').data( 'options');
                $(attr.flexslider).flexslider( 'destroy');
                $(attr.flexslider).flexslider(options);
              }
              // Se añade al scope
              if( attr.uploadScope) {
                eval( 'scope.' + attr.uploadScope + '.push(response.upload);');
                scope.$apply();
                
                // Borra el elemento que ha creado el uploader
                $(".qq-upload-list li", element).remove();
              } else {
                $(".qq-upload-list", element).append( response.body);
              }
              
              $(".qq-upload-success", element).remove();
              // var uploader = $(element).data( "fineuploader").uploader;
              // if( uploader._netUploaded >= uploader._options.validation.itemLimit) {
              //   $(".qq-upload-button", element).hide();
              // }
              if( !response.success && response.error){
                var item = uploader.getItemByFileId(id);
                qq(uploader._find(item, "statusText")).setText( response.error);
                qq(uploader._find(item, "statusText")).addClass( "qq-upload-failed-text");
              }
          }
        }
      });
    }
  };
});

adminApp.directive( 'deleteUpload', function( $document, $http, $rootScope, $dialogs){
  return {
    restrict: 'A',
    link: function( scope, element, attr, ctrl) {
      element.on('click', function(e) {
        var asset = scope.asset;
        var dlg = $dialogs.confirm( 'Confirmation Header','It is a simple "Yes" or "No"?');
				dlg.result.then( function(btn){
					$http.post( attr.url, {id: asset.id}).success( function( data) {
            angular.element( attr.el).remove();
            // Actualiza el scope
            eval( 'if($rootScope.' + attr.scopeVar + ') {var index = $rootScope.' + attr.scopeVar + '.indexOf( asset); $rootScope.' + attr.scopeVar + '.splice( index, 1); $rootScope.$apply();}');
            // Si hubiera sido seteado en los atributos el element de flexslider, éste se actualiza
             if( attr.flexslider) {
                var options = $(attr.flexslider).data( 'flexslider').data( 'options');
                $(attr.flexslider).flexslider( 'destroy');
                $(attr.flexslider).flexslider(options);
              }
          });
				},function( btn){
					console.log( 'milk');
				});
				
        
      });
    }
  }
});