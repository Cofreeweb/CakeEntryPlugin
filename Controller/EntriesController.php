<?php
App::uses('EntryAppController', 'Entry.Controller');
/**
 * Entries Controller
 *
 */
class EntriesController extends EntryAppController 
{
  
  public function beforeFilter()
  {
    parent::beforeFilter();
    
    if( isset( $this->Auth))
    {
      $this->Auth->allow();
    }
  }
  public function view()
  {
    $entry = $this->Entry->getEntry( $this->request->params ['section_id']);
    $this->set( compact( 'entry'));
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
  
  public function rest_orderblocks()
  {
    if( isset( $this->request->data ['entry-block']))
    {
      foreach( $this->request->data ['entry-block'] as $key => $id)
      {
        $this->Entry->Block->id = $id;
        $this->Entry->Block->saveField( 'position', ($key+1));
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
}
