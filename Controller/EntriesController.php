<?php
App::uses('EntryAppController', 'Entry.Controller');
/**
 * Entries Controller
 *
 */
class EntriesController extends EntryAppController 
{
  public $uses = array( 'Entry.Entry', 'Upload.Upload');
  
  public $helpers = array( 'Entry.Entry');
  
  public $components = array( 'Upload.Uploader');
  
  public function beforeFilter()
  {
    parent::beforeFilter();
    
    if( isset( $this->Auth))
    {
      $this->Auth->allow( 'view');
    }
  }
  public function view()
  {
    $revision = isset( $this->request->params ['edit']) ? 'draft' : 'published';
    $entry = $this->Entry->getEntry( $this->request->params ['section_id'], $revision);

    if( !$entry)
    {
      throw new NotFoundException( 'Entrada no encontrada');
    }
    
    $this->set( compact( 'entry'));
  }
  
  public function edit()
  {
    $this->view();
    $this->render( 'view');
  }
  
  public function published()
  {
    $entry = $this->Entry->getEntry( $this->request->params ['section_id'], 'draft');
    $this->Entry->published( $entry ['Entry']['id']);
    $this->redirect( array(
        'action' => 'view',
        'section_id' => $this->request->params ['section_id']
    ));
  }
  
  public function discard()
  {
    $entry = $this->Entry->getEntry( $this->request->params ['section_id'], 'draft');
    $this->Entry->discard( $entry ['Entry']['id']);
    $this->redirect( array(
        'action' => 'view',
        'section_id' => $this->request->params ['section_id']
    ));
  }
   
/**
 * Renderiza un bloque para la edición
 *
 * @param string $id 
 * @return void
 */
  public function block( $id)
  {
    $this->layout = 'ajax';
    $block = $this->Entry->findBlock( $id, 'draft');
    $this->set( compact( 'block'));
    $this->render( 'Blocks/types/'. $block ['type']);
  }
  
  public function rest_get()
  {
    // $entry = $this->Entry->getEntry( $this->request->params ['section_id']);
    $this->set( array(
        'entry' => array( 'body' => 'asd', 'sump' => 'Pedrín'),
        '_serialize' => array(
            'entry'
        )
    ));
  }
  
  public function orderblocks( $parent_id = false, $block_id = false)
  {
    if( isset( $this->request->data ['entry-block']))
    {
      if( $parent_id && $block_id)
      {
        $data = $this->Entry->moveSubdocument( $block_id, $parent_id, array(
            'path' => 'rows.blocks'
        ));
      }
      
      
      foreach( $this->request->data ['entry-block'] as $key => $id)
      {
        $this->Entry->updateSubdocument( 'rows.blocks', $id, array(
            'sort' => $key
        ), array(
            'revision' => 'draft'
        ));
      }      
      

      $success = true;
    }
    elseif( isset( $this->request->data ['entry-row']))
    {
      foreach( $this->request->data ['entry-row'] as $key => $id)
      {
        $this->Entry->updateSubdocument( 'rows', $id, array(
            'sort' => $key
        ), array(
            'revision' => 'draft'
        ));
      }
      
      $success = true;
    }
    else
    {
      $success = false;
    }
    
    $this->set( array(
        'success' => $success,
        '_serialize' => array(
            'success'
        )
    ));
  }
  
  
  public function upload()
  {
    $this->Uploader->uploadForMongo();
  }
  
  public function delete_upload()
  {
    $this->Entry->deleteSubdocument( 'rows.blocks.uploads', $this->request->data ['id']);
    $this->set( array(
        'success' => true,
        '_serialize' => array(
            'success'
        )
    ));
  }
}
