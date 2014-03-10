<?php


/**
 * EntryHelper
 * 
 * [Short Description]
 *
 * @package entry.view.helper
 **/

class EntryHelper extends AppHelper 
{

  public $helpers = array( 'Html', 'Form', 'Acl.Auth');
  
  public function beforeLayout()
  {
    if( $this->Auth->isEditor())
    {
      $script = '$(".blocks").sortable({
        items: ".inline-entry-block-sortable",
        handle: ".sortable-move",
        update: function( event, ui){
          $.ajax({
            type: "post",
            url: "/rest/entry/entries/orderblocks.json",
            data: $(this).sortable( "serialize"),
            success: function( data){
              
            }
          });
        }
      })';
      
      
      $this->Html->scriptBlock( $script, array(
          'inline' => false,
      	  'block' => 'scriptBottom'
      ));
    }
  }
  
  public function adminAdd()
  {
    if( !$this->Auth->isEditor())
    {
      return false;
    }
    
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
  
  public function setEntry()
  {
    $entry = $this->_View->viewVars ['entry'];
    
    // $blocks = array();
    // 
    // foreach( $entry ['Block'] as $block)
    // {
    //   $blocks [$block ['id']] = $block;
    // }
    // 
    // unset( $entry ['Block']);
    // $entry ['Block'] = $blocks;

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
}