adminApp.directive('uploadGallery', function() {
  return {
    restrict: 'A',
    scope: {
      uploadedFilesModel: '='
    },
    link: function($scope, element, attributes) {
      $scope.uploader = new qq.FineUploader({
        debug: false,
        element: element[0],
        multiple: true,
        request: {
          endpoint: attributes.uploadDestination,
          inputName: 'filename'      
        },
        validation: {
          allowedExtensions: attributes.uploadExtensions.split(',')
        },
        text: {
            uploadButton: attributes.buttonText || '<i class="icon-upload icon-white"></i> Upload File(s)'
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
            "<a class=\"qq-upload-delete\" href=\"#\">{deleteButtonText}</a>" +
            "<span class=\"qq-upload-status-text\">{statusText}</span>" +
            "</li>",
        callbacks: {
          onComplete: function( id, name, response, xhr){
              $(".qq-upload-list", element).append( response.body);
              $(".qq-upload-success", element).remove();
              var uploader = $(element).data( "fineuploader").uploader;
              if( uploader._netUploaded >= uploader._options.validation.itemLimit) {
                $(".qq-upload-button", element).hide();
              }
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