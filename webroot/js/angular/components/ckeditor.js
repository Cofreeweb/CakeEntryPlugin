

CKEDITOR.on( 'instanceCreated', function( event ) {
	var editor = event.editor,
	element = editor.element;
	
  // Previene hacer blur en aquellos editores que no están activos
  editor.closeOnBlur = false;
  
  // No permite hacer blur. Solo si se ha pulsado el botón "Cancel" o "Save"
  editor.on('blur', function( e){
    if( !editor.closeOnBlur) {
      return false;
    }
    editor.closeOnBlur = false;
  });

	editor.on( 'focus', function( e){
    editor.noChangesData = editor.getData();
	});
	
	// Evita hacer focus en el editor que no está siendo editado
	editor.element.on( 'focus', function( e){
	  if( CKEDITOR.currentInstance && CKEDITOR.currentInstance != editor) {
	    CKEDITOR.currentInstance.focus();
	    return false;
	  }
	})
    
    
	// Customize editors for headers and tag list.
	// These editors don't need features like smileys, templates, iframes etc.
	if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {
		// Customize the editor configurations on "configLoaded" event,
		// which is fired after the configuration file loading and
		// execution. This makes it possible to change the
		// configurations before the editor initialization takes place.
		editor.on( 'configLoaded', function() {
			// Remove unnecessary plugins to make the editor simpler.
			editor.config.removePlugins = 'colorbutton,find,flash,font,' +
				'forms,iframe,image,newpage,removeformat,' +
				'smiley,specialchar,stylescombo,templates';
      
      editor.config.extraPlugins = 'save';
      
			// Rearrange the layout of the toolbar.
			editor.config.toolbarGroups = [
				{ name: 'editing', groups: [ 'basicstyles', 'links']},
				{ name: 'undo' },
				{ name: 'clipboard', groups: [ 'selection', 'clipboard']},
				{ name: 'about' }
			];
		});
	}
});