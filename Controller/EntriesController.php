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
        'entry' => array( 'body' => 'hostias', 'sump' => 'Pedrín'),
        '_serialize' => array(
            'entry'
        )
    ));
  }
  
  public function orderblocks( $parent_id = false, $block_id = false)
  {
    if( isset( $this->request->data ['entry-block']))
    {
      foreach( $this->request->data ['entry-block'] as $key => $id)
      {
        $this->Entry->updateSubdocument( 'rows.blocks', $id, array(
            'sort' => $key
        ), array(
            'revision' => 'draft'
        ));
      }      
      
      if( $parent_id && $block_id)
      {
        $data = $this->Entry->moveSubdocument( $block_id, $parent_id, array(
            'path' => 'rows.blocks'
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
    // La configuración del upload
    $config = Configure::read( 'Upload.'. $this->request->query ['key']);
    $config ['config']['fields'] = array(
		    'dir' => 'path',
		    'type' => 'mimetype'
		);
		
    // Lee el Behavior Upload.Upload para el model asociado, pasándole los datos indicados en la configuración anteriormente leída
    $this->Upload->Behaviors->load( 'Upload.Upload', array( 
        'filename' => $config ['config'],
    ));
    
    // Los datos a guardar
    $data = $this->request->params ['form'];
    $data ['content_type'] = $this->request->query ['key'];
    $data ['model'] = $this->request->query ['model'];
    
    if( isset( $this->request->query ['content_id']))
    {
      $data ['content_id'] = $this->request->query ['content_id'];
    }

    if( $this->Upload->save( $data))
    {
      $last = $this->Upload->read( null);
      $photo_id = $this->Entry->addSubdocument( $last ['Upload'], array(
          'id' => $this->request->query ['content_id'],
          'path' => 'rows.blocks.photos'
      ));
      
      $this->set( 'success', true);
      
      App::uses('JsonView', 'View');
      $View = new JsonView($this);
            
      if( isset( $this->request->params ['admin']))
      {
        $body = $View->element( 'json/'. $config ['type'], array(
            'upload' => $last ['Upload'],
            'alias' => $this->request->query ['alias']
        ));
      }
      else
      {
        $body = $View->element( 'uploads/json/'. $config ['template'], array(
            'upload' => $last ['Upload'],
            'alias' => $this->request->query ['alias']
        ));
      }
      
      
      if( isset( $config ['thumbnailSizes']))
      {
        $last ['Upload']['thumbail'] = UploadUtil::thumbailPathMulti( $last);
      }
      
      $this->set( 'upload', $last ['Upload']);
      $this->set( compact( 'body'));
      $this->set( '_serialize', array( 'success', 'upload', 'body'));
    }
    else
    {
      $errors = $this->Upload->invalidFields();
      
      if( isset( $errors ['filename']))
      {
        $this->set( 'error', current( $errors ['filename']));
      }
      else
      {
        $this->set( 'error', false);
      }

      $this->set( 'success', false);
      $this->set( '_serialize', array( 'success', 'error'));
    }
  }
}
