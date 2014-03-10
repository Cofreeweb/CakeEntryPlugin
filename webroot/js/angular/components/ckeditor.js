CKEDITOR.on( 'instanceCreated', function( event ) {
	var editor = event.editor,
		element = editor.element;
		
    // Guarda la información en la base de datos cuando se hace click fuera
    editor.on('blur', function( e){
        var data = event.editor.getData();
        $.ajax({
          type: 'post',
          url: editor.element.data( 'url'),
          data: {
            id: editor.element.data( 'id'),
            value: data,
            field: editor.element.data( 'field')
          }
        })
        // do some ajax stuff
    });
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