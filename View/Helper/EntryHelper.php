<?php

/**
 * EntryHelper
 * 
 * Ayudante de las entries
 *
 * @package entry.view.helper
 **/

class EntryHelper extends AppHelper 
{

  public $helpers = array( 'Html', 'Form', 'Acl.Auth', 'Management.Inline', 'Angular.Seter');
  
/**
 * Carga el javascript necesario para la edición de las entries
 *
 * @return void
 */
  public function beforeLayout()
  { 
    if( $this->Inline->isModeEditor() && !$this->request->is( 'ajax') && !$this->request->accepts( 'application/json'))
    {
      $script = '$(".rows").sortable({
        items: ".inline-entry-row-sortable",
        handle: ".sortable-move-row",
        update: function( event, ui){
          $.ajax({
            type: "post",
            url: "/entry/entries/orderblocks.json",
            data: $(this).sortable( "serialize"),
            success: function( data){
              
            }
          });
        }
      });';
      
      $script .= '$(".blocks").sortable({
        items: ".inline-entry-block-sortable",
        handle: ".sortable-move",
        connectWith: ".row-group",
        placeholder: "ui-state-highlight",
        update: function( event, ui){
          var parent_id = ui.item.parents( ".inline-entry-row-sortable").data( "id");
          var block_id = ui.item.data( "id");
          $.ajax({
            type: "post",
            url: "/entry/entries/orderblocks/" + parent_id + "/" + block_id + ".json",
            data: $(this).sortable( "serialize"),
            success: function( data){
              
            }
          });
        }
      });';
      
      $this->Html->scriptBlock( $script, array(
          'inline' => false,
      	  'block' => 'scriptBottom'
      ));
      
      $this->Html->script( array(
          '/entry/js/angular/controllers.js',
          '/entry/js/angular/config.js',
          '/upload/js/all.fineuploader-3.9.1.min',
          '/entry/js/angular/directives/upload_gallery.js',
          '/management/js/ckeditor/ckeditor',
          '/management/js/angular/directives/ckeditor',
          '/entry/js/angular/components/ckeditor.js',
          '/upload/js/upload.js'
    	), array(
    	  'inline' => false,
    	  'block' => 'scriptBottom'
    	));

    	$this->setEntry();
    }
  }
  
  public function addRow( $entry)
  {
    if( !$this->Inline->isModeEditor())
    {
      return false;
    }
      	
  	return '<a href="#blocks/addrow/'. $entry ['Entry']['id'] .'">'. __d( 'admin', 'Añadir fila') .'</a>';
  }
  
  public function addBlock( $row_id = '{{row_id}}')
  {
    if( !$this->Inline->isModeEditor())
    {
      return false;
    }
    
    return '<a  href="#blocks/add/'. $row_id .'">'. __d( 'admin', 'Añadir bloque') .'</a>';
  }
  
/**
 * Setea el javascript necesario de AngularJS para la edición de la entry
 *
 * @return void
 */
  public function setEntry()
  {
    // Toma la entry de la vista
    $entry = $this->_View->viewVars ['entry'];
    
    // Setea la entry en el $rootScope de AngularJS
    $script = 'adminApp.run( function( $rootScope){
      $rootScope.entry = '. json_encode( $entry) .';
    });';
    
    $this->Html->scriptBlock( $script, array(
        'inline' => false,
    	  'block' => 'scriptBottom'
    ));
    
    $this->Html->script( array(
        '/entry/js/entry.js',
  	), array(
  	  'inline' => false,
  	  'block' => 'scriptBottom'
  	));
  }
  
  public function buttonDeleteRow( $row_id)
  {
    if( !$this->Inline->isModeEditor())
    {
      return false;
    }

    return '<span data-header="'. __d( "admin", "¿Estás seguro de que quieres borrar esta fila?") .'" delete-content="/entry/blocks/delete_row.json" data-id="'. 
      $row_id .'" data-remove="#entry-row-'. $row_id .'">'. __d( 'admin', 'Eliminar') .'</span>';
  }
  
/**
 * Botón para borrar un bloque
 *
 * @param array $block 
 * @return void
 */
  public function buttonDeleteBlock( $block = null)
  {
    if( !$this->Inline->isModeEditor())
    {
      return false;
    }
    
    return '<span data-header="'. __d( "admin", "¿Estás seguro de que quieres borrar este bloque?") .'" delete-content="/entry/blocks/delete.json" data-id="'. 
      $block ['id'] .'" data-remove="#entry-block-'. $block ['id'] .'">'. __d( 'admin', 'Eliminar') .'</span>';
    
  }
}